<?php
session_start();
if($_GET["id"] == "out") {
  $_SESSION["user"] = "";
  header("Location:index.php?id=out");
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
if($_POST['name'] == "" and $_POST['pwd'] == "") {
  echo("２つの項目すべて入力してください");
}else {
    $name = $_POST["name"];
    
  $user = [];
  try {
	// DBへ接続
	$dbh = new PDO("sqlite:../userdb.sqlite");

	// testテーブルの全データを取得
	$sql = 'SELECT * FROM userpwd';
	$data = $dbh->query($sql);

	if( !empty($data) ) {
		foreach( $data as $value ) {
			$user[$value["user"]] = $value['pwd'];
		}
	}

} catch(PDOException $e) {
	
	echo $e->getMessage();
	die();
}

// 接続を閉じる
$dbh = null;
  
    if(array_key_exists($name, $user)){
        if(password_verify($_POST["pwd"],$user[$name])) {
    echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>ログインしました。</h2></p>
	</div>
</div>');
            $_SESSION["user"] = $name;
        }else {
    echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>パスワードが違います。</h2></p>
	</div>
</div>');
        }
    }else{
    echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>ユーザーが存在しません。</h2></p>
	</div>
</div>');
    }
    
    
    }
}
?>
<html>
  <head>
    <title>Spesh-ログイン</title>
 </head>
  <?php
    require("../header.php");
    ?>
  <body>
    <a href="index.php">トップ</a>
    <h1 class="text-5xl py-2 font-bold">
      ログイン
    </h1>
          <div class="flex place-content-center">
          <div class="w-full md:float-right md:w-3/5">
            <p class="text-center text-3xl">
              Spesh
            </p>
          <form id="login_form" action="" method="post">
      ユーザーネーム*必須<input required type="text" name="name"><br>
      パスワード*必須<input required type="password" name="pwd"><br><br>
      <input type="submit" value="ログイン">
    </form>
          <p>
      新規登録がしたいですか?<a href="signup.php">新規登録</a>してください。
    </p>
    </div>
    </div>
  </body>
</html>