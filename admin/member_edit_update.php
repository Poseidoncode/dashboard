<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線




// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";
// exit();

$mamberPwd="";
if(empty($_POST["memberPwd_change"])){  //如果密碼欄位=空值
    $memberPwd=$_POST["memberPwd"];
}else{  //不是空值
    $memberPwd=sha1($_POST["memberPwd_change"]);
}



//先對其它欄位，進行 SQL 語法字串連接
$sql = "UPDATE `member` 
        SET 
        `memberName`= ? ,
        `memberGender` = ? ,
        `memberBirth` = ? ,
        `memberPhone` = ? ,
        `memberIdentity` = ? ,
        `memberAddress` = ? ,
        `memberMail` = ? ,
        `memberPwd` = ? ,
        `memberStatus` = ? ";

//先對其它欄位進行資料繫結設定
$arrParam = [
    $_POST['memberName'],
    $_POST['memberGender'],
    $_POST['memberBirth'],
    $_POST['memberPhone'],
    $_POST['memberIdentity'],
    $_POST['memberAddress'],
    $_POST['memberMail'],
    $memberPwd,
    $_POST['memberStatus']
];




//判斷圖片上傳是否異常
if( $_FILES["memberImg"]["error"] === 0){

    $strDatetime = date("YmdHis");

    $exetension = pathinfo($_FILES["memberImg"]["name"],PATHINFO_EXTENSION);

    $memberImg = "memberImg_".$strDatetime.".".$exetension;

    //新圖移至指定位置
    if( move_uploaded_file($_FILES["memberImg"]["tmp_name"],"../images/member/".$memberImg)){
        /**
         * 刪除先前的舊檔案: 
         * 一、先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
         * 二、刪除實體檔案
         * 三、更新成新上傳的檔案名稱
         *  */ 

        $sqlGetImg = "SELECT `memberImg` FROM `member` WHERE `memberId` = ? ";
        $arrGetImgParam = [(int)$_POST['memberId']];

        $stmtImg = $pdo->prepare($sqlGetImg);
        $stmtImg->execute($arrGetImgParam);

        //若有找到 studentImg 的資料
        if($stmtImg->rowCount()> 0 ){
            $arrImg = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

            //若是 studentImg 裡面不為空值，代表過去有上傳過
            if($arrImg[0]['memberImg'] !== NULL){
                @unlink("../images/member/".$arrImg[0]['memberImg']);
            }

            $sql.=",";

            $sql.="`memberImg` = ? ";

            $arrParam[] = $memberImg;

        }
    }
}

$sql.= "WHERE `memberId` = ? ";
$arrParam[] = (int)$_POST['memberId'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

// echo "<pre>";
// print_r($arrParam);

// echo "</pre>";
// exit();


if( $stmt->rowCount() > 0 ){
    header("Refresh: 0; url=./member_edit.php?editId=".$_POST['memberId']."&ok=1");
    // echo "更新成功";
} else {
    header("Refresh: 0; url=./member_edit.php?editId=".$_POST['memberId']."&err=1");
    // echo "沒有任何更新";
}











?>
