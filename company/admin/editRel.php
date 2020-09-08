<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>編輯折價券可使用的會員</title>
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
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<form name="myForm" method="POST" action="updateEditRel.php" enctype="multipart/form-data">
    <table class="border">
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `id`,`couponId`, `memberId`, `memberCouponNum`
                FROM `rel_member_coupon` 
                WHERE `id` = ?";

        //設定繫結值
        $arrParam = [(int)$_GET['editId']];

        //查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($arr) > 0) {
        ?>
            <!-- <tr>
                <td class="border">流水號</td>
                <td class="border">
                    <input type="text" name="id" value="<?php echo $arr[0]['id']; ?>" maxlength="9" disabled/>
                </td>
            </tr> -->
            <tr>
                <td class="border">折扣碼ID</td>
                <td class="border">
                    <input type="text" name="couponId" value="<?php echo $arr[0]['couponId']; ?>" maxlength="9" />
                </td>
            </tr>
            <tr>
                <td class="border">會員代碼</td>
                <td class="border">
                    <input type="text" name="memberId" value="<?php echo $arr[0]['memberId']; ?>" maxlength="10" />
                </td>
            </tr>
            <tr>
                <td class="border">數量</td>
                <td class="border">
                    <input type="text" name="memberCouponNum" value="<?php echo $arr[0]['memberCouponNum']; ?>" maxlength="5" />
                </td>
            </tr>
            <tr>
                <td class="border">功能</td>
                <td class="border">
                    <a href="./deleteRel.php?deleteRelId=<?php echo $arr[0]['id']; ?>">刪除</a>
                </td>
            </tr>
        <?php
        } else {
        ?>
            <tr>
                <td class="border" colspan="3">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
            <td class="border" colspan="3"><input type="submit" name="smb" value="修改"></td>
            </tr>
        </tfoo>
    </table>
    <input type="hidden" name="editId" value="<?php echo (int)$_GET['editId']; ?>">
</form>
</body>
</html>