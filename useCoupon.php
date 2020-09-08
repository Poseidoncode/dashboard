<?php
session_start();

require_once('./db.inc.php');

if( isset($_POST['couponcode'])&& $_POST['couponcode'] != NULL){

         $sql = "SELECT `coupon`.`couponId`, `coupon`.`discountName`, `coupon`.`discountCode`, `coupon`.`discountPercent`,`coupon`.`quantity` ,`coupon`.`startTime`, `coupon`.`endTime`, `coupon`.`created_at`, `coupon`.`updated_at`,`rel_member_coupon`.`id`,`rel_member_coupon`.`memberId`,`rel_member_coupon`.`memberCouponNum`
                FROM `coupon`
                LEFT JOIN `rel_member_coupon`
                ON `coupon`.`couponId` = `rel_member_coupon`.`couponId`
                LEFT JOIN `member`
                ON `rel_member_coupon`.`memberId` = `member`.`memberId`                
                WHERE `coupon`.`discountCode`= '{$_POST['couponcode']}'
                ORDER BY `couponId`,`memberId` ASC";


    

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    ?>
    
    <?php
    
    if( $stmt->rowCount() > 0 ){
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $objResponse['success'] = true;
        $objResponse['code'] = 200;
        $objResponse['info'] = "新增成功";

        $today = date('Y-m-d') ;
        $endday = $arr[0]['endTime'];
        

             
        if($arr[0]['memberId'] == null && $arr[0]['quantity'] >= 1 && strtotime($today)<=strtotime($endday)){
            $objResponse['data'] = $arr[0]['discountPercent'];
            // $objResponse['cd'] = $_POST['couponcode'];
            // print_r($arr[0]['discountPercent']);
            $_SESSION['coupon']= $arr[0]['discountPercent'];
            echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
            exit();  
        }else if($arr[0]['memberId'] !== null && $arr[0]['memberCouponNum'] >= 1 && strtotime($today)<=strtotime($endday)){
            for($i=0 ; $i<count($arr) ;$i++) {
                 if($arr[$i]['memberId']== $_SESSION['Id'] && $arr[$i]['memberCouponNum'] >= 1){
                    $objResponse['data'] = $arr[$i]['discountPercent'];
                    $_SESSION['coupon']= $arr[$i]['discountPercent'];
                    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);

                    //將coupon數量減一
                    $newNum = ($arr[$i]['memberCouponNum']-1);                    
                    $sqlNum = "UPDATE `rel_member_coupon` 
                    SET
                    `memberCouponNum` = $newNum
                    WHERE `id` = '{$arr[$i]['id']}'";

                    $stmtNum = $pdo->prepare($sqlNum);
                    $stmtNum->execute();

                    exit();   
                 }
                }
        }else{
            // print_r('折價券無法使用');
            $objResponse['data'] = '折價券無法使用';
            echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
            exit();
        }
        $objResponse['data'] = '折價券無法使用';
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();

       
    ?>    
     


    <?php        
    }else{
    // echo "查無此折價券";
    $objResponse['data'] = '查無此折價券';
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
    } 

} else {
    // header("location:./tpl-login.php?error_id=2");
    // header("Refresh: 1; url=./index.php");
    // echo "請確實登入";
    // echo "請輸入折價券";
    $objResponse['data'] = '請輸入折價券';
    // $objResponse['cd'] = '請輸入折價券';
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}   ?>