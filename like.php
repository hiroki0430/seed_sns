<?php

session_start();
// require('function.php');
require('dbconnect.php');



// like & hate が押された時
if (!empty($_GET)) {

if (isset($_GET['like_tweet_id'])) {

// いいねのデータを作成するSQL文
  $like_sql = 'INSERT INTO `likes` SET `member_id`=?, `tweet_id`=?';
  $like_data = array($_SESSION['id'], $_GET['like_tweet_id']);
  $like_stmt = $dbh->prepare($like_sql);
  $like_stmt->execute($like_data);

  header('Location:index.php?page='.$_GET['page']);
  exit();
}

if (isset($_GET['hate_tweet_id'])) {

    $hate_sql = 'DELETE FROM `likes` WHERE `member_id`=? AND `tweet_id`=?';
    $hate_data = array($_SESSION['id'],$_GET['hate_tweet_id']);
    $hate_stmt = $dbh->prepare($hate_sql);
    $hate_stmt->execute($hate_data);


    header('Location: index.php?page='.$_GET['page']);
    exit();


  }
}




// $sql = 'INSERT INTO `likes` SET `member_id`=?, `tweet_id`=?';
// $data = array($get_like_count);
// $stmt = $dbh->prepare($sql);
// $stmt->execute($data);


// header("Location: index.php");
// exit();



 ?>