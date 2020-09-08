<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
//列出符合列別的商品
$sqlpaymentTypeId = "UPDATE `orderlist` SET
                    `paymentTypeId` = {$_POST['paymentTypeId']}
                    WHERE `orderId` = {$_POST['orderId']}";
$stmtpaymentTypeId = $pdo->prepare($sqlpaymentTypeId);
$stmtpaymentTypeId->execute();
if($stmtpaymentTypeId->rowCount()>0){
    $objResponse['info'] = "付款方式已更新";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
}

        