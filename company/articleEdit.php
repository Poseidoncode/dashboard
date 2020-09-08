<?php 
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//建立種類列表
function buildTree($pdo, $parentId = 0){
    $sql = "SELECT `categoryId`, `categoryName`, `categoryParentId`
            FROM `article_categories`
            WHERE `categoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            echo "<option value='".$arr[$i]['categoryId']."'>";
            echo $arr[$i]['categoryName'];
            echo "</option>";
            buildTree($pdo, $arr[$i]['categoryId']); 
        }
    }
}
?>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>
<hr />
<form name="myForm" method="POST" action="articleUpdateEdit.php" enctype="multipart/form-data">
    <table class="border">
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `article`.`articleId`, `article`.`author`, `article`.`articleTitle`, `article`.`categoryId`, `article`.`articleContent`, `article`.`img`, `article_categories`.`categoryName`
                FROM `article` ,`article_categories` 
                WHERE `articleId` = ?";

        //設定繫結值
        $arrParam = [(int)$_GET['editId']];

        //查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($arr) > 0) {
        ?>
            <tr>
                <td class="border">作者</td>
                <td class="border">
                    <?php echo $arr[0]['author']; ?>
                </td>
            </tr>
            <tr>
                <td class="border">文章標題</td>
                <td class="border">
                    <input type="text" name="articleTitle" value="<?php echo $arr[0]['articleTitle']; ?>" maxlength="20" />
                </td>
            </tr>
            <tr>
                <td class="border">文章類別</td>
                <td class="border">
                    <select name="categoryId">
                    <option value="<?php echo $arr[0]['categoryId']; ?>"><?php echo $arr[0]['categoryName']; ?></option>
                    <?php buildTree($pdo, 0); ?>
                    </select>
                </td>
            </tr>            
            <tr>
                <td class="border">文章內容</td>
                <td class="border">
                    <textarea name="articleContent" cols="50" rows="10"><?php echo $arr[0]['articleContent']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="border">上傳圖片</td>
                <td class="border">
                <?php if($arr[0]['img'] !== NULL) { ?>
                    <img class="w200px" src="../images/article_column/img/<?php echo $arr[0]['img']; ?>" />
                <?php } ?>
                <input type="file" name="img" />
                </td>
            </tr>
            <tr>
                <td class="border">功能</td>
                <td class="border">
                    <a href="./articleDelete.php?deleteId=<?php echo $arr[0]['articleId']; ?>">刪除</a>
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