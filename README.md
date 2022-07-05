# 🐳

## phpunit の導入手順

### 1. [src/composer.json]ファイルの作成

このスニペットの[src/composer.json]を参考に修正してみましょう

### 2. [composer update]コマンドを実行しましょう

```
./composer.sh update
```

[参考記事](https://qiita.com/YusukeHigaki/items/47dd3ec23544225f7301)

### 3. テストコードを実行しましょう

```
./docker-compose-local.sh run php vendor/bin/phpunit test
```
