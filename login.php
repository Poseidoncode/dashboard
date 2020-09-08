<?php
session_start();

require_once('./db.inc.php');

if( isset($_POST['username']) && isset($_POST['pwd']) ){

    if($_POST['identity'] === 'company'){
        if($_POST['username']==="admin"){

            $sql = "SELECT `adminId`,`adminName`, `adminPw` ,`admin-name`
            FROM `admin` 
            WHERE `adminName` = ? 
            AND `adminPw` = ? ";
        }else{
            $sql = "SELECT `companyId`,`companyMail`, `companyPwd`, `companyName`
            FROM `company` 
            WHERE `companyMail` = ? 
            AND `companyPwd` = ? ";
        }

    }elseif($_POST['identity'] === 'member'){
        $sql = "SELECT `memberId`,`memberMail`, `memberPwd`, `memberName`
        FROM `member`
        WHERE `memberMail` = ? 
        AND `memberPwd` = ? ";
    }





    // switch($_POST['identity']){
    //     case 'company':
    //         $sql = "SELECT `companyMail`, `companyPwd`, `companyName`
    //                 FROM `company` 
    //                 WHERE `companyMail` = ? 
    //                 AND `companyPwd` = ? ";
    //     break;

    //     case 'member':
    //         //SQL 語法
    //         $sql = "SELECT `memberMail`, `memberPwd`, `memberName`
    //                 FROM `member`
    //                 WHERE `memberMail` = ? 
    //                 AND `memberPwd` = ? ";
    //     break;
    // }

    $arrParam = [
        $_POST['username'],
        sha1($_POST['pwd'])
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    if( $stmt->rowCount() > 0 ){
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($_POST['identity'] === 'company'){

            if($_POST['username']==="admin"){
                header("location:./admin/info.php");
                $_SESSION['username'] = $arr[0]['adminName'];
                $_SESSION['name'] = $arr[0]['admin-name'];
                $_SESSION['Id'] = $arr[0]['adminId'];
                $_SESSION['identity'] = $_POST['identity'];
                exit();

            }else{

                header("location:./company/admin2.php");
                $_SESSION['username'] = $arr[0]['companyMail'];
                $_SESSION['name'] = $arr[0]['companyName'];
                $_SESSION['Id'] = $arr[0]['companyId'];
                $_SESSION['identity'] = $_POST['identity'];
                exit();
    
            }

        }
        elseif($_POST['identity'] === 'member') {
            header("location:./index.php");
            $_SESSION['username'] = $arr[0]['memberMail'];
            $_SESSION['name'] = $arr[0]['memberName'];
            $_SESSION['Id'] = $arr[0]['memberId'];
            $_SESSION['identity'] = $_POST['identity'];
            exit();
        }
            
    } 

    header("location:./tpl-login.php?error_id=1");
} else {
    header("location:./tpl-login.php?error_id=2");
    // header("Refresh: 1; url=./index.php");
    // echo "請確實登入";
}