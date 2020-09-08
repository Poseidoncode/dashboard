<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
//刪除訂單明細
if(isset($_GET['itemListId'])){
    $sqlItem = "DELETE FROM `item_lists` WHERE `itemListId` = ? ";
    $count = 0;
    $arrParam = [
        $_GET['itemListId']
    ];

    $stmtItem = $pdo->prepare($sqlItem);
    $stmtItem->execute($arrParam);
    $count += $stmtItem->rowCount();
    //查看目前訂單明細還有沒有商品，沒有的話就砍掉
    $sqlexist = "SELECT `orderId` FROM `item_lists` WHERE `orderId` = {$_GET['orderId']}";
    $stmtexist = $pdo->prepare($sqlexist);
    $stmtexist->execute();
    if(!$stmtexist->rowCount()>0){
        $sql = "DELETE FROM `orderlist` WHERE `orderId` = {$_GET['orderId']} ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        header("Refresh: 3; url=./orders.php");
        echo "刪除成功";
        exit();
    }
    if($count > 0) {
        header("Refresh: 3; url=./orderdetail.php?orderId={$_GET['orderId']}");
        echo "刪除成功";
    } else {
        header("Refresh: 3; url=./orderdetail.php?orderId={$_GET['orderId']}");
        echo "刪除失敗";
    }
}else{
    header("Refresh: 3; url=./orderdetail.php?orderId={$_GET['orderId']}");
    echo "沒有選取資料";
}
?>