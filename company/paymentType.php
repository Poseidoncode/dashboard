<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>


<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>編輯付款方式</h3>
<hr/>
<form name="myForm" method="POST" action="./deletePaymentType.php">
<table class="border">
    <thead>
        <tr>
            <th class="border">選擇</th>
            <th class="border">付款方式名稱</th>
            <th class="border">付款方式圖片</th>
            <th class="border">功能</th>
        </tr>
    </thead>
    <tbody>
<?php
$sql = "SELECT `paymentTypeId`, `paymentTypeName`, `paymentTypeImg`
        FROM `payment_types`
        ORDER BY `paymentTypeId` ASC";
$stmt = $pdo->prepare($sql);
$arrParam = [];
$stmt->execute($arrParam);
if($stmt->rowCount() > 0) {
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    for($i = 0; $i < count($arr); $i++) {
?>
    <tr>
        <td class="border">
            <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['paymentTypeId']; ?>" />
        </td>
        <td class="border"><?php echo $arr[$i]['paymentTypeName'] ?></td>
        <td class="border">
            <img class="payment_type_icon" src="../images/payment_types/<?php echo $arr[$i]['paymentTypeImg'] ?>">
        </td>
        <td class="border">
            <a href="editPaymentType.php?paymentTypeId=<?php echo $arr[$i]['paymentTypeId']; ?>">編輯</a>
        </td>
    </tr>

<?php
    }
} else {
?>

<tr><td class="border" colspan="4">尚未建立付款方式</td></tr>

<?php
}
?>
</table>
<input type="submit" name="smb_delete" value="刪除">
</form>

<hr />

<form name="myForm" method="POST" action="./insertPaymentType.php" enctype="multipart/form-data">
<table class="border">
    <thead>
        <tr>
        <th class="border">付款方式名稱</th>
        <th class="border">付款方式圖片</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="border">
                <input type="text" name="paymentTypeName" value="" maxlength="100" />
            </td>
            <td class="border ">
                <input type="file" name="paymentTypeImg" id="files" value="" />
                
            </td>
            
        </tr>
        <tr>
            <td>
                
            </td>
            <td id="list">

            </td>

        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="border" colspan="2"><input type="submit" name="smb_add" value="新增"></td>
        </tr>
    </tfoot>
</table>

</form>

<script>
    function handleFileSelect(evt) {
        var files = evt.target.files;
        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    var td = document.createElement('td');
                    td.innerHTML = [
                        '<img class="thumb" width="200px" src="', 
                        e.target.result,
                        '" title="', 
                        escape(theFile.name), 
                        '"/><br/>'
                    ].join('');
                    let listImg = document.getElementById('list');
                    listImg.innerHTML='';
                    document.getElementById('list').insertBefore(td, null);
                };
            })(f);

            reader.readAsDataURL(f);
        }
    }
    document.getElementById('files').addEventListener('change', handleFileSelect, false);
    </script>
</body>
</html>