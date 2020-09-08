<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>

<h3>多圖設定</h3>

<form name="myForm" method="POST" action="./articleDeleteMultipleImages.php">
<table class="border">
    <thead>
        <tr>
            <th class="border">選擇</th>
            <th class="border">圖片路徑</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT `multipleImageId`, `multipleImageImg`, `created_at`, `updated_at`
            FROM `article_multiple_images`
            WHERE `articleId` = ?
            ORDER BY `multipleImageId` ASC";
    $stmt = $pdo->prepare($sql);
    $arrParam = [
        (int)$_GET['articleId']
    ];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
    ?>
        <tr>
            <td class="border">
                <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['multipleImageId']; ?>" />
            </td>
            <td class="border">
                <img class="previous_images" src="./multiple_images/<?php echo $arr[$i]['multipleImageImg'] ?>">
            </td>
        </tr>

    <?php
        }
    } else {
    ?>

<tr><td class="border" colspan="2">尚未上傳圖檔</td></tr>

<?php
}
?>
    </table>
    <input type="submit" name="smb_delete" value="刪除">
    <input type="hidden" name="articleId" value="<?php echo (int)$_GET['articleId']; ?>">
</form>

<hr />

<form name="myForm" method="POST" action="./articleInsertMultipleImages.php" enctype="multipart/form-data">
    <table class="border">
        <thead>
            <tr>
            <th class="border">多圖上傳</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border">
                    <input type="file" name="multipleImageImg[]" value="" multiple />
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="border"><input type="submit" name="smb_add" value="新增"></td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="articleId" value="<?php echo (int)$_GET['articleId']; ?>">
</form>
</body>
</html>