<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 


//回傳狀態
$objResponse = [];

if( $_FILES["map_infoImg"]["error"] == 0 ) {
    //為上傳檔案命名
    $strDatetime = "map_info_".date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["map_infoImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $map_infoImg = $strDatetime.".".$extension;

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
    mkdirs("../images/map_infoImg");

    //若上傳失敗，則回報錯誤訊息
    if( !move_uploaded_file($_FILES["map_infoImg"]["tmp_name"], "../images/map_infoImg/{$map_infoImg}") ) {
        $objResponse['success'] = false;
        $objResponse['code'] = 500;
        $objResponse['info'] = "上傳圖片失敗";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    }
}else {
    $map_infoImg = "";
}





//SQL 敘述
$sql = "INSERT INTO `map_info` ( `map_infoName`, `map_infoImg`, `map_infoAddress`, `map_infoPhone`) 
        VALUES (?,?,?,?)";

//繫結用陣列
$arrParam = [
    $_POST['map_infoName'],
    $map_infoImg,
    $_POST['map_infoAddress'],
    $_POST['map_infoPhone']

];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: .5; url=./map_info.php");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "新增成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: .5; url=./map_info.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 500;
    $objResponse['info'] = "沒有新增資料";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}