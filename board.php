<?php
session_start();
if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $name = urlencode($_POST["name"]);
  header('Location: chat.php?name=' . $name);
}
?>
<html>
  <head>
    <title>ボード作成・移動</title>
  </head>
  <?php
    require("header.php");
    ?>
  <body>
    <a href="index.php">トップ</a>
    <h1>
      ボード作成・移動
    </h1>
    <p>
      下の入力欄に、移動したいボード名もしくは、作成したいボード名を入力してください。
    </p>
    <div>
      <form id="login_form" action="board.php" method="post">
      ボード名:<input required type="text" name="name"><br><br>
      <input type="submit" value="作成・移動">
      </form>
  </body>
</html>