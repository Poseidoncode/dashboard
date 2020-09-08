<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 


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

//新增購物車中的每一個項目
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

    //帳號完成後，注銷購物車資訊
    unset($_SESSION["cart"]);

    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "訂單新增成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 3; url=./order.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "訂單新增失敗";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
