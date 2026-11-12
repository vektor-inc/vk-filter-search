#!/bin/bash
#
# PHP 7.4 の CI で wp-env のイメージを組み立てられるようにする。
#
# 2026-09 時点で対象になるのは wordpress:php7.4 だけ。bullseye は保守が
# 終わって引き上げの途中にあり、既定の取得先（deb.debian.org）では
# 次の 2 つが順に起きる。
#
#   1. bullseye-security の Release ファイルが期限切れになり、
#      apt-get update が exit 100 で終わる
#   2. Release ファイルはまだ配られているのに、その中で参照している
#      パッケージの実体が消えており、apt-get install が 404 で終わる
#
# どちらも wp-env のイメージの組み立てをそこで止める。
# 対象かどうかは PHP のバージョンではなく、イメージの /etc/os-release で判定する。
#
# 取得先を archive.debian.org の bullseye に固定する。
# wp-env 自身も stretch に対して同じ趣旨の書き換えを Dockerfile に入れている
# （"Update apt sources for archived versions of Debian"）。
# Dockerfile を組み立てるファイルの場所は wp-env の版で変わるため、下の
# 候補から探す（Pro・無料版・海外版で同じ内容にそろえている。直すときは3つとも直す）。
#   10.16 系: lib/init-config.js
#   10.39 系: lib/runtime/docker/init-config.js
#   12 系:    lib/runtime/docker/docker-config.js
#             （12.1 は bullseye も archive へ向ける sed を持つが、
#              ここでの書き換えはその後で sources.list を丸ごと置き換える）
#
# **sources.list は丸ごと 1 行に置き換えている。** 落ちるのは security だけでなく、
# bullseye-updates と、main 以外のコンポーネント（contrib / non-free）も含む。
# security を残せないのは、bullseye-security が archive.debian.org にまだ無く
# （2026-09 時点で buster までしか無い）、残すと update が Release ファイルを
# 引けずに止まるため。ほかは、必要なもの（$PHPIZE_DEPS / git / sudo）が
# すべて main にあるので絞っている。
# つまりこのイメージには bullseye の最後の security 更新が入らない。
# CI でテストを走らせるためだけの使い捨てのコンテナなので、そこは許容している。
# archive.debian.org に bullseye-security が現れたら、その行を足せる。
#
# 期限の確認（Acquire::Check-Valid-Until）も外す。archive.debian.org の
# Release ファイルも期限切れのままだが、署名の検証は外していない。
#
# 使い方: bash bin/ci/allow-expired-debian-release.sh <PHP のバージョン>
#
set -euo pipefail

php_version="${1-}"
if [ -z "$php_version" ]; then
	echo "PHP のバージョンを渡してください（例: 7.4）。" >&2
	exit 1
fi
# 対象かどうかはイメージ自身に訊く。PHP のバージョンから Debian の版を
# 言い当てる形にすると、二方向に外れる。列挙し忘れれば黙って素通りし、
# 逆に将来 bookworm に載せ替えられたイメージへ bullseye の取得先を
# 書き込めば、動くはずのものを壊す。
image="wordpress:php${php_version}"
codename=$(
	docker run --rm "$image" sh -c \
		'. /etc/os-release && printf "%s" "${VERSION_CODENAME:-}"' \
		2>/dev/null || true
)
if [ -z "$codename" ]; then
	echo "$image の Debian の版を読めませんでした。docker が使える場所で実行してください。" >&2
	exit 1
fi
if [ "$codename" != "bullseye" ]; then
	echo "$image は $codename なので、何もしません。"
	exit 0
fi

before='RUN apt-get -qy update'
target=''
for candidate in \
	node_modules/@wordpress/env/lib/init-config.js \
	node_modules/@wordpress/env/lib/runtime/docker/init-config.js \
	node_modules/@wordpress/env/lib/runtime/docker/docker-config.js; do
	if [ -f "$candidate" ]; then
		target="$candidate"
		break
	fi
done
if [ -z "$target" ]; then
	echo "wp-env の Dockerfile を組み立てるファイルが見つかりません。npm install より後に実行してください。wp-env の構成が変わった場合は候補を足してください。" >&2
	exit 1
fi
sources='RUN echo "deb http://archive.debian.org/debian bullseye main" > /etc/apt/sources.list'
update='RUN apt-get -qy -o Acquire::Check-Valid-Until=false update'

# 適用済みかどうかは 2 行そろっていることで見る。片方だけを見て成功で
# 終わると、Check-Valid-Until の付いていない apt-get update が残ったまま
# 進み、このスクリプトが避けようとしている「原因の見えない失敗」に戻る。
# grep は一致が無いと 1 で終わるため、if で受けて set -e を避ける
has_sources=false
if grep -qF -- "$sources" "$target"; then
	has_sources=true
fi
has_update=false
if grep -qF -- "$update" "$target"; then
	has_update=true
fi

if [ "$has_sources" = true ] && [ "$has_update" = true ]; then
	echo "すでに適用済みです。"
	exit 0
fi
if [ "$has_sources" = true ] || [ "$has_update" = true ]; then
	echo "$target の書き換えが中途半端です（sources.list の行: $has_sources / apt-get update の行: $has_update）。node_modules を入れ直してから実行してください。" >&2
	exit 1
fi

# 見つからない場合は wp-env 側の書き方が変わったということ。
# 黙って素通りすると、また原因の見えない失敗に戻る。
# grep は一致が無いと 1 で終わるため、set -e でここが黙って落ちないようにする。
# 読めない等の本当の失敗（2）では何も出力しないため、空文字を 0 に寄せずに
# そのまま数字かどうかを見る（[ "" -ne 1 ] は bash のエラーになる）
count=$( grep -cF -- "$before" "$target" || true )
if ! [[ "$count" =~ ^[0-9]+$ ]]; then
	echo "$target を読めませんでした（grep が値を返しませんでした）。" >&2
	exit 1
fi
if [ "$count" -ne 1 ]; then
	echo "$target で「$before」に一致する行が $count 行です（1 行を想定）。wp-env の書き方が変わった可能性があります。" >&2
	exit 1
fi

# この 2 行は wordpress サービスの Dockerfile に入る。
# cli サービスは Alpine（apk）なので影響しない
sed -i "s|$before|$sources\n$update|" "$target"
# 書けたことを確かめる。ここを素の grep -q にすると、書けていない場合に
# set -e で無言のまま終わり、このスクリプトが避けようとしている
# 「原因の見えない失敗」そのものになる
for expected in "$sources" "$update"; do
	if ! grep -qF -- "$expected" "$target"; then
		echo "$target に「$expected」を書き込めませんでした。" >&2
		exit 1
	fi
done
echo "$target の取得先を archive.debian.org の bullseye に固定しました。"
