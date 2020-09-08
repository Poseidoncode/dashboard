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
        echo "<h4>編輯文章類別</h4>";
        echo "<ul>";
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            echo "<li>";
            echo "<input type='radio' name='categoryId' id='cId_".$arr[$i]['categoryId']."' value='".$arr[$i]['categoryId']."' />";
            echo "<label for='cId_".$arr[$i]['categoryId']."'>";
            echo $arr[$i]['categoryName'];
            echo "</label>";
            echo "<a class='btn btn-mainColor btn-sm' role='button' href='./articleEditCategory.php?editCategoryId=".$arr[$i]['categoryId']."'>編輯</a>";
            echo "<a class='btn btn-mainColor btn-sm' role='button' href='./articleDeleteCategory.php?deleteCategoryId=".$arr[$i]['categoryId']."'>刪除</a>";
            buildTree($pdo, $arr[$i]['categoryId']);
            echo "</li>";
        }
        echo "</ul>";
    }
}
?>

<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新增/編輯文章類別</title>
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
            margin-left: 0;
            width: 700px;
        }
        table tr {
            height: 50px;
        }
        h4 {
            margin: 0 0 10px 0; 
            padding-top: 50px;
            width: 700px;
            font-size: medium !important;
            font-weight: bold !important; 
        }
        ul {
            padding-left: 0;
        }
        li {
            margin-top: 20px;
        }
        li label {
            width: 12%;
            text-align: center;
        }
        li a{
            margin: 3px 5px 3px 10px;
        }
        input[name="categoryName"]{
            width: 300px;
        }
        form[method="POST"] {
            margin-left: 0;
            width: 700px;
        }
    </style>
</head>
<?php require_once('../admin/templates/title.php'); ?>
<?php require_once('../admin/templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>
<body>
    <form name="myForm" method="POST" action="./articleInsertCategory.php">
        <table class="border">
            <thead>
                <tr>
                    <th class="border">新增文章類別名稱</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border">
                        <input type="text" name="categoryName" value="" maxlength="100" placeholder="請輸入類別名稱⋯"/>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="border"><input type="submit" class="btn btn-mainColor btn-sm" name="smb" value="新增類別"></td>
                </tr>
            </tfoot>
        </table>
        <?php buildTree($pdo, 0); ?>
    </form>
</body>
</html>