<!doctype html>
<?php session_start(); 
if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}
      $fp3 = fopen('userlog/mute.txt','a+b');
    
    while (!feof($fp3)) {
      $datas3[] = fgets($fp3);
    }

    foreach($datas3 as $d){
      $trdatas3[] = trim($d);
    }
    
    if(in_array($_SESSION["user"],$trdatas3)){
      header('Location: index.php?id=ban');
    }

$json = file_get_contents("userdata/".$_SESSION["user"].".json");
$user = (json_decode($json, true));
?>
<html lang="jp">
    <head>
        <title>Free-Chat</title>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="./chat.js"></script>
    <script type="text/javascript" language="javascript">
      function brClick() {
        var area = document.getElementById('message');
	      var text = "<br>";
	//カーソルの位置を基準に前後を分割して、その間に文字列を挿入
	      area.value = area.value.substr(0, area.selectionStart)
			        + text
			        + area.value.substr(area.selectionStart);
      document.getElementById('message').focus();
      }
    function onButtonClick(content) {
      document.getElementById('message').value = content;
      document.getElementById('message').focus();
      document.getElementById('message').setSelectionRange(document.getElementById('message').value.length,document.getElementById('message').value.length);
    }
  </script>
      <link href="chat.css" rel="stylesheet">   
  </head>
 <?php
    require("header.php");
    ?>
    <body>
        <p>CHAT-FREEROOM　<a href="index.php">TOP</a></p>
       <p>ユーザー名：<?php echo('"' . $user["name"] .'"'. "@". $_SESSION["user"]);?></p>
         <form method="post" name="form1" id="id_form1" onsubmit="writeMessage(); return false;">
           <div id="form">
                        <div style="text-align: center; background-color: white;" id="type">
           </div>
             <input onkeyup="TypeWrite()" id="message" name="message" type="text" value="" />
             <input id="submit" type="button" value="送信" onclick="writeMessage()">
           </div>
        </form>
    </body>
  <div id="messageTextBox"></div>
</html>