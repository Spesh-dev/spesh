<?php
session_start();
    $send_name = "@". $_SESSION["user"];
    $strMsg = $send_name . "が入力中...";
    file_put_contents('type.txt', $strMsg, LOCK_EX);
?>