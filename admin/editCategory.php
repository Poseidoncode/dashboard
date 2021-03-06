<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>類別名稱編輯</h3>
<form name="myForm" method="POST" action="updateCategory.php">
    <table class="border">
        <thead>
            <tr>
                <th class="border">種類名稱</th>
                <th class="border">新增時間</th>
                <th class="border">更新時間</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `category`.`categoryId`, `category`.`categoryName`, `category`.`created_at`, `category`.`updated_at`
                FROM  `category`
                WHERE `category`.`categoryId` = ? ";

        $arrParam = [
            (int)$_GET['editCategoryId']
        ];

        //查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        //資料數量大於 0，則列出相關資料
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <tr>
                <td class="border">
                    <input type="text" name="categoryName" value="<?php echo $arr[0]['categoryName']; ?>" maxlength="100" />
                </td>
                <td class="border"><?php echo $arr[0]['created_at']; ?></td>
                <td class="border"><?php echo $arr[0]['updated_at']; ?></td>
            </tr>
        <?php
        } else {
        ?>
            <tr>
                <td colspan="3">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
            <?php if($stmt->rowCount() > 0){ ?>
                <td class="border" colspan="3"><input type="submit" name="smb" value="更新"></td>
            <?php } ?>
            </tr>
        </tfoo>
    </table>
    <input type="hidden" name="editCategoryId" value="<?php echo (int)$_GET['editCategoryId']; ?>">
</form>
</body>
</html>