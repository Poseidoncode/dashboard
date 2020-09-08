<?php
session_start(); 

if( !isset($_SESSION['username']) && !isset($_SESSION['identity']) ) {
    header("Refresh: 3; url=../../login.php");
    echo "請確實登入…3秒後自動回登入頁";
    exit();
}

if($_SESSION['identity'] !== 'company'){
    header("Refresh: 3; url=../../login.php");
    echo "您無權使用該網頁…3秒後自動回登入頁";
    exit();
}