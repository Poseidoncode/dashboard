<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新增文章類別</title>
    <style>
        li a{
            margin: 3px;
        }
    </style>
</head>
<body>

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
        echo "<ul>";
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            echo "<li>";
            echo "<input type='radio' name='categoryId' value='".$arr[$i]['categoryId']."' />";
            echo $arr[$i]['categoryName'];
            echo "<a class='btn btn-outline-secondary btn-sm' role='button' href='./articleEditCategory.php?editCategoryId=".$arr[$i]['categoryId']."'>編輯</a>";
            echo "<a class='btn btn-outline-secondary btn-sm' role='button' href='./articleDeleteCategory.php?deleteCategoryId=".$arr[$i]['categoryId']."'>刪除</a>";
            buildTree($pdo, $arr[$i]['categoryId']);
            echo "</li>";
        }
        echo "</ul>";
    }
}
?>
<?php require_once('../admin/templates/title.php'); ?>
<?php require_once('../admin/templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>
<table class="border">
    <thead>
        <tr>
            <th class="border">新增文章類別名稱</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="border">
                <input type="text" name="categoryName" value="" maxlength="100" />
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="border"><input type="submit" name="smb" value="新增"></td>
        </tr>
    </tfoot>
</table>
<h4>編輯文章類別</h4>
<form name="myForm" method="POST" action="./articleInsertCategory.php">

<?php buildTree($pdo, 0); ?>



</form>
</body>
</html>