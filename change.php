<?php
session_start();
if($_SESSION["user"] == "") {
   header('Location: index.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
if($_POST['old_pwd'] == ""){
            echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>入力してください。</h2></p>
	</div>
</div>');
  
}else {
$user = [];
$user_id = [];
  try {
	// DBへ接続
	$dbh = new PDO("sqlite:userdb.sqlite");

	// testテーブルの全データを取得
	$sql = 'SELECT * FROM userpwd';
	$data = $dbh->query($sql);

	if( !empty($data) ) {
		foreach( $data as $value ) {
			$user[$value["user"]] = $value['pwd'];
      $user_id[$value["user"]] = $value["id"];
		}
	}

} catch(PDOException $e) {
	
	echo $e->getMessage();
	die();
}

  print_r($user_id);
// 接続を閉じる
$dbh = null;
    $old = $_POST["old_pwd"];
    $new = $_POST["new_pwd"];
    
    $name = $_SESSION["user"];
    
    if(password_verify($old,$user[$name])) {
      $options = [
            'cost' => 12,
          ];

      $hash = password_hash($new, PASSWORD_BCRYPT, $options);
      
      $user[$_SESSION["user"]] = $hash;
      
      $pdo = new PDO('sqlite:userdb.sqlite');

// (3) SQL作成
$stmt = $pdo->prepare("UPDATE userpwd SET user = :user, pwd = :pwd WHERE id = :id");

      $id = $user_id[$_SESSION["user"]];
      
// (4) 登録するデータをセット
$stmt->bindParam( ':id', $id, PDO::PARAM_INT);
$stmt->bindParam( ':user', $_SESSION["user"], PDO::PARAM_STR);
$stmt->bindParam( ':pwd', $hash, PDO::PARAM_STR);

// (5) SQL実行
$res = $stmt->execute();

// (6) データベースの接続解除
$pdo = null;
      
          echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>パスワードを変更しました。</h2></p>
	</div>
</div>');
      
    }else {
          echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>パスワードが違います。</h2></p>
	</div>
</div>');
  }
}
}
?>
<html>
  <head>
    <title>Spesh-パスワードの変更</title>
</head>
  <?php
    require("header.php");
    ?>
  <body>
    <a href="index.php">トップ</a>
    <h1>
      Spesh-パスワードの変更
    </h1>
    <div style="text-align: center;">
    <p>
      <?php echo("@".$_SESSION["user"])?>で、ログインしています。<br>
      新しいパスワードを入力してください。
    </p>
    <form id="login_form" action="change.php" method="post">
      古いパスワード*必須<input required type="password" name="old_pwd"><br>
      新しいパスワード*必須<input required type="password" name="new_pwd"><br><br>
      <input type="submit" value="パスワードを変更^">
    </form>
  </body>
</html>