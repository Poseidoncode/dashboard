<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>多圖設定</title>
    <style>
        /* button mainColor*/
        .btn-mainColor {
        color: #fff !important;
        background-color: #8f8681 !important;
        border-color: #8f8681 !important;
        }
        .btn-mainColor:hover {
        color: #fff !important;
        background-color: #A47F6A !important;
        border-color: #A47F6A !important;
        }        
        .thead-mainColor {
            background-color: #B2A59F !important;
            border-color: #B2A59F !important;
            width: 300px;
        }
        
        td {
            padding: 10px 0;
        }
        </style>
</head>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>
<body>
    <!-- <h3>多圖編輯</h3> -->
    <form name="myForm" method="POST" action="./articleDeleteMultipleImages.php">
        <table class="border">
            <thead>
                <tr class="">
                    <th colspan="2" class="border thead-mainColor">多圖編輯</th>
                </tr>
                <tr>
                    <th class="border">勾選</th>
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
                        <img class="previous_images" src="../images/article_column/multiple_images/<?php echo $arr[$i]['multipleImageImg'] ?>">
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
        <input type="submit" class="btn btn-mainColor btn-sm" name="smb_delete" value="刪除多圖" onclick="return confirm('確定要刪除勾選的資料？')">
        <input type="hidden" name="articleId" value="<?php echo (int)$_GET['articleId']; ?>">
    </form>
    <hr />
    <form name="myForm" method="POST" action="./articleInsertMultipleImages.php" enctype="multipart/form-data">
        <table class="border">
            <thead>
                <tr>
                <th class="border thead-mainColor">多圖上傳</th>
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
                    <td class="border"><input type="submit" class="btn btn-mainColor btn-sm" name="smb_add" value="新增多圖"></td>
                </tr>
            </tfoot>
        </table>
        <input type="hidden" name="articleId" value="<?php echo (int)$_GET['articleId']; ?>">
    </form>
</body>
</html>