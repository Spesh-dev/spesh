<?php
session_start();
if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}
$q = $_GET["q"];

$result = glob('chatlog/*');
?>
<html>
  <head>
    <title>ボード一覧</title>
  </head>
  <?php
    require("header.php");
    ?>
  <body>
    <a href="index.php">トップ</a>
    <h1>
      ボード一覧
    </h1>
    <div>
    <p>
      <?php 
      $count1 = count($result);
      if($count1 == false){
        echo("Error...");
      }
      for( $i = 0; $i < $count1; ++$i ) {
        
        $b_name = str_replace('chatlog/', '', $result[$i]);
        $b_name = str_replace('.json', '', $b_name);
        echo "<a class='underline text-3xl py-2' href='chat.php?name=". $b_name . "'>" . $b_name . "</a>";
        $json = file_get_contents($result[$i]);
        $board_data = (json_decode($json, true));
        
        
        echo "<p class='text-2xl py-2'>投稿数:". count($board_data) . "作成者:". $board_data[1]["name"] ."</p>";
      }
      ?>
    </p>
  </body>
</html>