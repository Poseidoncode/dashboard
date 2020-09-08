<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 

$objResponse = [];

$count = 0;

function mkdirs($dir, $mode = 0777)
{
    if (is_dir($dir) || @mkdir($dir, $mode)) {
        return TRUE; 
    }
    if (!mkdirs(dirname($dir), $mode)){
        return FALSE;
    } 
    return @mkdir($dir, $mode);
}

for($i = 0; $i < count($_FILES["productImgs"]["name"]); $i++){
    //判斷上傳是否成功 (error === 0)
    if( $_FILES["productImgs"]["error"][$i] === 0 ) {
        //為上傳檔案命名
        $strDatetime = "productImgs_".date("YmdHis")."_".$i;
            
        //找出副檔名
        $extension = pathinfo($_FILES["productImgs"]["name"][$i], PATHINFO_EXTENSION);

        //建立完整名稱
        $productImgs = $strDatetime.".".$extension;

        
        mkdirs("../images/productImgs");

        //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
        if( !move_uploaded_file($_FILES["productImgs"]["tmp_name"][$i], "../images/productImgs/{$productImgs}") ) {
            header("Refresh: 3; url=./multipleImgs.php?productId={$_POST["productId"]}");
            $objResponse['success'] = false;
            $objResponse['code'] = 500;
            $objResponse['info'] = "上傳圖片失敗";
            echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }

    //SQL 敘述
    $sql = "INSERT INTO `multiple_imgs` (`productImgs`,`productId`) VALUES (?, ?)";

    //繫結用陣列
    $arrParam = [
        $productImgs,
        $_POST["productId"]
    ];

    $stmt = $pdo->prepare($sql);
    $count += $stmt->execute($arrParam);
}

if($count > 0) {
    header("Refresh: 3; url=./multipleImgs.php?productId={$_POST["productId"]}");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "新增成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 3; url=./multipleImgs.php?productId={$_POST["productId"]}");
    $objResponse['success'] = false;
    $objResponse['code'] = 500;
    $objResponse['info'] = "沒有新增資料";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}