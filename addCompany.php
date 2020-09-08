<?php
session_start();
require_once('./db.inc.php');




//判斷是否有未填項
if($_POST["companyName"] == ""  ||  $_POST["companyPhone"] == "" || $_POST["companyIdentity"] == "" || $_POST["companyAddress"] == "" || $_POST["companyMail"] == "" || $_POST["companyPwd"] == ""){
    header("Refresh: 0; url=./register_company.php?err=1");   
    exit();
}


//搜尋語法
$sql = "INSERT INTO `company` (`companyName`,`companyPhone`,`companyIdentity`,`companyAddress`,`companyMail`,`companyPwd`,`companyLogo`,`companyStatus`) 
VALUES ( ? , ? , ? , ? , ? , ? , ? , ? )";

$sittime = date("YmdHis");


if($_FILES['companyLogo']["error"] === 4){
    // echo "none";
    $tmpImg = "companyLogo_".$sittime.".jpg";
    copy("./images/company/tmp/tmp.jpg","./images/company/".$tmpImg);
}elseif($_FILES["companyLogo"]["error"] === 0){
    $extension = pathinfo($_FILES["companyLogo"]["name"], PATHINFO_EXTENSION);
    $tmpImg = "companyLogo_".$sittime.".".$extension;
    if(!move_uploaded_file($_FILES["companyLogo"]["tmp_name"], "./images/company/".$tmpImg)){
        header("Refresh:3; url=./register_company.php.php");
        echo "圖片上傳失敗";
        exit();
    }
}

$arrParam = [
    $_POST["companyName"],
    $_POST["companyPhone"],
    $_POST["companyIdentity"],
    $_POST["companyAddress"],
    $_POST["companyMail"],
    sha1($_POST["companyPwd"]),
    $tmpImg,
    "false"
];



//查詢
$stmt = $pdo->prepare($sql);

// var_dump($stmt);
// echo "<pre>";
// print_r($sql);
// print_r($stmt);
// print_r($arrParam);
// echo "</pre>";
// exit();



$stmt->execute($arrParam);


if($stmt->rowCount() === 1) {
    header("Refresh: 0; url=./register_company.php?complete=1");
} else {
    header("Refresh: 0; url=./register_company.php?err=2");
}

?>