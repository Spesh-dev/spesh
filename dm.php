<?php
session_start();
if($_GET["id"] == "notuser") {
   echo("そのようなユーザーは存在しません。");
}
if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  header('Location: dm?to=' . $_POST["name"]);
}
?>
<html>
  <head>
    <title>DM - 相手を指定</title>
  </head>
  <?php
    require("header.php");
    ?>
  <body>
    <a href="index.php">トップ</a>
    <h1>
      DM - 相手を指定
    </h1>
    <p>
      下の入力欄に、DMをする相手の名前を入力してください。
    </p>
    <div>
      <form id="login_form" action="dm.php" method="post">
      DMする相手:<input required type="text" name="name"><br><br>
      <input type="submit" value="作成・移動">
      </form>
  </body>
</html>