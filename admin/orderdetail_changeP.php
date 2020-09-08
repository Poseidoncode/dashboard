<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 
$count = 0;
//判斷此筆訂單是否存在
$sqlisset = "SELECT * FROM `orderlist` WHERE `orderId` = {$_POST['orderId']}";
$stmtisset = $pdo->prepare($sqlisset);
$stmtisset->execute();
if(!$stmtisset->rowCount()>0){
    header("Refresh: 3; url=./orders.php");
    $objResponse['info'] = "此筆訂單不存在!!!!";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
//判斷是否選擇商品，和商品數量
if($_POST["productId"] == 0 || $_POST["amountId"] <=0){
    header("Refresh: 3; url=./orderdetail.php?orderId={$_POST['orderId']}");
    $objResponse['info'] = "請確認商品是否正確";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
//先取得商品的價格
$sqlprice = "SELECT `product`.`productId`,`product`.`productPrice`
            FROM `product`
            WHERE `product`.`productId` = ?";
$stmtprice= $pdo->prepare($sqlprice);
$arrParamprice = [
    $_POST["productId"]
];
$stmtprice->execute($arrParamprice);
$arrprice = $stmtprice->fetchAll(PDO::FETCH_ASSOC);
$price = $arrprice[0]['productPrice'];
$total = (int)$price * (int)$_POST['amountId'];

//在更新到訂單明細
$sqlItemList = "UPDATE `item_lists` SET `productId` = ?,`checkPrice` = ?,`checkQty`= ?,`checkSubtotal` =?
WHERE `itemListId`= ?";
$stmtItemList = $pdo->prepare($sqlItemList);
$arrParamItemList = [
    $_POST["productId"],
    $price,
    $_POST["amountId"],
    $total,
    $_POST['itemListId']
];
$stmtItemList->execute($arrParamItemList);
$count += $stmtItemList->rowCount();

if($count > 0) {
    header("Refresh: 3; url=./orderdetail.php?orderId={$_POST['orderId']}");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "訂單更新成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 50; url=./orderdetail.php?orderId={$_POST['orderId']}");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "沒有更新";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
