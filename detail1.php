<?php

$id = $_GET['id'];

if (empty($id)) {
  exit('Not Found');
}


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
        PDO::ATTR_EMULATE_PREPARES => false,
      ]
    );
  } catch (PDOException $e) {
    echo '失敗' . $e->getMessage();
    exit();
  };

  return $dbh;
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

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ブログ詳細</title>
</head>

<body>
  <h2>ブログ詳細</h2>
  <h3>タイトル : <?php echo $result['title'] ?></h3>
  <p>投稿日時 : <?php echo $result['post_at'] ?></p>
  <p>カテゴリ : <?php echo $result['category'] ?></p>
  <br>
  <p>本文 : <?php echo $result['content'] ?></p>
</body>

</html>