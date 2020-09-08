<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
//列出符合列別的商品
$sqlprocutName = "SELECT `product`.`productId`,`product`.`productName`
                    FROM `product`
                    WHERE `product`.`categoryId` = {$_POST['categoryId']}
                    AND `product`.`companyId` = {$_SESSION['Id']}";
$stmtprocutName = $pdo->prepare($sqlprocutName);
$stmtprocutName->execute();
if($stmtprocutName->rowCount() > 0){
    $arrprocutName = $stmtprocutName->fetchAll(PDO::FETCH_ASSOC);
    echo "<option value='0'>-----請選擇-----</option>";
    for($i = 0; $i < count($arrprocutName); $i++) {
        echo "<option value='{$arrprocutName[$i]['productId']}'>{$arrprocutName[$i]['productName']}</option>";
    }
}else{
    echo "<option value='0'>目前沒有商品</option>";
}        
        