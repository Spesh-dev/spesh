<?php
session_start();
if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
if($_POST['pwd'] !== "") {
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
// 接続を閉じる
$dbh = null;
  $name = $_SESSION["user"];
  
  if(password_verify($_POST["pwd"],$user[$name])) {
    $file = "userdata/".$name.".json";
    
    unlink($file);
    
    $id = $user_id[$_SESSION["user"]];

// (2)データベースに接続
$db = new SQLite3("userdb.sqlite");

// (3)SQL作成
$stmt = $db->prepare("DELETE FROM userpwd
	WHERE
		id = :id
");

// (4)削除するデータをセット
$stmt->bindValue( ':id', $id, SQLITE3_INTEGER);

// (5)SQL実行
$stmt->execute();

// (6)削除したデータのカラム数を取得

// (7)データベースの接続解除
$db->close();
    
    unset($_SESSION["user"]);
    
            echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>アカウントを削除しました。</h2></p>
	</div>
</div>');
  }else{
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
    <title>Spesh-アカウントページ</title>
</head>
  <?php
    require("header.php");
    ?>
  <body>
    <h1>
      Spesh-アカウント削除
    </h1>
    <a href="index.php">トップ</a>
    <div style="text-align: center;">
    <p>
      <h4>
        <?php echo("@".$_SESSION["user"])?>
    </h4>
    <p>
      このアカウントを削除します。<br>よろしければ、下にパスワードを入力してください。
    </p>
      <P>
        <form id="login_form" action="acount-delete.php" method="post">
          パスワード<input required type="password" name="pwd"><br><br>
          <input type="submit" value="Delete">
    </form>
      </P>
    </p>
    </div>
  </body>
</html>