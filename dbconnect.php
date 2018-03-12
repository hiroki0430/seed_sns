<?php

$dsn = 'mysql:dbname=seed_sns;host=localhost';

// ザンプ環境下では　ユーザー名はroot,パスワードは空
$user = 'root';
$password = '';

// このプログラムが存在している場所と同じサーバーを指定
$dbh = new PDO($dsn, $user, $password);
$dbh->query('SET NAMES utf8');



 ?>