<?php
session_start();

if($_SESSION["user"] == "") {
   header('Location: index.php?id=notlogin');
}
 
//（2）$_FILEに情報があれば（formタグからpost送信されていれば）以下の処理を実行する
if(!empty($_FILES)){
 
//（3）$_FILESからファイル名を取得する
$filename = hash('sha256', bin2hex(random_bytes(5))) . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
 
//（4）$_FILESから保存先を取得して、images_after（ローカルフォルダ）に移す
//move_uploaded_file（第1引数：ファイル名,第2引数：格納後のディレクトリ/ファイル名）
$uploaded_path = 'images/'.$filename;
//echo $uploaded_path.'<br>';
 
$result = move_uploaded_file($_FILES['upload_image']['tmp_name'],$uploaded_path);
 
if($result){
  $img_tag = '<img style="" width="200px" src="' . $uploaded_path . '"/>';
  
  $MSG = "アップロードに成功しました<br>下に書いてある内容を投稿してください。<div><p id='text'>" . htmlentities($img_tag, ENT_QUOTES, 'UTF-8') . "</p></div>";
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>糸電話[itoden]-画像投稿</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  </head>
<body>
  <div class="alert alert-primary" role="alert">
  <?php echo($MSG)?>
</div>
 <h1>
      糸電話-画像を投稿
    </h1>
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
    <input type="submit" calss="btn_submit" value="投稿">
 
  </form>
</section>
 
<section class="img-area">
 
</section>
 
</main>
 
 
</body>
</html>