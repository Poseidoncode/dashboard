<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php');

//SQL 語法
$sql = "DELETE FROM `rel_member_coupon` WHERE `id` = ? ";

$count = 0;

for($i = 0; $i < count($_POST['chk']); $i++){
    $arrParam = [
        $_POST['chk'][$i]
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
    $count += $stmt->rowCount();
}

if($count > 0) {
    header("Refresh: 3; url=./couponRel.php");
    echo "刪除成功";
} else {
    header("Refresh: 3; url=./couponRel.php");
    echo "刪除失敗";
}