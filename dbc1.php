

<?php

class Dbc
{
  function dbConnect()
  {
    $dsn = 'dsn'; //my dsn
    $user = 'user'; // my user
    $pass = 'pass'; // my password

    try {
      $dbh = new PDO(
        $dsn,
        $user,
        $pass,
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
      );
    } catch (\PDOException $e) {
      echo '失敗' . $e->getMessage();
      exit();
    };

    return $dbh;
  }

  function getAllBlog()
  {
    $dbh = $this->dbConnect();
    $sql = 'SELECT * FROM blog';
    //SQL実行
    $stmt = $dbh->query($sql);
    //結果を受け取る
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    $dbh = null;
  }

  function setCategory($num)
  {
    if ($num === '1') {
      return '日常';
    } elseif ($num === '2') {
      return '趣味';
    } else {
      return 'その他';
    }
  }

  function getBlog($id)
  {
    if (empty($id)) {
      exit('Not Found');
    }

    $dbh = $this->dbConnect();
    //プレイスフォルダー
    $stmt = $dbh->prepare('SELECT * FROM blog WHERE id = :id');
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
      exit('Not Found');
    }
    return $result;
  }

  function blogCreate($blogs)
  {
    $sql = 'INSERT INTO blog(title, content, category, publish_status)
        VALUES (:title, :content, :category, :publish_status)';

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
}
