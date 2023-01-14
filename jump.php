<?php
session_start();
if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}
$q = $_GET["id"];

$result = glob('chatlog/*');
?>
<html>
<?php
    require("header.php");
    ?>
  <body>
    <a href="index.php">トップ</a>
    <h1>
      リンクジャンプ
    </h1>
    <p>
      以下のサイトは、外部サイトになります。<br>このサイトが信用できる場合のみのアクセスをおすすめします。
    </p>
    <div>
    <p>
      <?php 
      echo "<a href='". $q ."'>". $q ."</a>"
      ?>
    </p>
  </body>
</html>