<?php
// 2つセットで覚える。
// session_start()は$_session
session_start();
require('../dbconnect.php');

echo '<br>';
echo '<br>';

// var_dump($_POST);

// POST送信された時
if (!empty($_POST)) {


  //入力チェック
  //$_POSTの値が空だった時に$errorという配列にエラーの情報を確認する
  if ($_POST['nick_name'] == '') {
    $error['nick_name'] = 'blank';
  }

//もし、空だった時
if ($_POST['email'] == '') {
  $error['email'] = 'blank';
}

if ($_POST['password'] == '') {
  $error['password'] = 'blank';

}elseif (strlen($_POST['password'])<4) {
  $error['password'] = 'length';
}

if (!isset($error)) {

  //emailの重複チェック

  //検索条件にヒットした件数を取得するSQL文を書く必要がある。
  // COUNT() SQL文の関数。あれとは違うよ！！ ヒットした件数を取得する。
  $sql = 'SELECT COUNT(*) AS `mail_count` FROM `members` WHERE `email`=?';
  $data = array($_POST['email']);

// ASは別名をつけることができる。取得したデータを判別しやすくする。

$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$mail_count = $stmt->fetch(PDO::FETCH_ASSOC);

// もし$mail_count['mail_count']が１以上の時
if ($mail_count['mail_count'] >= 1) {
  $error['email'] = 'duplicated';
}

//上の$error['email']が入っていない時

if (!isset($error)) {
  //画像の拡張子チェック（画像が送られているかどうか、ファイルなどの拡張子ではないかのチェック）
  // jpg , png , gifの拡張子はok
  // substr = 文字列から範囲を指定して一部分の文字を取得する関数
  // substr(文字列、切り出す文字のスタート数)

  $ext = substr($_FILES['picture_path']['name'], -3);
  $ext = strtolower($ext);
// 拡張子の判定
// 拡張子がjpg,またはpng,またはgifのいずれかの時

  }

  if($ext == 'jpg' || $ext == 'png' || $ext =='gif'){
  var_dump($ext);

  // var_dump($_FILES); は階層を見るのだ。
  // 画像のアップロード処理
  //date関数で"確認ボタン"を押した時の日付を取得し、ファイル名に文字列連結している。
  // why？　emailと同様に重複する可能性があるため
$picture_path = date('YmdHis') . $_FILES['picture_path']['name'];
  // check.phpに移動する

// echo '<pre>';
// var_dump($_FILES);
// echo '<pre>';

// アップロード方法
//move_uploaded_file = 画像を指定したディレクトリに保存（アップロードする）
//move_uploaded_file（ファイル名、保存先のディレクトリの位置）
move_uploaded_file($_FILES['picture_path']['tmp_name'], '../picture_path/'.$picture_path);

// $_SESSION = SEESION変数に入力された値を保存

// 注意！！！ $_SESSONを使用する時はスタートをかく
$_SESSION['join'] = $_POST;
$_SESSION['join']['picture_path'] = $picture_path;
// 値の取り方（二次元配列）$_SETTION['join']['nick_name'];

header('location: check.php');
// 強制的に遷移

// これ以下のコードを無駄にしないように、このページの処理を終了させる。
exit();

} else {
  $error['image'] = 'type';
}
 }
  }


?>




<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SeedSNS</title>

    <!-- Bootstrap -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/timeline.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    <!--
      designフォルダ内では2つパスの位置を戻ってからcssにアクセスしていることに注意！
     -->

  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-twitter-square"></i> Seed SNS</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 content-margin-top">
        <legend>会員登録</legend>

        <!-- enctype=""multipart/form-data"は画像ファイルを送る為に必要 -->
        <!-- inputタグをtype="file"にする -->

        <form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
          <!-- ニックネーム -->
          <div class="form-group">
            <label class="col-sm-4 control-label">ニックネーム</label>
            <div class="col-sm-8">
              <input type="text" name="nick_name" class="form-control" placeholder="例： Seed kun">
               <?php if (isset($error['nick_name']) && $error['nick_name'] == 'blank') { ?>
                 <P class="error">* ニックネームを入力してください</P>
                 <?php } ?>
            </div>
          </div>
          <!-- メールアドレス -->
          <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com">
              <?php if (isset($error['email']) && $error['email'] == 'blank') { ?>
              <p class="error">* アドレスを入力してください</p>
              <?php } elseif (isset($error['email']) && $error['email'] == 'duplicated') { ?>
                <p class="error">* 入力されたアドレスは既に使用されています。</p>

             <?php } ?>

            </div>
          </div>
          <!-- パスワード -->
          <div class="form-group">
            <label class="col-sm-4 control-label">パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" placeholder="">
              <?php if (isset($error['password']) && $error['password'] == 'blank') { ?>
                <p class="error">* パスワードを入力してください。</p>
               <?php } elseif(isset($error['password']) && $error['password'] == 'length') { ?>
               <p class="error">* パスワードは４字以上入力してください。</p>
              <?php } ?>
            </div>
          </div>

          <!-- 指定した写真以外のものを入れて、エラーを表示させてみよう（復習） -->
          <!-- プロフィール写真 -->
          <div class="form-group">
            <label class="col-sm-4 control-label">プロフィール写真</label>
            <div class="col-sm-8">
              <input type="file" name="picture_path" class="form-control">
              <?php if (isset($error['image']) && $error['image'] == 'type') { ?>
                <p class="error">違う写真が見たいよ。。。</p>
             <?php } ?>
            </div>
          </div>

          <input type="submit" class="btn btn-default" value="確認画面へ">
        </form>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../../assets/js/jquery-3.1.1.js"></script>
    <script src="../../assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="../../assets/js/bootstrap.js"></script>
  </body>
</html>
