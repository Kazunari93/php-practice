<?php

require_once('dbc.php');

$data = getAllBlog();

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
    <?php foreach ($data as $column) : ?>
      <tr>
        <td><?php echo $column['id'] ?></td>
        <td><?php echo $column['title'] ?></td>
        <td><?php echo setCategory($column['category']) ?></td>
        <td><a href="/detail.php?id=<?php echo $column['id'] ?>">詳細</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>

</html>