<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 
//判斷商品數量
if((int)$_POST['amountId'] <= 0){
    header("Refresh: 3; url=./insetOrder.php");
    $objResponse['info'] = "請確認商品數量";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
//判斷會員是否存在
$sqlmember= "SELECT `memberId`
            FROM `member`
            WHERE `memberId` = {$_POST["memberId"]}";
$stmtmember= $pdo->prepare($sqlmember);
$stmtmember->execute();
if(!$stmtmember->rowCount()>0){
    header("Refresh: 3; url=./insetOrder.php");
    $objResponse['info'] = "請確認會員ID";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
//先取得商品的價格 判斷商品是否存在
$sqlprice = "SELECT `product`.`productId`,`product`.`productPrice`
            FROM `product`
            WHERE `product`.`productId` = ?";
$stmtprice= $pdo->prepare($sqlprice);
$arrParamprice = [
    $_POST["productId"]
];
$stmtprice->execute($arrParamprice);
if($stmtprice->rowCount()>0){
    $arrprice = $stmtprice->fetchAll(PDO::FETCH_ASSOC);
    $price = $arrprice[0]['productPrice'];
    $total = (int)$price * (int)$_POST['amountId'];
}else{
    header("Refresh: 3; url=./insetOrder.php");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "沒有此項商品";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
//先取得訂單編號
$sqlOrder = "INSERT INTO `orderlist` (`memberId`,`paymentTypeId`) VALUES (?,?)";
$stmtOrder = $pdo->prepare($sqlOrder);
$arrParamOrder = [
    $_POST["memberId"],
    $_POST["paymentTypeId"]
];
$stmtOrder->execute($arrParamOrder);
$orderId = $pdo->lastInsertId();

$count = 0;

//在新增到訂單明細
$sqlItemList = "INSERT INTO `item_lists` (`orderId`,`productId`,`checkPrice`,`checkQty`,`checkSubtotal`) VALUES (?,?,?,?,?)";
$stmtItemList = $pdo->prepare($sqlItemList);
$arrParamItemList = [
    $orderId,
    $_POST["productId"],
    $price,
    $_POST["amountId"],
    $total
];
$stmtItemList->execute($arrParamItemList);
$count += $stmtItemList->rowCount();

if($count > 0) {
    header("Refresh: 3; url=./orders.php");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "訂單新增成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 3; url=./insetOrder.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "訂單新增失敗";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
