#!/bin/bash
#
# CI で wp-env を起動する。失敗したら間を置いて試し直し、
# 回数を使い切ったら 0 以外で終わる。
#
# もとは workflow に until ループを直接書いていた。php_unit_test.yml の
# 3 箇所は、5 回すべて失敗しても最後に評価される行が真になるため、
# そのステップが成功として扱われていた。失敗は次のステップ
# （wp core version）で現れ、原因の見えない形になっていた。
# release.yml の 4 箇所は [ $n -lt <回数> ] || exit 1 を持っていて
# 正しく失敗していた（dist のスモークテストだけ 3 回、残り 3 箇所は 5 回）。
# 壊れてはいなかったが、同じ形が 7 つに散っていたので併せて寄せた。
#
# WP_ENV_CORE / WP_ENV_PHP_VERSION は呼び出す側が渡す。
#
set -euo pipefail

attempts="${WP_ENV_START_ATTEMPTS:-5}"
wait_seconds="${WP_ENV_START_WAIT:-15}"

# 数字以外を渡されたときに黙って既定値へ落ちないようにする
for value in "$attempts" "$wait_seconds"; do
	if ! [[ "$value" =~ ^[0-9]+$ ]]; then
		echo "回数と待ち時間には数字を指定してください: $value" >&2
		exit 1
	fi
done
if [ "$attempts" -lt 1 ]; then
	echo "回数には 1 以上を指定してください: $attempts" >&2
	exit 1
fi

n=1
while :; do
	# -- を先に置くのは、これが無いと --update が npm 自身のフラグとして
	# 食われて wp-env に渡らないため。実測:
	#   npm run echoargs start --update    → ARGS: start
	#   npm run echoargs -- start --update → ARGS: start --update
	#
	# npx を使わないのは、node_modules に無いときレジストリの同名
	# パッケージを取りに行くため。npm には WordPress のものではない
	# wp-env が実在する
	if npm run wp-env -- start --update; then
		exit 0
	fi
	if [ "$n" -ge "$attempts" ]; then
		echo "wp-env の起動に $attempts 回失敗しました。" >&2
		exit 1
	fi
	echo "wp-env start --update をやり直します（$n/$attempts）..."
	n=$(( n + 1 ))
	sleep "$wait_seconds"
done
