<?php
session_start();
require_once("./checkSession.php");
require_once('./db.inc.php');

//預設訊息 (錯誤先行)
$objResponse['success'] = false;
$objResponse['code'] = 400;
$objResponse['info'] = "追蹤商品失敗";

if(!isset($_POST["productId"])){
    header("Refresh: 3; url=./myCart.php");
    $objResponse['info'] = "請先進入商品主要頁面";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

//確認商品是否已追蹤，已追蹤就不再新增資料
$sqlItemTracking = "SELECT count(1) FROM `wishlist` WHERE `memberId` = '{$_SESSION["Id"]}' AND `productId` = {$_POST["productId"]}";
$countItemTracking = $pdo->query($sqlItemTracking)->fetch(PDO::FETCH_NUM)[0];
if( $countItemTracking > 0 ){
    $objResponse['info'] = "商品已追蹤";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

//新增商品追蹤
$sqlOrder = "INSERT INTO `wishlist` (`memberId`,`productId`) VALUES (?,?)";
$stmtOrder = $pdo->prepare($sqlOrder);
$arrParamOrder = [
    $_SESSION["Id"],
    $_POST["productId"]
];
$stmtOrder->execute($arrParamOrder);

header("Refresh: 3; url=./order.php");

$Tracking = "SELECT count(1) FROM `wishlist` WHERE `memberId` = '{$_SESSION["Id"]}'";
$countTracking = $pdo->query($Tracking)->fetch(PDO::FETCH_NUM)[0];

if($stmtOrder->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "追蹤商品成功";
    $objResponse['wishItemNum'] = $countTracking;
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);