<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('./templates/title.php');
require_once('./templates/sidebar.php');
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>編輯折價券</title>
    <style>
    .border {
        border: 1px solid;
    }
    .w200px {
        width: 200px;
    }
    </style>
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<hr />
<h3>優惠券編輯</h3>
<hr />
<form name="myForm" method="POST" action="updateEditCoupon.php" enctype="multipart/form-data">
    <table class="border">
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `couponId`, `discountName`, `discountCode`, `discountPercent`, `quantity`,`startTime`, `endTime`
                FROM `coupon` 
                WHERE `couponId` = ?";

        //設定繫結值
        $arrParam = [(int)$_GET['editId']];

        //查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($arr) > 0) {
        ?>
            <tr>
                <td class="border">折扣碼ID</td>
                <td class="border">
                    <input type="text" name="couponId" value="<?php echo $arr[0]['couponId']; ?>" maxlength="9" />
                </td>
            </tr>
            <tr>
                <td class="border">行銷名稱</td>
                <td class="border">
                    <input type="text" name="discountName" value="<?php echo $arr[0]['discountName']; ?>" maxlength="20" />
                </td>
            </tr>
            <tr>
                <td class="border">折扣代碼</td>
                <td class="border">
                    <input type="text" name="discountCode" value="<?php echo $arr[0]['discountCode']; ?>" maxlength="16" />
                </td>
            </tr>
            <tr>
                <td class="border">折扣數</td>
                <td class="border">
                    <input type="text" name="discountPercent" value="<?php echo $arr[0]['discountPercent']; ?>" maxlength="4" />
                </td>
            </tr>
            <tr>
                <td class="border">數量</td>
                <td class="border">
                    <input type="text" name="quantity" value="<?php echo $arr[0]['quantity']; ?>" maxlength="4" />
                </td>
            </tr>
            <tr>
                <td class="border">折扣開始時間</td>
                <td class="border">
                    <input type="datetime-local" name="startTime" value="<?php echo date('Y-m-d\TH:i:s', strtotime($arr[0]['startTime'])); ?>"/>                   
                </td>
            </tr>
            <tr>
                <td class="border">折扣結束時間</td>
                <td class="border">
                     <input type="datetime-local" name="endTime" value="<?php echo date('Y-m-d\TH:i:s', strtotime($arr[0]['endTime'])); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="border">功能</td>
                <td class="border">
                    <a href="./deleteCoupon.php?deleteCouponId=<?php echo $arr[0]['couponId']; ?>">刪除</a>
                </td>
            </tr>
        <?php
        } else {
        ?>
            <tr>
                <td class="border" colspan="6">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
            <td class="border" colspan="6"><input type="submit" name="smb" value="修改"></td>
            </tr>
        </tfoo>
    </table>
    <input type="hidden" name="editId" value="<?php echo (int)$_GET['editId']; ?>">
</form>
</body>
</html>