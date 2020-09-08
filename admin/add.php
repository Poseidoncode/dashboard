<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

//回傳狀態
$objResponse = [];

if( $_FILES["productImg"]["error"] === 0 ) {
    //為上傳檔案命名
    $strDatetime = "product_".date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["productImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $productImg = $strDatetime.".".$extension;

    //建立資料夾
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
    mkdirs("../images/products");

    //若上傳失敗，則回報錯誤訊息
    if( !move_uploaded_file($_FILES["productImg"]["tmp_name"], "../images/products/{$productImg}") ) {
        $objResponse['success'] = false;
        $objResponse['code'] = 500;
        $objResponse['info'] = "上傳圖片失敗";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    }
}else {
    $productImg = "";
}

//SQL 敘述
$sql = "INSERT INTO `product` (`productName`, `productImg`, `productPrice`, `productAmount`,`productAddress`,`productEndingDate`,`categoryId`) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
//繫結用陣列
$arrParam = [
    $_POST['productName'],
    $productImg,
    $_POST['productPrice'],
    $_POST['productAmount'],
    $_POST['productAddress'],
    $_POST['productEndingDate'],
    $_POST['categoryId']
];

// print_r($arrParam);
// exit();

$stmt = $pdo->prepare($sql);

if($_POST['productName'] == ""){
    header("Refresh: 2; url=./admin.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 500;
    $objResponse['info'] = "新增資料失敗(未填入商品名稱)";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}else {
    $stmt->execute($arrParam);
    // print_r($stmt);
    // echo "\n";
    // print_r($stmt->rowCount());
    // exit();
    if($stmt->rowCount() > 0) {
        header("Refresh: 1; url=./admin.php");
        $objResponse['success'] = true;
        $objResponse['code'] = 200;
        $objResponse['info'] = "新增成功";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    } else {
        header("Refresh: 1; url=./admin.php");
        $objResponse['success'] = false;
        $objResponse['code'] = 500;
        $objResponse['info'] = "沒有新增資料";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    }
}



