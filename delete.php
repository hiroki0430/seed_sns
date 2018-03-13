<?php

require ('dbconnect.php');

// 削除したいtweet_id
$delete_tweet_id = $_GET['tweet_id'];


// 論理削除用のUPDATE文
  $sql = 'UPDATE `tweets` SET `delete_flag`=1 WHERE `tweet_id`=?';
  $data = array($delete_tweet_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

// 一覧画面へ戻る
  header("Location: index.php");
  exit();
  
 ?>