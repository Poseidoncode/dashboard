<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

$objResponse = [];

$arrParam = [];

$sql = "UPDATE `product` SET ";

$sql.= "`productName` = ? ,";
$arrParam[] = $_POST['productName'];

if( $_FILES["productImg"]["error"] === 0 ) {

    $strDatetime = "product_".date("YmdHis");  
    $extension = pathinfo($_FILES["productImg"]["name"], PATHINFO_EXTENSION);
    $productImg = $strDatetime.".".$extension;

    if( move_uploaded_file($_FILES["productImg"]["tmp_name"], "../images/products/{$productImg}") ) {

        $sqlGetImg = "SELECT `productImg` FROM `product` WHERE `productId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        $arrGetImgParam = [
            (int)$_POST['productId']
        ];

        $stmtGetImg->execute($arrGetImgParam);

        if($stmtGetImg->rowCount() > 0) {
        
            $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC)[0];

            if($arrImg['productImg'] !== NULL){
                @unlink("./images/products/".$arrImg['productImg']);
            } 

            $sql.= "`productImg` = ? ,";
            $arrParam[] = $productImg;
            
        }
    }
}

//productPrice SQL 語句和資料繫結
$sql.= "`productPrice` = ? , ";
$arrParam[] = $_POST['productPrice'];

//productAmount SQL 語句和資料繫結
$sql.= "`productAmount` = ? , ";
$arrParam[] = $_POST['productAmount'];

$sql.= "`productAddress` = ? , ";
$arrParam[] = $_POST['productAddress'];

$sql.= "`productEndingDate` = ? , ";
$arrParam[] = $_POST['mapParentId'];

//categoryId SQL 語句和資料繫結
$sql.= "`categoryId` = ? ";
$arrParam[] = $_POST['categoryId'];




$sql.= "WHERE `productId` = ? ";
$arrParam[] = (int)$_POST['productId'];


$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);


if( $stmt->rowCount()> 0 ){
    header("Refresh: 3; url=./edit.php?productId={$_POST['productId']}");
    $objResponse['success'] = true;
    $objResponse['code'] = 204;
    $objResponse['info'] = "更新成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 3; url=./edit.php?productId={$_POST['productId']}");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "沒有任何更新";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}