<?php
header("Content-Type: text/html; chartset=utf-8");

//引入判斷是否登入機制
require_once('./checkAdmin.php');

//引用資料庫連線
require_once('../db.inc.php');

//SQL 敘述
$sql = "INSERT INTO `article` 
        (`author`, `articleTitle`,`categoryId`, `articleContent`, `img`) 
        VALUES (?, ?, ?, ?, ?)";

if( $_FILES["img"]["error"] === 0 ) {
    //為上傳檔案命名
    $img = date("YmdHis");
    
    //找出副檔名
    $extension = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $imgFileName = $img.".".$extension;

    //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if( !move_uploaded_file($_FILES["img"]["tmp_name"], "../images/article_column/img/".$imgFileName) ) {
        header("Refresh: 3; url=./article.php");
        echo "圖片上傳失敗";
        exit();
    }
}

//繫結用陣列
$arr = [
    $_SESSION['username'],
    $_POST['articleTitle'],
    $_POST['categoryId'],
    $_POST['articleContent'],
    $imgFileName
];

$pdo_stmt = $pdo->prepare($sql);
$pdo_stmt->execute($arr);
if($pdo_stmt->rowCount() === 1) {
    header("Refresh: 3; url=./article.php");
    echo "新增成功";
} else {
    header("Refresh: 3; url=./article.php");
    echo "新增失敗";
}