# vk-filter-search
絞り込みプラグイン

## Install

`npm install`

## Build

`npm run build`

## Watch

`npm start`

## 翻訳

### 1. potファイル生成

※ wp-cliのインストールが必要です

`npm run make-pot`

または、PoEdit Pro等関連アプリやサービスで生成できます。

### 2. PoEdit 等でpoファイルを作成

### 3. poファイルをjsonに変換

`npm run translate`

## CSS

editorとfront（style.css)共通のスタイルは `/src/scss/_common.scss` に記載。

### 命名規則

※ 暫定の命名規則です。

`vkfs` をprefixとします。

`vkfs__element`

ex) .vkfs__labels