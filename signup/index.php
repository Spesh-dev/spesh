<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
if($_POST['name'] == "" and $_POST['pwd'] == "") {
  echo("４つの項目すべて入力してください");
}else{
  function readData(){
    $name = $_POST["name"];
    $pwd = $_POST["pwd"];
    $name2 = $_POST["name2"];
    
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
                    echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>そのアカウントは、既に登録されています。</h2></p>
	</div>
</div>');
      
    }else {
        if(ctype_alnum($name) == true && ctype_alnum($pwd) == true) {
          $options = [
            'cost' => 12,
          ];

          $hash = password_hash($pwd, PASSWORD_BCRYPT, $options);

          $user[$name] = $hash;

          $pdo = new PDO('sqlite:../userdb.sqlite');

// (3) SQL作成
$stmt = $pdo->prepare("INSERT INTO userpwd (
	user, pwd
) VALUES (
	:user, :pwd
)");

// (4) 登録するデータをセット
$stmt->bindParam( ':user', $name, PDO::PARAM_STR);
$stmt->bindParam( ':pwd', $user[$name], PDO::PARAM_STR);

// (5) SQL実行
$res = $stmt->execute();

// (6) データベースの接続解除
$pdo = null;
          
          $userdata["name"] = $name2;
          $userdata["joindate"] = date('Y/m/d H:i:s',strtotime("now +9 hours"));
          $userdata["user_agent"] = $_SERVER['HTTP_USER_AGENT'];
          $userdata["authenticated"] = false;
          $userdata["image"] = "https://cdn.glitch.global/d69c248b-f38b-4125-a7fd-9e952d6a69b0/noimage%20(1).svg?v=1645860963121";

          $json_en_ud = json_encode($userdata,JSON_UNESCAPED_UNICODE);

          file_put_contents("../userdata/".$name.".json", $json_en_ud);
          
          $_SESSION["user"] = $name;
          
          echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>登録しました。</h2></p>
	</div>
</div>');
         }else {
              echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>アカウント登録は、英数字以外の文字は使えません。</h2></p>
	</div>
</div>');
        }
      }
    }
  }
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        readData();
    }
  }
?>
<html>
  <head>
    <title>Spesh-サインアップ</title>
  </head>
  <?php
    require("../header.php");
    ?>
  <body>
    <a href="index.php">トップ</a>
    <h1 class="text-5xl py-2 font-bold">
      サインアップ
    </h1>
              <div class="flex place-content-center">
          <div class="w-full md:float-right md:w-3/5">
            <p class="text-center text-3xl">
              Spesh
            </p>
    <h3>
      利用規約を確認してください。
      <a href="terms.html" class="border-b-2 border-indigo-500">利用規約を確認する</a>
    </h3>
    アカウントを作成すると、利用規約に同意したものとみなします。<br>
    <form id="login_form" action="" method="post">
      ユーザーネーム*必須<input required id="input_pass" type="text" name="name"><br>
      名前*必須<input required id="input_pass" type="text" name="name2"><br>
      パスワード*必須<input required type="password" name="pwd"><br><br>
      <input type="submit"  value="新規登録">
    </form>
    <p>
      ログインがしたいですか?<a href="login.php">ログイン</a>してください。
    </p>
    </div>
    </div>
  </body>
</html>