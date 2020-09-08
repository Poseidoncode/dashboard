<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>優惠券查詢結果</title>
    <style>
    .companyborder {
        border: 1px solid #aaa;
    }
    .wpx {
        width: 60px;
    }
    .tb{
        width: 100%;
    }
    .myForm td , .myForm th{
        padding:3px 10px;
        text-align:center;
    }

    .search td{
        /* border:1px solid black; */
        padding:5px 10px;
    }

    .input{
        width:300px;
    }
    </style>
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>優惠券搜尋結果</h3>
<hr>
<input type="button" value="返回列表" onclick="location.href='./coupon.php'">
<hr>
<form name="myForm2" method="POST"  action="coupon_search.php">
    <table class="search">
        <tr>
            <td><input type="submit" value="搜尋"></td>
        </tr>  
    </table>
</form>

<form name="myForm" class="myForm" method="POST" action="./deleteCouponId.php" >

    <table class="tb">
        <thead>
            <tr>
                <th class="couponborder">選擇</th>
                <th class="couponborder">折扣碼ID</th>
                <th class="couponborder">行銷名稱</th>
                <th class="couponborder">折扣代碼</th>
                <th class="couponborder">折扣數</th>
                <th class="couponborder">數量</th>
                <th class="couponborder">折扣開始時間</th>
                <th class="couponborder">折扣結束時間</th>
                <th class="couponborder">建立時間</th>
                <th class="couponborder">更新時間</th>
                <th class="couponborder">功能</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * 
                    FROM `coupon` 
                    WHERE `discountName` LIKE '%{$_POST['search']}%' 
                    OR `discountCode` LIKE '%{$_POST['search']}%'                   
                    ORDER BY `couponId` ASC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            if( $stmt->rowCount() > 0){
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for( $i = 0 ; $i < count($arr) ; $i++ ){
            ?>
                <tr>
                    <td class="companyborder">
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['couponId']; ?>">
                        <?php echo $arr[$i]['couponId'] ?>
                    </td>
                    <td class="companyborder"><?php echo $arr[$i]['couponId'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['discountName'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['discountCode'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['discountPercent'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['quantity'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['startTime'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['endTime'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['created_at'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['updated_at'] ?></td>
                    <td class="companyborder">
                        <input type="button" value="編輯" onclick="location.href='./editCoupon.php?editId=<?= $arr[$i]['couponId'] ?>'">
                        <input type="button" value="刪除" onclick="location.href='./deleteCoupon.php?deleteCouponId=<?= $arr[$i]['couponId'] ?>'">
                    </td>
                </tr>
            <?php
                }
            }else{
            ?>
                <tr>
                    <td class="companyborder" colspan="10">沒有資料</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
    <input type="submit" name="smb" value="多筆刪除">
</form>



</body>
</html>