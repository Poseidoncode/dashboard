
<?php
session_start();
require_once('./db.inc.php');
$sql = "SELECT `product`.`productId`,`product`.`productPrice`,`product`.`productAmount`
            FROM `product` 
            WHERE `productId` = ? ";


if(isset($_POST['amount'])){
    $total = 0;
    $_SESSION['cart'][$_POST['num']]['cartQty']=$_POST['amount'];
    for($i = 0; $i < count($_SESSION["cart"]); $i++){
        $arrParam = [
            (int)$_SESSION["cart"][$i]["productId"]
        ];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);
        $arrTmp = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $arrTmp['cartQty'] = $_SESSION["cart"][$i]["cartQty"];
        $arr[] = $arrTmp;
    } 
    for($i = 0; $i < count($arr); $i++) { 
        $total += $arr[$i]["productPrice"] * $arr[$i]["cartQty"];
    }   
    $objResponse['total'] = $total*$_SESSION['coupon'];
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
    


}else{
    
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "錯誤";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}