<?php
require_once('dbc.php');
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

$sql = 'INSERT INTO blog(title, content, category, publish_status)
        VALUES (:title, :content, :category, :publish_status)';

$dbh = dbConnect();
$dbh->beginTransaction();
try {
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':title', $blogs['title'], PDO::PARAM_STR);
  $stmt->bindValue(':content', $blogs['content'], PDO::PARAM_STR);
  $stmt->bindValue(':category', $blogs['category'], PDO::PARAM_INT);
  $stmt->bindValue(':publish_status', $blogs['publish_status'], PDO::PARAM_INT);
  $stmt->execute();
  $dbh->commit();
  echo '投稿完了';
} catch (PDOException $e) {
  $dbh->rollBack();
  exit($e);
}
