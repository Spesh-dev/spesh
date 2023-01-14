<?php
session_start();
if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
  $ip = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
}
$board_name = $_GET["name"];
$json = file_get_contents("chatlog/" . $board_name .".json");
$chat_log = (json_decode($json, true));

$fp3 = fopen('userlog/mute.txt','a+b');
    
    while (!feof($fp3)) {
      $datas3[] = fgets($fp3);
    }

    foreach($datas3 as $d){
      $trdatas3[] = trim($d);
    }
    
    if(in_array($_SESSION["user"],$trdatas3)){
    
header('Location: index.php?id=ban');}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(!empty($_FILES)){
//（3）$_FILESからファイル名を取得する
$filename = hash('sha256', bin2hex(random_bytes(5))) . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
 
//（4）$_FILESから保存先を取得して、images_after（ローカルフォルダ）に移す
//move_uploaded_file（第1引数：ファイル名,第2引数：格納後のディレクトリ/ファイル名）
$uploaded_path = 'images/'.$filename;
//echo $uploaded_path.'<br>';
 
$result = move_uploaded_file($_FILES['upload_image']['tmp_name'],$uploaded_path);
 
if($result){
  $img_tag = '[img]' . $uploaded_path . '[/img]';
  
  $content = $img_tag;
  
  $count = count($chat_log);
  $num = $count + 1;
  
  $chat_log[$num]["name"] = $_SESSION["user"];
  $chat_log[$num]["content"] = htmlspecialchars($content, ENT_QUOTES);;
  date_default_timezone_set('Asia/Tokyo');
  $chat_log[$num]["datetime"] = date("Y/m/d H:i:s");
  
  $json_en_ud = json_encode($chat_log,JSON_UNESCAPED_UNICODE);

  file_put_contents("chatlog/".$board_name.".json", $json_en_ud);
  
}else{
  $MSG = 'アップロードに失敗しました。ErrorNumber：'.$_FILES['upload_image']['error'];
}}else{
      $fp3 = fopen('userlog/mute.txt','a+b');
    
    while (!feof($fp3)) {
      $datas3[] = fgets($fp3);
    }

    foreach($datas3 as $d){
      $trdatas3[] = trim($d);
    }
    
    if(in_array($_SESSION["user"],$trdatas3)){
    }else{
  $content = $_POST["content"];
  
  $count = count($chat_log);
  $num = $count + 1;
  
  $chat_log[$num]["name"] = $_SESSION["user"];
  $chat_log[$num]["content"] = htmlspecialchars($content, ENT_QUOTES);;
  date_default_timezone_set('Asia/Tokyo');
  $chat_log[$num]["datetime"] = date("Y/m/d H:i:s");
  
  $json_en_ud = json_encode($chat_log,JSON_UNESCAPED_UNICODE);

  file_put_contents("chatlog/".$board_name.".json", $json_en_ud);
}
}
}
?>
<html>
  <head>
    <title>ボード - <?php
      echo($board_name);
      ?></title>
  </head>
  <?php
    require("header.php");
    ?>
  <body>
    <a href="index.php">トップ</a>
    <h1 class="text-4xl">
      <?php
      echo($board_name);
      ?>
    </h1>
    <p style="color: font-size: 10px;
  color: #a1a1a1;;">
      一番最初に投稿した人が、ボードの作成者です。
    </p>
    <div>
      <?php
      function between($beg, $end, $str) {

  $ret_array = array();

  $array = explode($beg,$str);

  foreach($array as $item) {

    $pos = strpos($item,$end);

    if( false !== $pos ) {

      $ret_array[] = substr($item,0,$pos);

    }

  }

  return( $ret_array );

}
      $count1 = count($chat_log);
      if($count1 == 0){
        echo("このボードは現在投稿されていません。<br>このボードに投稿してボードの最初の投稿者になりましょう！");
      }
      $count1++;
      for( $i = 1; $i < $count1; ++$i ) {
      $json = file_get_contents("userdata/". $chat_log[$i]["name"]  . ".json");
      $user = (json_decode($json, true));
      echo "<div class='content' id='" . $i . "'><span class='auth'>#". $i ."</span><p class='text-1xl'>". "<img style='display: inline;' id='icon' src='" . $user["image"] ."' />" . "<span>" .$user["name"] . '</span><br><span class="auth">@'. $chat_log[$i]["name"] . '</span>';
      if($user["authenticated"] == true){
        echo("<span class='auth'>(認証ユーザー)</span></p>");
      }else{
        echo("</p>");
      }
      $text = $chat_log[$i]["content"];  //対象のテキスト
      $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
      $replace = '<a class="underline" target="_blank" rel="noopener noreferrer" href="jump.php?id=$1">$1</a>';
      $message = preg_replace($pattern, $replace, $text);
      $img_array = between("[img]","[/img]",$text);
      if($img_array[0] == ""){
        echo "<p class='content'>". nl2br($message) . '</p>';
      }else{
        echo "<img width='200px' src='". nl2br($img_array[0]) . "'/>";
      }
      
      echo "<p class='datetime'>". $chat_log[$i]["datetime"] . '</p></div>';
      echo "--";
      }
      ?>
    </p>
                <div class="hidden_box">
    <label for="label1">画像を投稿する</label>
    <input type="checkbox" id="label1"/>
    <div class="hidden_show">
      <!--非表示ここから-->     
<!--       	<iframe    width="500"
    height="200"
    src="img-post.php">
      </iframe> -->
  <!-- 画像を表示している箇所 -->
  <form action="" method="post" enctype="multipart/form-data">
 
    <!-- input 属性はtype="file" と指定-->
    <input type="file" name="upload_image">
 
    <!-- 送信ボタン -->
    <input type="submit" calss="btn_submit" value="投稿">
 
  </form>
      <!--ここまで-->
    </div>
</div>
    <form id="login_form" action=<?php echo("chat.php?name=" . $board_name)?> method="post">
      投稿する<br><textarea class="m-form-textarea" required name="content"></textarea><br><br>
      <input style="width: 50%;" type="submit" value="投稿する">
    </form>
  </body>
</html>