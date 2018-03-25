<?php
session_start();



// ログインチェックの関数

function login_check(){


// ログインチェック
// １時間ログインしてない場合は、再度ログイン
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
// ログインしている
//ログイン時間の更新
  $_SESSION['time'] = time();

//ログインユーザーの情報取得
// $login_sql = 'SELECT * FROM `members` WHERE `member_id` = ?';
// $login_data = array($_SESSION['id']);
// $login_stmt = $dbh->prepare($login_sql);
// $login_stmt->execute($login_data);
// $login_member = $login_stmt->fetch(PDO::FETCH_ASSOC);

} else {
// ログインしてない、時間切れ
// ログイン画面へ強制遷移する
header('Location: login.php');
exit;
}
}


function delete_tweet(){

// OKボタンが押された時
if (true) {
  # code...
}


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

}

function like(){
require('dbconnect.php');

if (isset($_GET['like_tweet_id'])) {

// いいねのデータを作成するSQL文
  $like_sql = 'INSERT INTO `likes` SET `member_id`=?, `tweet_id`=?';
  $like_data = array($_SESSION['id'], $_GET['like_tweet_id']);
  $like_stmt = $dbh->prepare($like_sql);
  $like_stmt->execute($like_data);

  header('Location:index.php?page='.$_GET['page']);
  exit();
}
 }

function hate(){
require('dbconnect.php');

if (isset($_GET['hate_tweet_id'])) {

// いいねを削除するSQL文
    $hate_sql = 'DELETE FROM `likes` WHERE `member_id`=? AND `tweet_id`=?';
    $hate_data = array($_SESSION['id'],$_GET['hate_tweet_id']);
    $hate_stmt = $dbh->prepare($hate_sql);
    $hate_stmt->execute($hate_data);


    header('Location: index.php?page='.$_GET['page']);
    exit();


  }
}


 ?>