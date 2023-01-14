<?php
session_start();
if($_GET["id"] == "out") {
    echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>ログアウトしました</h2></p>
	</div>
</div>');
}
if($_GET["id"] == "notlogin") {
  echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>ログインしていません</h2><br>サービスを利用するには<a href="login">ログイン</a>してください。</p>
	</div>
</div>');
}
if($_GET["id"] == "ban") {
  echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>BANされています</h2></p>
	</div>
</div>');
}
if($_GET["id"] == "notac") {
  echo('    <input type="checkbox" id="pop-up" checked>
<div class="overlay">
	<div class="window">
		<label class="close" for="pop-up">×</label>
		<p class="text" class=""><h2>アクセス権限がありません。</h2></p>
	</div>
</div>');
}
$user = $_SESSION["user"];
if($user == null) {
  $user = "ログインしていません";
}
?>
<html>
    <style>
    .open {
	cursor:pointer; 
}
#pop-up {
	display: none;
}
.overlay {
	display: none; 
}
#pop-up:checked + .overlay {
	display: block;
	z-index: 9999;
	background-color: #00000070;
	position: fixed;
	width: 100%;
	height: 100vh;
	top: 0;
	left: 0;
}
.window {
	width: 90vw;
	max-width: 380px;
	height: 120px;
	background-color: #ffffff;
	border-radius: 6px;
	/*display: flex;*/
	justify-content: center;
	align-items: center;
	position: fixed;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}
.text {
	font-size: 18px;
	margin: 0;

}
a {
    color:blue;
}

.close {
	cursor:pointer;
	position: absolute;
	top: 4px;
	right: 4px;
	font-size: 20px;
}
      footer{
    width: 100%;
    position: absolute;/*←絶対位置*/
    bottom: 0; /*下に固定*/
}
    </style>
  <head>
    <title>
    Spesh
    </title>
  </head>
  <body>
    <?php
    require("header.php");
    ?>
    <div class="md:flex">
      <div class="text-center py-2 w-full md:w-4/5">
        <p>
          お知らせ:デザインを変更しました(6/25)
        </p>
      <h1>
      <span class="text-5xl py-2 font-bold">Spesh</span><br><span class="text-2xl font-bold">spesh.skota11.com</span>
    </h1>
    <p class="">
      <span class="center">作成者：Skota</span><br>このサービスは、ネットの人とリアルタイムでチャットしたり、掲示板に書き込みすることができるサービスです。<br>
      <a class="underline text-1xl py-2 font-bold" href="realtimechat.php">フリーチャットルームへ</a><br>
      <a class="underline text-1xl py-2 font-bold" href="dm.php">DMへ</a><br>または<br><a class="underline text-1xl py-2 font-bold" href="board.php">ボード作成・移動</a><br><a class="underline text-1xl py-2 font-bold" href="search.php">ボード一覧へ</a><br>
    </p>
    </div>
      <div class="border-2 border-sky-500 text-center py-2 w-full md:w-1/5 drop-shadow-2xl md:drop-shadow-2xl h-auto"><?php echo($user); 
      if($user == "ログインしていません") {
        echo('<br><br><a href="signup" class="rounded-xl text-black bg-orange-300 py-2"><span>サインアップ</span></a><br><br>または<br><br><a href="login" class="rounded-xl bg-orange-300 text-black py-2"><span>ログイン</span></a>');
      }else{
        echo("でログイン中");
      }
      ?>
            <?php
  $json = file_get_contents("userdata/" . $_SESSION["user"] .".json");
  $user_log = (json_decode($json, true));
    
    if($user_log["new_message"] !== null and $user_log["new_message"] !== ""){
      echo("<a class='underline' href='dm?to=" .$user_log["new_message"] . "'>". $user_log["new_message"]. "</a>からの新着メッセージがあります");
    }
    ?>
    <div class="container">
    <?php
    if($user !== "ログインしていません"){
      echo '<p><br>
    <a href="acount" class="rounded-xl bg-orange-300 py-2 text-black"><span>アカウントページ</span></a><br><br>アカウント等の設定はこちら。<br>または<br><br><a href="login?id=out" class="rounded-xl bg-orange-300 py-2 text-black"><span>ログアウト</span></a>
  </p>';
    }
    ?>
    </div>
    </div>
    </div>
    <footer class="bg-[#f2f2f2] py-4 text-[#5b6278] center ">
    <p>
      ©Spesh 2022
      </p>
      <p>
        連絡することがありますか?<a href="contact.php">こちら</a>で受け付けています。
      </p>
      <p>
        <a href="terms.html">利用規約</a>
      </p>
    </footer>
  </body>
</html>