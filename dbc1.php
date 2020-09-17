<?php

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
  } catch (PDOException $e) {
    echo '失敗' . $e->getMessage();
    exit();
  };

  return $dbh;
}

function getAllBlog()
{
  $dbh = dbConnect();
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
    return 'ブログ';
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

  $dbh = dbConnect();
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
