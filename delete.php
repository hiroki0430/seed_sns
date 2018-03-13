<?php

require ('dbconnect.php');
session_start();

// これ違うからなおせ。
if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
  $sql = 'UPDATE `tweets` SET `delete_flag`=1 WHERE `tweet_id`=?';
  $data = array($_GET['tweet_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

}

 ?>