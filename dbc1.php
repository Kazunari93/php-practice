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
  echo '成功';
  $dbh = null;
} catch (PDOException $e) {
  echo '失敗' . $e->getMessage();
  exit();
};
