<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//刪除訂單及訂單明細
if(isset($_GET['orderId'])){
    $sql = "DELETE FROM `orderlist` WHERE `orderId` = ? ";
    $sqlItem = "DELETE FROM `item_lists` WHERE `orderId` = ? ";

    $count = 0;
    $arrParam = [
        $_GET['orderId']
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
    $stmtItem = $pdo->prepare($sqlItem);
    $stmtItem->execute($arrParam);
    $count += $stmt->rowCount();    


    if($count > 0) {
        header("Refresh: 3; url=./orders.php");
        echo "刪除成功";
    } else {
        header("Refresh: 3; url=./orders.php");
        echo "刪除失敗";
    }
}else{
    header("Refresh: 3; url=./orders.php");
    echo "沒有選取資料";
}
?>