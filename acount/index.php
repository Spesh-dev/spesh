<?php
session_start();
if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}
session_regenerate_id();
$json = file_get_contents("../userdata/".$_SESSION["user"].".json");
$user = (json_decode($json, true));
?>
<html>
  <head>
    <title>Spesh-アカウントページ</title>
 </head>
  <?php
    require("../header.php");
    ?>
  <body>
    <h1>
      Spesh-アカウントページ
    </h1>
    <a href="index.php">トップ</a>
    <div class="text-center">
    <p>
      <div class="grid grid-cols-1 gap-4 place-items-center h-36">
        <div>
          <img class="" id="acount_user_image" src='<?php echo($user["image"]);?>'>
        </div>
      </div>
      <h2 class="text-1xl py-2 font-bold">
        <?php echo($user["name"])?>
      </h2>
      <h4>
        <?php echo("@".$_SESSION["user"])?>
    </h4>
    <p>
    <?php
        
        if($user["authenticated"] == true) {
          echo("<p>認証ユーザー</p>");
        }
        
        echo("アカウント作成日:".$user["joindate"]);
        
      ?>
    </p>
    </p>
    </div>
                <div class="flex place-content-center">
          <div class="w-full md:float-right md:w-3/5">
  <p class="py-2">
      <a href="setup-name.php" class="btn btn-flat"><span>名前の変更</span></a>
    </p>
  <p class="py-2">
      <a href="setup-img.php" class="btn btn-flat"><span>画像を変更</span></a>
    </p>
      <p class="py-2">
    <a href="change.php" class="btn btn-flat"><span>パスワードを変更</span></a>
  </p>
            <p class="py-2">
      <a href="login?id=out" class="btn btn-flat"><span>ログアウト</span></a>
    </p>
  <p class="py-2">
    <a href="acount-delete.php" class="btn btn-flat"><span>アカウントの削除</span></a>
  </p>
  </div>
</div>
  </body>
</html>