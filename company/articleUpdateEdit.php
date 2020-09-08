<?php
//引入判斷是否登入機制
require_once('./checkAdmin.php');

//引用資料庫連線
require_once('../db.inc.php');

/**
 * 注意：
 * 
 * 因為要判斷更新時檔案有無上傳，
 * 所以要先對前面/其它的欄位先進行 SQL 語法字串連接，
 * 再針對圖片上傳的情況，給予對應的 SQL 字串和資料繫結設定。
 * 
 */

// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";
// exit();

//先對其它欄位，進行 SQL 語法字串連接
$sql = "UPDATE `article` 
        SET 
        `articleTitle` = ?,
        `categoryId` = ?,
        `articleContent` = ? ";

//先對其它欄位進行資料繫結設定
$arrParam = [
    $_POST['articleTitle'],
    $_POST['categoryId'],
    strip_tags($_POST['articleContent'])
];

//判斷檔案上傳是否正常，error = 0 為正常
if( $_FILES["img"]["error"] === 0 ) {
    //為上傳檔案命名
    $strDatetime = date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $img = $strDatetime.".".$extension;

    //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if( move_uploaded_file($_FILES["img"]["tmp_name"], "../images/article_column/img/".$img) ) {
        /**
         * 刪除先前的舊檔案: 
         * 一、先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
         * 二、刪除實體檔案
         * 三、更新成新上傳的檔案名稱
         *  */ 

        //先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `img` FROM `article` WHERE `articleId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        //加入繫結陣列
        $arrGetImgParam = [
            (int)$_POST['editId']
        ];

        //執行 SQL 語法
        $stmtGetImg->execute($arrGetImgParam);

        //若有找到 img 的資料
        if($stmtGetImg->rowCount() > 0) {
            //取得指定 articleId 的學生資料 (1筆)
            $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

            //若是 img 裡面不為空值，代表過去有上傳過
            if($arrImg[0]['img'] !== NULL){
                //刪除實體檔案
                @unlink("../images/article_column/img/".$arrImg[0]['img']);
            } 
            
            /**
             * 因為前面 `studentDescription` = ? 後面沒有加「,」，
             * 若是這裡會有更新 img 的需要，
             * 代表 `studentDescription` = ? 後面缺一個「,」，
             * 不然會報錯
             */
            $sql.= ",";

            //img SQL 語句字串
            $sql.= "`img` = ? ";

            //僅對 img 進行資料繫結
            $arrParam[] = $img;
            
        }
    }
}

//SQL 結尾
$sql.= "WHERE `articleId` = ? ";
$arrParam[] = (int)$_POST['editId'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if( $stmt->rowCount() > 0 ){
    header("Refresh: 3; url=./article.php");
    echo "更新成功";
} else {
    header("Refresh: 3; url=./article.php");
    echo "沒有任何更新";
}