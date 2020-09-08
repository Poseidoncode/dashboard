<?php
header("Content-Type: text/html; chartset=utf-8");

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//SQL 敘述
$sql = "INSERT INTO `rel_member_coupon` 
        (`couponId`, `memberId`, `memberCouponNum`) 
        VALUES (?, ?, ?)";


//繫結用陣列
$arr = [
    $_POST['couponId'],
    $_POST['memberId'],
    $_POST['memberCouponNum']
];

$pdo_stmt = $pdo->prepare($sql);
$pdo_stmt->execute($arr);
if($pdo_stmt->rowCount() === 1) {
    header("Refresh: 3; url=./couponRel.php");
    echo "新增成功";
} else {
    header("Refresh: 3; url=./couponRel.php");
    echo "新增失敗";
}