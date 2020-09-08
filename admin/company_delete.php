<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//先刪圖
$sqlImg = "SELECT `companyLogo` FROM `company` WHERE `companyId` = ? ";
$arrGetImgParam = [(int)$_GET['deleteId']];

$stmtGetImg = $pdo->prepare($sqlImg);
$stmtGetImg->execute($arrGetImgParam);

if($stmtGetImg->rowCount()>0){

    $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

    if( $arrImg[0]['companyLogo']!==NULL){
        @unlink("../images/company/".$arrImg[0]['companyLogo']);
    }
}

//刪資料庫
$sql = "DELETE FROM `company` WHERE `companyId` = ? ";
$arrParam = [(int)$_GET['deleteId']];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: 3; url=./company.php");
    echo "刪除成功";
} else {
    header("Refresh: 3; url=./company.php");
    echo "刪除失敗";
}

?>