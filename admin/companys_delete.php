<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//刪資料庫語法

$sql = "DELETE FROM `company` WHERE `companyId` = ? ";

$count = 0;


//刪圖片語法
$sqlImg = "SELECT `companyLogo` FROM `company` WHERE `companyId` = ? ";
$stmtGetImg = $pdo->prepare($sqlImg);

for( $i = 0 ; $i < count($_POST['chk']) ; $i++){
    $arrImg = [$_POST['chk'][$i]];

    $stmtGetImg->execute($arrImg);

    // 先刪實體圖
    if($stmtGetImg->rowCount() > 0 ){
        $arr = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

        if($arr[0]['companyLogo']!==NULL){
            @unlink("../images/company/".$arr[0]['companyLogo']);
        }
    }

    $arrParam = [
        $_POST['chk'][$i]
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
    $count += $stmt->rowCount();

// echo "<pre>";
// print_r($stmt);
// echo "</pre>";
// exit();

}

if($count > 0) {
    header("Refresh: 3; url=./company.php");
    echo "刪除成功";
} else {
    header("Refresh: 3; url=./company.php");
    echo "刪除失敗";
}

?>