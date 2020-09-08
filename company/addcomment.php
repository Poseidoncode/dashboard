<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 

// print_r($_POST['rating']);
// exit();

//SQL 敘述
$sql = "INSERT INTO `comments` (`content`, `rating`, `itemId`) 
        VALUES (?, ?, ?)";
//繫結用陣列
$arrParam = [

    $_POST['content'],
    $_POST['rating'],
    $_POST['itemId'],
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: 1; url=./editcomment.php");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "新增成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 1; url=./editcomment.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 500;
    $objResponse['info'] = "沒有新增資料";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}