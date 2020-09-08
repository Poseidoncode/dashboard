<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//刪資料庫語法


$sql = "DELETE FROM `comments` WHERE `id` = ? ";

$count = 0;


for( $i = 0 ; $i < count($_POST['chk']) ; $i++){
    
    $arrParam = [
        $_POST['chk'][$i]
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
    $count += $stmt->rowCount();

}


if($count > 0) {
    header("Refresh: .5; url=./editcomment.php");
    echo "刪除成功";
} else {
    header("Refresh: .5; url=./editcomment.php");
    echo "刪除失敗";
}

?>