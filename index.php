<?php

require_once('blog.php');

$blog = new Blog();

$data = $blog->getAll();

function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h2>ブログ一覧</h2>
  <p><a href="/form.html">新規作成</a></p>
  <table>

    <tr>
      <th>タイトル</th>
      <th>カテゴリー</th>
      <th>投稿日</th>
    </tr>
    <?php foreach ($data as $column) : ?>
      <tr>
        <td><?php echo h($column['title']) ?></td>
        <td><?php echo h($blog->setCategory($column['category'])) ?></td>
        <td><?php echo h($column['post_at']) ?></td>
        <td><a href="/detail.php?id=<?php echo $column['id'] ?>">詳細</a></td>
        <td><a href="/edit.php?id=<?php echo $column['id'] ?>">編集</a></td>
        <td><a href="/blog_delete.php?id=<?php echo $column['id'] ?>">削除</a></td>

      </tr>
    <?php endforeach; ?>
  </table>
</body>

</html>