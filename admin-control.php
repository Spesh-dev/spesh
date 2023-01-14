<?php
session_start();
if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}
$json = file_get_contents("userdata/". $_SESSION["user"]  . ".json");
$user = (json_decode($json, true));

if($user["authenticated"] == false){
  header('Location: index.php?id=notac');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $id_pwd = getenv("pwd");
  if($_POST["name_delete"] !== null){
    $board_name = $_POST["name_delete"];
    $id = $_POST["pwd_delete"]; 
    if($id == $id_pwd){
      unlink("chatlog/" . $board_name . ".json");
      echo("削除しました");
    }else{
      echo("pwd-not");
    }
  }else if($_POST["name"] !== null){
    $name = $_POST["name"];
    $number = $_POST["id"];
    $id = $_POST["pwd"];
    $content = $_POST["content"];
    
    if($id == $id_pwd){
      $json = file_get_contents("chatlog/". $name .".json");
      $log = (json_decode($json, true));
      
      if($log[$number]["content"] !== null){
        $log[$number]["content"] = $content; 
      }
      
      $json_en_ud = json_encode($log,JSON_UNESCAPED_UNICODE);
      file_put_contents("chatlog/".$name.".json", $json_en_ud);
      
      echo("変更しました");
    }
  }else {
    $name = $_POST["user"];
    $number = $_POST["id"];
    $id = $_POST["pwd"];
    $content = $_POST["content"];
    
    if($id == $id_pwd){
      $json = file_get_contents("userdata/". $name .".json");
      $log = (json_decode($json, true));
      
      print_r($log);
      
      $log[$number] = $content; 
      
      print_r($log);
      
      $json_en_ud = json_encode($log,JSON_UNESCAPED_UNICODE);
      file_put_contents("userdata/".$name.".json", $json_en_ud);
      
      echo("変更しました");
    }
  }
}
?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>Spesh-ボード管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>
      Spesh-ボード管理
    </h1>
    <h2>
      <a href="db-control.php">DBCONTROL</a>
    </h2>
    <a href="index.php">トップ</a>
    <div style="text-align: center;">
          <p>
      ボード削除
    </p>
      <form id="login_form" action="admin-control.php" method="post">
      削除するボード名<input required type="text" name="name_delete"><br>
      管理ID*必須<input required type="password" name="pwd_delete"><br><br>
      <input type="submit" value="削除">
    </form>
      <p>
        ボード編集
      </p>
      <form id="login_form" action="admin-control.php" method="post">
      編集するボード名<input required type="text" name="name"><br>
      編集する投稿番号<input required type="text" name="id"><br>
      内容<textarea class="m-form-textarea" required name="content"></textarea><br>
      管理ID*必須<input required type="password" name="pwd"><br><br>
      <input type="submit" value="編集">
    </form>
      <form id="login_form" action="admin-control.php" method="post">
      編集するユーザー名<input required type="text" name="user"><br>
      編集するid<input required type="text" name="id"><br>
      内容<textarea class="m-form-textarea" required name="content"></textarea><br>
      管理ID*必須<input required type="password" name="pwd"><br><br>
      <input type="submit" value="編集">
    </form>
  </body>
</html>