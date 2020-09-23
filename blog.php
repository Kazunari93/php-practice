<?php

require_once('dbc.php');

class Blog extends Dbc
{
  protected $table_name = 'blog';

  public function setCategory($num)
  {
    if ($num === '1') {
      return '日常';
    } elseif ($num === '2') {
      return '趣味';
    } else {
      return 'その他';
    }
  }

  public function blogCreate($blogs)
  {
    $sql = "INSERT INTO $this->table_name(title, content, category, publish_status)
        VALUES (:title, :content, :category, :publish_status)";

    $dbh = $this->dbConnect();
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
  }

  public function blogUpdate($blogs)
  {
    $sql = "UPDATE $this->table_name SET title = :title, content = :content, category = :category, publish_status = :publish_status
        WHERE id = :id";

    $dbh = $this->dbConnect();
    $dbh->beginTransaction();
    try {
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':title', $blogs['title'], PDO::PARAM_STR);
      $stmt->bindValue(':content', $blogs['content'], PDO::PARAM_STR);
      $stmt->bindValue(':category', $blogs['category'], PDO::PARAM_INT);
      $stmt->bindValue(':publish_status', $blogs['publish_status'], PDO::PARAM_INT);
      $stmt->bindValue(':id', $blogs['id'], PDO::PARAM_INT);

      $stmt->execute();
      $dbh->commit();
      echo '更新しました';
    } catch (PDOException $e) {
      $dbh->rollBack();
      exit($e);
    }
  }



  public function blogValidate($blogs)
  {
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
  }
}
