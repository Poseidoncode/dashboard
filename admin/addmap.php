<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 

//SQL 敘述
$sql = "INSERT INTO `map` (`productId`) 
        VALUES (?)";

//繫結用陣列
$arrParam = [
    $_POST['productId']

];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: .5; url=./map.php");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "新增成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: .5; url=./map.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 500;
    $objResponse['info'] = "沒有新增資料";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}