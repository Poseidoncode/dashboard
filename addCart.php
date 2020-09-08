<?php
session_start();
require_once('./db.inc.php');

if( !isset($_POST['cartQty']) || !isset($_POST['productId']) ){
    header("Refresh: 3; url=./itemList.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "資料傳遞有誤";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

//先前沒有建立購物車，就直接初始化 (建立)
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$objResponse = [];


//SQL 敘述
$sql = "SELECT `product`.`productId`, `product`.`productName`, `product`.`productImg`, `product`.`productPrice`, 
            `product`.`productAmount`, `product`.`categoryId`, `product`.`created_at`, `product`.`updated_at`,
            `category`.`categoryId`, `category`.`categoryName`
        FROM `product` INNER JOIN `category`
        ON `product`.`categoryId` = `category`.`categoryId`
        WHERE `productId` = ? ";

$arrParam = [
    (int)$_POST['productId']
];

//查詢
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

//若商品項目個數大於 0，則列出商品
if($stmt->rowCount() > 0) {
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    for($i=0;$i<count($_SESSION['cart']);$i++){
        if((int)$_POST['productId'] == $_SESSION['cart'][$i]['productId']){
            header("Refresh: 3; url=./itemDetail.php?productId={$_POST['productId']}");
            $objResponse['success'] = false;
            $objResponse['code'] = 400;
            $objResponse['info'] = "已在購物車";
            $objResponse['cartItemNum'] = count($_SESSION['cart']);
            echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }
    //將主要資料放到購物車中
    $_SESSION['cart'][] = [
        "productId"    => $arr[0]["productId"],
        "cartQty"   => $_POST["cartQty"]
    ];
    
    header("Refresh: 3; url=./myCart.php");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "已加入購物車";
    $objResponse['cartItemNum'] = count($_SESSION['cart']);
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    $sqldeletewish="DELETE FROM `wishlist` WHERE `memberId` = {$_SESSION['Id']}";
    $stmtdeletewish = $pdo->prepare($sqldeletewish);
    $stmtdeletewish->execute();
    exit();
} else {
    header("Refresh: 3; url=./itemDetail.php?productId={$_POST['productId']}");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "查無商品項目";
    $objResponse['cartItemNum'] = count($_SESSION['cart']);
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
    
}