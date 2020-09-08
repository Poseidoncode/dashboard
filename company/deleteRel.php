<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php');



//加入繫結陣列
$arrGetImgParam = [
    (int)$_GET['deleteRelId']
];



//SQL 語法
$sql = "DELETE FROM `rel_member_coupon` WHERE `id` = ? ";

$arrParam = [
    (int)$_GET['deleteRelId']
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: 3; url=./couponRel.php");
    echo "刪除成功";
} else {
    header("Refresh: 3; url=./acouponRel.php");
    echo "刪除失敗";
}