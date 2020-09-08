<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//刪資料庫語法

$sql = "DELETE FROM `map` WHERE `mapId` = ? ";

$stmt = $pdo->prepare($sql);
$arrParam = [ $_GET['mapId'] ];
$stmt->execute($arrParam); 

if($stmt->rowCount() > 0) { 
    header("Refresh: .5; url=./map.php");
    echo "刪除成功";
} else {
    header("Refresh: .5; url=./map.php");
    echo "刪除失敗";
}

?>