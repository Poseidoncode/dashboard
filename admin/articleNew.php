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
    <title>新增文章</title>
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
        input[type="submit"] {
            margin: 50px 50%;
        }
    </style>
</head>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>
<body>
<form name="myForm" method="POST" action="./articleInsert.php" enctype="multipart/form-data">
<table class="border">
    <tr>
        <th class="border">文章類別</th>
        <td class="border">
            <select name="categoryId">
            <?php buildTree($pdo, 0); ?>
            </select>
        </td> 
    </tr>
    <tr>
        <th class="border">文章標題</th>
        <td class="border">
            <input type="text" name="articleTitle" id="articleTitle" value="" maxlength="20"
            placeholder="請輸入文章標題⋯"/>
        </td>
    </tr>
    <tr>
        <th class="border">文章內容</th>
        <td class="border">
            <textarea name="articleContent"></textarea>
        </td>
    </tr>
    <tr>
        <th class="border">上傳圖片</th>                     
        <td class="border">
            <input type="file" name="img" />
        </td>
    </tr>
    <tr>
        <td class="border" colspan="7">
            <input type="submit" class="btn btn-mainColor btn-sm" name="smb" value="發佈文章">
        </td>
    </tr>  
</table>
</form>

</body>
</html>