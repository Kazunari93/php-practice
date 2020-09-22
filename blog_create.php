<?php
require_once('blog.php');
$blogs = $_POST;

if (empty($blogs['title'])) {
  exit('タイトルが入力されていません');
}

if (mb_strlen($blogs['title']) > 191) {
  exit('タイトルは191文字以下です');
}

if (empty($blogs['content'])) {
  exit('本文が入力されていません');
}

if (empty($blogs['category'])) {
  exit('カテゴリーが選択されていません');
}

if (empty($blogs['publish_status'])) {
  exit('公開ステータスが選択されていません');
}

$blog = new Blog();
$blog->blogCreate($blogs);
