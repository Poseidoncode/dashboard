<?php
session_start();
require_once("./checkSession.php");
require_once('./db.inc.php');

if(!isset($_POST["paymentTypeId"])){
    header("Refresh: 3; url=./myCart.php");
    echo "請選擇付款方式…3秒後回購物車列表";
    exit();
}

$sql = "SELECT `product`.`productId`,`product`.`productPrice`,`product`.`productAmount`
            FROM `product` 
            WHERE `productId` = ? ";
for($i = 0; $i < count($_SESSION["cart"]); $i++){
    $arrParam = [
        (int)$_SESSION["cart"][$i]["productId"]
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
    $arrTmp = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    if($arrTmp['productAmount'] < $_SESSION["cart"][$i]["cartQty"]){
        header("Refresh: 3; url=./myCart.php");
        echo "商品數量不足，請確認";
        exit();
    }
    $arr[]=$arrTmp;
    
} 

//先取得訂單編號
$sqlOrder = "INSERT INTO `orderlist` (`memberId`,`paymentTypeId`) VALUES (?,?)";
$stmtOrder = $pdo->prepare($sqlOrder);
$arrParamOrder = [
    $_SESSION["Id"],
    $_POST["paymentTypeId"]
];
$stmtOrder->execute($arrParamOrder);
$orderId = $pdo->lastInsertId();

$count = 0;

//新增購物車中的每一個項目
$sqlItemList = "INSERT INTO `item_lists` (`orderId`,`productId`,`checkPrice`,`checkQty`,`checkSubtotal`) VALUES (?,?,?,?,?)";
$stmtItemList = $pdo->prepare($sqlItemList);
for($i = 0; $i < count($_POST["productId"]); $i++){
    $arrParamItemList = [
        $orderId,
        $_POST["productId"][$i],
        $_POST["productPrice"][$i],
        $_POST["cartQty"][$i],
        $_POST["subtotal"][$i]
    ];
    $stmtItemList->execute($arrParamItemList);
    $count += $stmtItemList->rowCount();
}
$sqlamount = "UPDATE `product` SET productAmount = ? WHERE `productId` = ?";
$stmtamount = $pdo->prepare($sqlamount);
for($i = 0; $i < count($_POST["productId"]); $i++){
    $arrParamamount = [
        $arr[$i]['productAmount'] - $_POST["cartQty"][$i],
        $_POST["productId"][$i]
    ];
    $stmtamount->execute($arrParamamount);
    $count += $stmtamount->rowCount();
}

if($count > 0) {
    header("Refresh: 3; url=./myCart.php");

    //帳號完成後，注銷購物車資訊
    unset($_SESSION["cart"]);

    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "訂單新增成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 3; url=./order.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "訂單新增失敗";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
