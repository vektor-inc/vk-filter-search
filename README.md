# vk-filter-search
絞り込みプラグイン

## 概要

このプラグインでは下記要素を使用して絞り込み検索を行うことができます。
ブロックエディタを使用して検索フォームを構築することが可能です。

- 「投稿」・「固定ページ」・カスタム投稿タイプなどの投稿タイプ
- 「カテゴリ」・「タグ」・カスタム分類などのタクソノミー
- キーワード

また、このプラグインを有効化すると投稿タイプ「VK Filter Search」が追加されます。

### 搭載されたブロック

このプラグインには下記５つのブロックが搭載されています。

- Filter Search
- Post Type Search
- Taxonomy Search
- Keyword Search
- Call Search Form

#### Filter Search ブロックの説明
検索フォームの大本となるブロックです。
プルダウン方式で絞り込み対象の投稿タイプを指定する事が可能です。

このブロックの中でのみ下記３つのブロックが使用可能です。

- Post Type Search
- Taxonomy Search
- Keyword Search

インナーブロックに Keyword Search ブロックがない場合は空のキーワードを秘密裏に付与します。
その結果、キーワードがない場合でも検索結果ページ扱いされるように計らっています。

また、フォームが登録された投稿IDを秘密裏に付与しておき、検索結果ページでもその投稿を表示します。
ただし、該当検索結果がない場合には検索フォームは表示されません。

サブミットボタンを押すと検索結果ページに飛びます。

#### Post Type Search ブロックの説明
Filter Search ブロックのインナーブロックとしてのみ使用可能。
チェックボックス方式で絞り込み対象の投稿タイプを指定できます。

チェックした投稿タイプからなるプルダウンが生成されます。
何もチェックしていない場合は警告文が表示されます（編集画面のみ）。

#### Taxonomy Search ブロックの説明
Filter Search ブロックのインナーブロックとしてのみ使用可能。
プルダウン方式で絞り込み対象のタクソノミーを指定できます。

選択したタクソノミーのタームからなるプルダウンが生成されます。
選択したタクソノミーにタームがない場合は警告文が表示されます（編集画面のみ）。

#### Keyword Search ブロックの説明
Filter Search ブロックのインナーブロックとしてのみ使用可能。
設定項目はありません。

キーワード用のテキストフォームが生成されます。

#### Call Search Form ブロックの説明
投稿タイプ「VK Filter Search」に登録された投稿を呼び出します。

##　開発者向け

### Install

`npm install`

### Build

`npm run build`

### Watch

`npm start`

### 翻訳

#### 1. potファイル生成

※ wp-cliのインストールが必要です

`npm run make-pot`

または、PoEdit Pro等関連アプリやサービスで生成できます。

#### 2. PoEdit 等でpoファイルを作成

#### 3. poファイルをjsonに変換

`npm run translate`

### CSS

editorとfront（style.css)共通のスタイルは `/src/scss/_common.scss` に記載。

#### 命名規則

※ 暫定の命名規則です。

`vkfs` をprefixとします。

`vkfs__element`

ex) .vkfs__labels