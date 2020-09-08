<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />

<h3><?php echo $_GET['productName']?></h3>

<form name="myForm" method="POST" action="./deleteMultipleImgs.php">
<table class="border">
    <thead>
        <tr>
            <th class="border">選擇</th>
            <th class="border">圖片路徑</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT `imgId`, `productImgs`, `created_at`, `updated_at`
            FROM `multiple_imgs`
            WHERE `productId` = ?
            ORDER BY `imgId` ASC";
    $stmt = $pdo->prepare($sql);
    $arrParam = [
        (int)$_GET['productId']
    ];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
    ?>
        <tr>
            <td class="border">
                <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['imgId']; ?>" />
            </td>
            <td class="border">
                <img class="previous_images" src="../images/productImgs/<?php echo $arr[$i]['productImgs'] ?>">
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
    <input type="submit" name="smb_delete" value="刪除">
    <?php
    } else {
    ?>

<tr><td class="border" colspan="2">尚未上傳圖檔</td></tr>

<?php
}
?>
    <input type="hidden" name="productId" value="<?php echo (int)$_GET['productId']; ?>">
</form>

<hr />

<form name="myForm" method="POST" action="./insertMultipleImgs.php" enctype="multipart/form-data">
    <table class="border">
        <thead>
            <tr>
            <th class="border">多圖上傳</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border">
                    <input type="file" name="productImgs[]" id="pre_imgs" value="" multiple />
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="border"><input type="submit" name="smb_add" value="新增"></td>
            </tr>
            <tr>
            <td></td>
                <td id="list"></td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="productId" value="<?php echo (int)$_GET['productId']; ?>">
</form>
</body>
<script>
    function handleFileSelect(evt) {
        var files = evt.target.files;
        let listImg = document.getElementById('list');
        listImg.innerHTML='';
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
                    document.getElementById('list').insertBefore(td, null);
                };
            })(f);

            reader.readAsDataURL(f);
        }
    }
    document.getElementById('pre_imgs').addEventListener('change', handleFileSelect, false);
</script>
</html>