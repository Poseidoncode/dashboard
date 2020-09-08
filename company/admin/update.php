<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 

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

            if($arrImg['productImg'] !== Null){
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
$arrParam[] = $_POST['productEndingDate'];

//categoryId SQL 語句和資料繫結
$sql.= "`categoryId` = ? ,";
$arrParam[] = $_POST['categoryId'];

$sql.= "`productContent` = ? ";
$arrParam[] = strip_tags($_POST['productContent']);


$sql.= "WHERE `productId` = ? ";
$arrParam[] = (int)$_POST['productId'];

// print_r($productImg);
// print_r($sql);
// exit();
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);
// print_r($arrParam);
// exit();
// print_r($_POST['productName']);
// exit();


// 新增多圖

$objResponseImgs = [];
$countImgs = 0;
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
        $strDatetimeImgs = "productImgs_".date("YmdHis")."_".$i;
        //找出副檔名
        $extensionImgs = pathinfo($_FILES["productImgs"]["name"][$i], PATHINFO_EXTENSION);
        //建立完整名稱
        $productImgs = $strDatetimeImgs.".".$extensionImgs;

        mkdirs("../images/productImgs");

        //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
        if( !move_uploaded_file($_FILES["productImgs"]["tmp_name"][$i], "../images/productImgs/{$productImgs}") ) {
            header("Refresh: 3; url=./multipleImgs.php?productId={$_POST["productId"]}");
            $objResponseImgs['success'] = false;
            $objResponseImgs['code'] = 500;
            $objResponseImgs['info'] = "上傳圖片失敗";
            echo json_encode($objResponseImgs, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }
    //SQL 敘述
    $sqlImgs = "INSERT INTO `multiple_imgs` (`productImgs`,`productId`) VALUES (?, ?)";
    //繫結用陣列
    @$arrParamImgs = [
        $productImgs,
        $_POST["productId"]
    ];
    $stmtImgs = $pdo->prepare($sqlImgs);
    $countImgs += $stmtImgs->execute($arrParamImgs);
}




if( $stmt->rowCount() >0 || $stmtImgs->rowcount()> 0 ){
    header("Refresh: 1; url=./edit.php?productId={$_POST['productId']}");
    $objResponse['success'] = true;
    $objResponse['code'] = 204;
    $objResponse['info'] = "更新成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    echo json_encode($objResponseImgs, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 1; url=./edit.php?productId={$_POST['productId']}");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "沒有任何更新";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    echo json_encode($objResponseImgs, JSON_UNESCAPED_UNICODE);
    exit();
}