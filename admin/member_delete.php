<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//先刪圖
$sqlImg = "SELECT `memberImg` FROM `member` WHERE `memberId` = ? ";
$arrGetImgParam = [(int)$_GET['deleteId']];

$stmtGetImg = $pdo->prepare($sqlImg);
$stmtGetImg->execute($arrGetImgParam);

if($stmtGetImg->rowCount()>0){

    $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

    if( $arrImg[0]['memberImg']!==NULL){
        @unlink("../images/member/".$arrImg[0]['memberImg']);
    }
}

//刪資料庫
$sql = "DELETE FROM `member` WHERE `memberId` = ? ";
$arrParam = [(int)$_GET['deleteId']];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: 2; url=./member.php");
    echo "刪除成功";
} else {
    header("Refresh: 2; url=./member.php");
    echo "刪除失敗";
}

?>