<?php
session_start();

if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}

$file = "userdata/".$_SESSION["user"].".json";
$json = file_get_contents("userdata/".$_SESSION["user"].".json");
$user = (json_decode($json, true));
 
//（2）$_FILEに情報があれば（formタグからpost送信されていれば）以下の処理を実行する
if(!empty($_FILES)){
 
//（3）$_FILESからファイル名を取得する
$filename = hash('sha256', $_SESSION["user"]) . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
 
//（4）$_FILESから保存先を取得して、images_after（ローカルフォルダ）に移す
//move_uploaded_file（第1引数：ファイル名,第2引数：格納後のディレクトリ/ファイル名）
$uploaded_path = 'images/'.$filename;
//echo $uploaded_path.'<br>';
 
$result = move_uploaded_file($_FILES['upload_image']['tmp_name'],$uploaded_path);
 
if($result){
  $MSG = "変更しました。";
  
  $user["image"] = $uploaded_path;
  
  $json_en_ud = json_encode($user,JSON_UNESCAPED_UNICODE);

  file_put_contents($file,$json_en_ud);
}else{
  $MSG = 'アップロードに失敗しました。ErrorNumber：'.$_FILES['upload_image']['error'];
}
 
}else{
  $MSG = '画像を選択してください';
}
?>
 
 
<!DOCTYPE html>
<html lang="ja">
<head>
  <title>Spesh-画像の変更</title>
 </head>
  <?php
    require("header.php");
    ?>
<body>
  <div class="alert alert-primary" role="alert">
  <?php echo($MSG)?>
</div>
 <h1>
      Spesh-画像の変更
    </h1>
    <a href="index.php">トップ</a>
<main>
 
<section class="form-container">
 
<!--  メッセージを表示している箇所-->
 
  <!-- 画像を表示している箇所 -->
  <?php if(!empty($img_path)){;?>
 
   <img src="<?php echo $img_path;?>" alt="">
 
  <?php } ;?>
 
 
  <!-- （1）form タグからpost送信する -->
  <form action="" method="post" enctype="multipart/form-data">
 
    <!-- input 属性はtype="file" と指定-->
    <input type="file" name="upload_image">
 
    <!-- 送信ボタン -->
    <input type="submit" calss="btn_submit" value="変更">
 
  </form>
</section>
 
<section class="img-area">
 
</section>
 
</main>
 
 
</body>
</html>