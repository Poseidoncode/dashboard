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

<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>修改文章</title>
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
        table {
            margin-left: 15%;
            width: 60%;
        }
        table tr {
            height: 40px;
        }
        table tr th {
            text-align: center;
        }
        input[name="articleTitle"] {
            width: 100%;
        }
        textarea[name="articleContent"] {
            width: 100%;
            height: 500px;
        }
        tfoot {
            text-align: center;

        }
    </style>
</head>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>
<body>
    <form name="myForm" method="POST" action="articleUpdateEdit.php" enctype="multipart/form-data">
        <table class="border">
            <tbody>
            <?php
            //SQL 敘述
            $sql = "SELECT `article`.`articleId`, `article`.`author`, `article`.`articleTitle`, `article`.`categoryId`, `article`.`articleContent`, `article`.`img`, `article`.`articleStatus`, `article_categories`.`categoryName`
                    FROM `article` ,`article_categories`
                    WHERE `articleId` = ?
                    AND `article`.`categoryId` = `article_categories`.`categoryId`";

            //設定繫結值
            $arrParam = [(int)$_GET['editId']];

            //查詢
            $stmt = $pdo->prepare($sql);
                   $stmt->execute($arrParam);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($arr) > 0) {
            ?>
                <tr>
                    <th class="border">作者</th>
                    <td class="border">
                        <?php echo $arr[0]['author']; ?>
                    </td>
                </tr>
                <tr>
                    <th class="border">文章標題</th>
                    <td class="border">
                        <input type="text" name="articleTitle" value="<?php echo $arr[0]['articleTitle']; ?>" maxlength="20" />
                    </td>
                </tr>
                <tr>
                    <th class="border">文章類別</th>
                    <td class="border">
                        <select name="categoryId">
                        <option value="<?php echo $arr[0]['categoryId']; ?>"><?php echo $arr[0]['categoryName']; ?></option>
                        <?php buildTree($pdo, 0); ?>
                        </select>
                    </td>
                </tr>            
                <tr>
                    <th class="border">文章內容</th>
                    <td class="border">
                        <textarea name="articleContent"><?php echo $arr[0]['articleContent']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th class="border">上傳圖片</th>
                    <td class="border">
                    <?php if($arr[0]['img'] !== NULL) { ?>
                        <img class="w200px" src="../images/article_column/img/<?php echo $arr[0]['img']; ?>" />
                    <?php } ?>
                    <input type="file" name="img" />
                    </td>
                </tr>
                <tr>
                    <th class="border">文章狀態</th>
                    <td class="border">
                        <select name="articleStatus">
                            <option value="<?= $arr[0]['articleStatus'] ?>" selected>
                                <?php if($arr[0]['articleStatus'] === "true"){ echo "啟用"; }else{echo "停用";}  ?>
                            </option>
                            <option value="true">啟用</option>
                            <option value="false">停用</option>
                        </select>
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
                    <!-- <th class="border">功能</th> -->
                    <td class="border" colspan="2">
                    <input type="submit" class="btn btn-mainColor btn-sm" name="smb" value="修改文章">
                    <button class="btn btn-mainColor btn-sm" type="button" onclick="if(confirm('確定要刪除這筆資料？')) location.href='./articleDelete.php?deleteId=<?= $arr[0]['articleId'] ?>'">單筆刪除</button>  
                    </td>
                </tr>               
            </tfoot>
        </table>
        <input type="hidden" name="editId" value="<?php echo (int)$_GET['editId']; ?>">
    </form>
</body>
</html>