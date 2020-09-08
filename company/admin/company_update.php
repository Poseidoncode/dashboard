<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


$sql = "UPDATE  `company` SET `companyStatus`= ?   WHERE `companyId` = ? ";
$arr = [$_POST['companyStatus'],$_POST['companyId']];



$stmt = $pdo->prepare($sql);
$stmt->execute($arr);

// echo "<pre>";
// print_r($arr);
// // print_r($arrGetImgParam);
// echo "</pre>";
// exit();


if($stmt->rowCount() > 0) {
    header("Refresh: 3; url=./company_info.php?infoId=".$_POST['companyId']);
    echo "更新成功";
} else {
    header("Refresh: 3; url=./company_info.php?infoId=".$_POST['companyId']);
    echo "更新失敗";
}

?>