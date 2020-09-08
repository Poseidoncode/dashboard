<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 

/**
 * 注意：
 * 
 * 因為要判斷更新時檔案有無上傳，
 * 所以要先對前面/其它的欄位先進行 SQL 語法字串連接，
 * 再針對圖片上傳的情況，給予對應的 SQL 字串和資料繫結設定。
 * 
 */


//先對其它欄位，進行 SQL 語法字串連接
$sql = "UPDATE `map` 
        SET 
        `companyId` = ?, 
        `productId` = ?,
        `mapParentId` = ? ";

//先對其它欄位進行資料繫結設定
$arrParam = [
    $_POST['companyId'],
    $_POST['productId'],
    $_POST['mapParentId']
];



//SQL 結尾
$sql.= "WHERE `mapId` = ? ";
$arrParam[] = (int)$_POST['mapId'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if( $stmt->rowCount() > 0 ){
    header("Refresh: .5; url=./map.php");
    echo "更新成功";
} else {
    header("Refresh: .5; url=./map.php");
    echo "沒有任何更新";
}