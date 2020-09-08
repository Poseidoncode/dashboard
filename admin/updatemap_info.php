<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

$objResponse = [];

$sql = "UPDATE `map_info`
        SET `map_infoName`= ? ,
            `map_infoAddress`= ? ,
            `map_infoPhone`= ? ";

$arrParam = [
            $_POST['map_infoName'],
            $_POST['map_infoAddress'],
            $_POST['map_infoPhone']
];

if( $_FILES["map_infoImg"]["error"] === 0 ) {

    $strDatetime = "map_info_".date("YmdHis");  
    $extension = pathinfo($_FILES["map_infoImg"]["name"], PATHINFO_EXTENSION);
    $map_infoImg = $strDatetime.".".$extension;

    if( move_uploaded_file($_FILES["map_infoImg"]["tmp_name"], "../images/map_infoImg/{$map_infoImg}") ) {

        $sqlGetImg = "SELECT `map_infoImg` FROM `map_info` WHERE `map_infoId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        $arrGetImgParam = [
            (int)$_POST['map_infoId']
        ];

        $stmtGetImg->execute($arrGetImgParam);

        if($stmtGetImg->rowCount() > 0) {
        
            $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC)[0];

            if($arrImg['map_infoImg'] !== NULL){
                @unlink("./images/map_info/".$arrImg['map_infoImg']);
            } 
            $sql.=",";
            $sql.= "`map_infoImg` = ? ";
            $arrParam[] = $map_infoImg;
            
        }
    }
}


$sql.= "WHERE `map_infoId` = ? ";
$arrParam[] = $_POST['map_infoId'];       


$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);




if( $stmt->rowCount() > 0 ){
    // header("Refresh: .5; url=./editmap_info.php");
    echo "更新成功";
} else {
    // header("Refresh: .5; url=./editmap_info.php");
    echo "沒有任何更新";
}


// if( $_FILES["map_infoImg"]["error"] === 0 ) {

//     $strDatetime = "map_info_".date("YmdHis");  
//     $extension = pathinfo($_FILES["map_infoImg"]["name"], PATHINFO_EXTENSION);
//     $productImg = $strDatetime.".".$extension;

//     if( move_uploaded_file($_FILES["map_infoImg"]["tmp_name"], "../images/map_info/{$map_infoImg}") ) {

//         $sqlGetImg = "SELECT `map_infoImg` FROM `map_info` WHERE `map_infoId` = ? ";
//         $stmtGetImg = $pdo->prepare($sqlGetImg);

//         $arrGetImgParam = [
//             (int)$_POST['map_infoId']
//         ];

//         $stmtGetImg->execute($arrGetImgParam);

//         if($stmtGetImg->rowCount() > 0) {
        
//             $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC)[0];

//             if($arrImg['map_infoImg'] !== NULL){
//                 @unlink("./images/map_info/".$arrImg['map_infoImg']);
//             } 

//             $sql.= "`map_infoImg` = ? ,";
//             $arrParam[] = $map_infoImg;
            
//         }
//     }
// }

// //productPrice SQL 語句和資料繫結
// $sql.= "`productPrice` = ? , ";
// $arrParam[] = $_POST['productPrice'];

// //productAmount SQL 語句和資料繫結
// $sql.= "`productAmount` = ? , ";
// $arrParam[] = $_POST['productAmount'];

// $sql.= "`productAddress` = ? , ";
// $arrParam[] = $_POST['productAddress'];

// $sql.= "`productEndingDate` = ? , ";
// $arrParam[] = $_POST['mapParentId'];

// //categoryId SQL 語句和資料繫結
// $sql.= "`categoryId` = ? ";
// $arrParam[] = $_POST['categoryId'];




// $sql.= "WHERE `productId` = ? ";
// $arrParam[] = (int)$_POST['productId'];


// $stmt = $pdo->prepare($sql);
// $stmt->execute($arrParam);


// if( $stmt->rowCount()> 0 ){
//     header("Refresh: 3; url=./edit.php?productId={$_POST['productId']}");
//     $objResponse['success'] = true;
//     $objResponse['code'] = 204;
//     $objResponse['info'] = "更新成功";
//     echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
//     exit();
// } else {
//     header("Refresh: 3; url=./edit.php?productId={$_POST['productId']}");
//     $objResponse['success'] = false;
//     $objResponse['code'] = 400;
//     $objResponse['info'] = "沒有任何更新";
//     echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
//     exit();
// }