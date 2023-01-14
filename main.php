<?php
session_start();

    $json = file_get_contents("userdata/".$_SESSION["user"].".json");
    $user = (json_decode($json, true));

    $name = $user["name"];

    $count = 0;
    $strMsg   = '';

    $request = '';
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        $request = strtolower($_SERVER['HTTP_X_REQUESTED_WITH']);
    }
    if ($request !== 'xmlhttprequest') {
        exit;
    }
 
    $message = '';
    if (isset($_POST['message']) && is_string($_POST['message'])) {
      $text = $_POST['message'];  //対象のテキスト
      
      $message = htmlspecialchars($text, ENT_QUOTES);
    }
    if ($message == '') {
        exit;
    }

    $fp = fopen('message.log', 'r');
    if (flock($fp, LOCK_SH)) {
        while (!feof($fp)) {
            if ($count > 500) {
                break;
            }
            $strMsg = $strMsg . fgets($fp);
            $count = $count + 1;
        }
    }
    flock($fp, LOCK_UN);
    fclose($fp);

    $send_img = '<img id="icon" src="' . $user["image"] . '">';
    $send_name = '"' . $name .'"'. "@". $_SESSION["user"];
    if($user["authenticated"]){
      $send_name = '<span style="color: #126dff;">' . $send_name .'</span>';
    }
    $rep_btn = "<button type='button' name='rep' value='Reply: ". $message ." --' onclick='onButtonClick(this.value);'>返信</button>";
    $strMsg = $send_img . "　". $send_name . ":" . date('Y/m/d H:i:s',strtotime("now +9 hours")) . $rep_btn ."\n" . $message . "\n" . $strMsg;
    file_put_contents('message.log', $strMsg, LOCK_EX);
?>