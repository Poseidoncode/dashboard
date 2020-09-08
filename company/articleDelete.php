<?php
//引入判斷是否登入機制
require_once('./checkAdmin.php');

//引用資料庫連線
require_once('../db.inc.php');

//先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
$sqlGetImg = "SELECT `img` FROM `article` WHERE `articleId` = ? ";
$stmtGetImg = $pdo->prepare($sqlGetImg);

//加入繫結陣列
$arrGetImgParam = [
    (int)$_GET['deleteId']
];

//執行 SQL 語法
$stmtGetImg->execute($arrGetImgParam);

//若有找到 img 的資料
if($stmtGetImg->rowCount() > 0) {
    //取得指定 id 的學生資料 (1筆)
    $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

    //若是 img 裡面不為空值，代表過去有上傳過
    if($arrImg[0]['img'] !== NULL){
        //刪除實體檔案
        @unlink("../images/article_column/img/".$arrImg[0]['img']);
    }     
}

//SQL 語法
$sql = "DELETE FROM `article` WHERE `articleId` = ? ";

$arrParam = [
    (int)$_GET['deleteId']
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: 3; url=./article.php");
    echo "刪除成功";
} else {
    header("Refresh: 3; url=./article.php");
    echo "刪除失敗";
}