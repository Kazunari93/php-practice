<?php

$dsn = 'dsn'; //my dsn
$user = 'user'; // my user
$pass = 'pass'; // my password 


try {
  $dbh = new PDO(
    $dsn,
    $user,
    $pass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );
  //echo '成功';

  $sql = 'SELECT * FROM blog';
  //SQL実行
  $stmt = $dbh->query($sql);
  //結果を受け取る
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $dbh = null;
} catch (PDOException $e) {
  echo '失敗' . $e->getMessage();
  exit();
};
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <table>
    <tr>
      <th>No</th>
      <th>タイトル</th>
      <th>カテゴリー</th>
    </tr>
    <?php foreach ($result as $column) : ?>
      <tr>
        <td><?php echo $column['id'] ?></td>
        <td><?php echo $column['title'] ?></td>
        <td><?php echo $column['category'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>

</html>