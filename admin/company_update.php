<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


$companyPwd="";
if(empty($_POST["companyPwd_change"])){  //如果密碼欄位=空值
    $companyPwd=$_POST["companyPwd"];
}else{  //不是空值
    $companyPwd=sha1($_POST["companyPwd_change"]);
}



$sql = "UPDATE  `company` 
        SET 
        `companyName`= ? , 
        `companyPhone` = ? ,
        `companyIdentity` = ? ,
        `companyAddress` = ? ,
        `companyMail` = ? ,
        `companyPwd` = ? ,
        `companyStatus` = ? ";


$arrParam = [
    $_POST['companyName'],
    $_POST['companyPhone'],
    $_POST['companyIdentity'],
    $_POST['companyAddress'],
    $_POST['companyMail'],
    $companyPwd,
    $_POST['companyStatus']
];

//判斷圖片上傳是否異常
if( $_FILES["companyLogo"]["error"] === 0){

    $strDatetime = date("YmdHis");

    $exetension = pathinfo($_FILES["companyLogo"]["name"],PATHINFO_EXTENSION);

    $companyLogo = "companyLogo_".$strDatetime.".".$exetension;

    //新圖移至指定位置
    if( move_uploaded_file($_FILES["companyLogo"]["tmp_name"],"../images/company/".$companyLogo)){
        /**
         * 刪除先前的舊檔案: 
         * 一、先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
         * 二、刪除實體檔案
         * 三、更新成新上傳的檔案名稱
         *  */ 

        $sqlGetImg = "SELECT `companyLogo` FROM `company` WHERE `companyId` = ? ";
        $arrGetImgParam = [(int)$_POST['companyId']];

        $stmtImg = $pdo->prepare($sqlGetImg);
        $stmtImg->execute($arrGetImgParam);

        //若有找到 studentImg 的資料
        if($stmtImg->rowCount()> 0 ){
            $arrImg = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

            //若是 studentImg 裡面不為空值，代表過去有上傳過
            if($arrImg[0]['companyLogo'] !== NULL){
                @unlink("../images/company/".$arrImg[0]['companyLogo']);
            }

            $sql.=",";
            $sql.="`companyLogo` = ? ";

            $arrParam[] = $companyLogo;

        }
    }
}

$sql.= "WHERE `companyId` = ? ";
$arrParam[] = (int)$_POST['companyId'];


// echo "<pre>";
// echo  $sql;
// print_r($arrParam);
// // print_r($arrGetImgParam);
// echo "</pre>";
// exit();

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);




if($stmt->rowCount() > 0) {
    header("Refresh: 3; url=./company_info.php?infoId=".$_POST['companyId']);
    echo "更新成功";
} else {
    header("Refresh: 3; url=./company_info.php?infoId=".$_POST['companyId']);
    echo "更新失敗";
}

?>