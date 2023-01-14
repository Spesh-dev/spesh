<?php
session_start();
if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}else{
  $json = file_get_contents("userdata/".$_SESSION["user"].".json");
  $user = (json_decode($json, true));
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
if($_POST['name'] == "") {
            echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>入力してください。</h2></p>
	</div>
</div>');
  
}else {
    $file = "userdata/".$_SESSION["user"].".json";
    $json = file_get_contents($file);
    $user = (json_decode($json, true));
    $name = $_POST["name"];
    
    $user["name"] = $name;
    
    $json_en_ud = json_encode($user,JSON_UNESCAPED_UNICODE);

    file_put_contents($file,$json_en_ud);
    
          echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>変更しました。</h2></p>
	</div>
</div>');
  }
}
?>
<html>
  <head>
    <title>Spesh-名前の変更</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </head>
  <?php
    require("header.php");
    ?>
  <body>
    <a href="index.php">トップ</a>
    <h1>
      Spesh-名前の変更
    </h1>
    <div style="text-align: center;">
    <p>
      <?php echo("@".$_SESSION["user"])?>で、ログインしています。<br>
      名前を指定してください。
    </p>
    <p>
    現在の名前：<?php echo($user["name"]);?>  
    </p>
    <form id="login_form" action="setup-name.php" method="post">
      名前*必須<input required type="text" name="name"><br><br>
      <input type="submit" value="名前を変更">
    </form>
  </body>
</html>