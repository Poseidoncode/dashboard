<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新增文章</title>
    <style>
    
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

<form name="myForm" method="POST" action="./articleInsert.php" enctype="multipart/form-data">
<table class="border">
    <tr>
        <th class="border">文章標題</th>
        <td class="border">
            <input type="text" name="articleTitle" id="articleTitle" value="" maxlength="10" />
        </td>
    </tr>
    <tr>
        <th class="border">文章類別</th>
        <td class="border">
            <select name="categoryId">
            <?php buildTree($pdo, 0); ?>
            </select>
        </td> 
    </tr>
    <tr>
        <th class="border">文章內容</th>
        <td class="border">
            <textarea name="articleContent" cols="50" rows="10"></textarea>
        </td>
    </tr>
    <tr>
        <th class="border">上傳圖片</th>                     
        <td class="border">
            <input type="file" name="img" />
        </td>
    </tr>
    <tr>
        <td class="border" colspan="7"><input type="submit" name="smb" value="新增"></td>
    </tr>  
</table>
</form>

</body>
</html>