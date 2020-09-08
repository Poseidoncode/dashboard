<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新增折扣碼</title>
    <style>
    .border {
        border: 1px solid;
    }
    </style>
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>新增優惠券</h3>
<hr />
<form name="myForm" method="POST" action="./insertCoupond.php" enctype="multipart/form-data">
<table class="border">
    <thead>
        <tr>
            <th class="border">折扣碼ID</th>
            <th class="border">行銷名稱</th>
            <th class="border">折扣代碼</th>
            <th class="border">折扣數</th>
            <th class="border">數量</th>
            <th class="border">折扣開始時間</th>
            <th class="border">折扣結束時間</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="border">
                <input type="text" name="couponId" id="couponId" value="" maxlength="9" />
            </td>
            <td class="border">
                <input type="text" name="discountName" id="discountName" value="" maxlength="20" />
            </td>
            <td class="border">
                <input type="text" name="discountCode" id="discountCode" value="" maxlength="16" />
            </td>
            <td class="border">
                <input type="text" name="discountPercent" id="discountPercent" value="" maxlength="10" />
            </td>
            <td class="border">
                <input type="text" name="quantity" id="quantity" value="" maxlength="5" />
            </td>
            <td class="border">
                <input type="datetime-local" id="startTime" name="startTime">
            </td>
            <td class="border">
                <input type="datetime-local" id="endTime" name="endTime">
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="border" colspan="6"><input type="submit" name="smb" value="新增"></td>
        </tr>
    </tfoot>
</table>
</form>

</body>
</html>