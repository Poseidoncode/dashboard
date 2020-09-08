<?php
//引入判斷是否登入機制
require_once('./checkAdmin.php');

//引用資料庫連線
require_once('../db.inc.php');

if(!isset($_GET['article_search'])){$_GET['article_search']="articleTitle";};
if(!isset($_GET['articleStatus'])){$_GET['articleStatus']="true";};
if(!isset($_GET['strsearch'])){$_GET['strsearch']="";};

$s=$_GET['article_search'];

//SQL 敘述: 取得 article 資料表總筆數
$sqlTotal = "SELECT count(1) 
FROM `article` 
WHERE `{$s}` LIKE '%{$_GET['strsearch']}%'
AND `articleStatus` = '{$_GET['articleStatus']}'";

//取得總筆數
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];

//每頁幾筆
$numPerPage = 5;

// 總頁數
$totalPages = ceil($total/$numPerPage); 

//目前第幾頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;
?>

<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文章管理列表</title>
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
        /* myform2 */
        
        input[name="strsearch"] {
            width: 300px;
        }
        input[type="checkbox"]{
            width: 20px; /*Desired width*/
            height: 20px; /*Desired height*/
            cursor: pointer;
            /* -webkit-appearance: none;
            appearance: none; */
        }
        .strsearch tr td:first-child{
            width: 150px;
        }
        .select_articleStatus{
            padding-top: 6px;
            padding-right: 20px;
        }

        /* myform */
        .thead-mainColor {
            background-color: #B2A59F !important;
            border-color: #B2A59F !important;
        }
        .thead-mainColor tr th{
            height: 50px !important;
        }
        .w-3 {
            width: 3% !important;
        }
        .w-4 {
            width: 4% !important;
        }
        .w-5 {
            width: 5% !important;
        }
        .w-6 {
            width: 6% !important;
        }
        .w-10 {
            width: 10% !important;
        }
        form[name="myForm"]{
            width: 100%;
        }
        form[name="myForm"] th, form[name="myForm"] td{
            text-align: center;
            padding: 0 5px !important;
        }
        form[name="myForm"] td{
            margin: 0;
            padding: 0;
        }
        button {
            margin:2px auto !important;
        }

        /* 文章內容的td */
        .articleContent{
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow-y: auto;
            /* -webkit-line-clamp: 5; */ 
            height: 140px; 
        }
        form[name="myForm"] img{
            max-width: 100px;
            max-height: 100px;
            margin: 0;
            padding: 0;
        }
        .border_article {
            border: 1px solid #999 !important;
        }
        tfoot{
            font-size: 20px;
            line-height: 40px;
        }
        
    </style>
</head>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>
<body>
    <form name="myForm2" method="GET"  action="article.php">
        <table class="strsearch">
            <tr>
                <td><input type="checkbox" name="all" onclick="check_all(this,'chk[]')" />全選/全不選</td>
                <td class="select_articleStatus">
                <label for="articleStatus">狀態：</label>
                <select select name="articleStatus" id="">
                    <option value="true" selected>啟用</option>
                    <option value="false">停用</option>
                </select> 
                </td> 
                <td>
                    <label for="articleStatus">其他：</label>
                    <select name="article_search" id="">
                        <option value="author">作者</option>
                        <option value="articleTitle">文章標題</option>
                        <option value="categoryName">文章類別</option>
                        <option value="articleContent">文章內容</option>
                    </select>
                    <input class="input" type="text" name="strsearch" placeholder="請輸入關鍵字⋯">
                </td>
                <td><input type="submit" class="btn btn-mainColor btn-sm" value="搜尋"></td>
            </tr>
        </table>
    </form>

    <form name="myForm" method="POST" action="articleDeleteIds.php" class="table table-striped table-hover">
        <table class="table table-striped table-hover border_article">
            <thead class="thead-mainColor">
                <tr>
                    <th class="w-4">勾選</th>
                    <th class="w-5">狀態</th>
                    <th class="w-5">ID</th>
                    <th class="w-5">作者</th>
                    <th class="w-10">文章標題</th>
                    <th class="w-6">文章類別</th>
                    <th class="">文章內容</th>
                    <th class="w-6">上傳圖片</th>
                    <th class="w-10">發表時間</th>
                    <th class="w-10">更新時間</th>
                    <th class="w-6">功能</th>
                </tr>
            </thead>
            <tbody>
            <?php
            //SQL 敘述

            $sql = "SELECT `article`.`articleId`, `article`.`author`, `article`.`articleTitle`, `article_categories`.`categoryName`, `article`.`articleContent`, `article`.`img`, `article`.`articleStatus`, `article`.`created_at`, `article`.`updated_at`
            FROM `article`, `article_categories`
            WHERE `article`.`categoryId` = `article_categories`.`categoryId`
            AND`{$s}` LIKE '%{$_GET['strsearch']}%'
            AND `articleStatus` = '{$_GET['articleStatus']}'
            ORDER BY `article`.`articleId` ASC 
                LIMIT ?, ? ";

            //設定繫結值
            $arrParam = [($page - 1) * $numPerPage, $numPerPage];

            //查詢分頁後的文章資料
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

            //資料數量大於 0，則列出所有資料
            if($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for($i = 0; $i < count($arr); $i++) {
            ?>
                <tr>
                    <td class="border_article">
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['articleId']; ?>" />
                    </td>
                    <td class="border_article">
                    <?php
                        if($arr[$i]['articleStatus'] === "true"){ echo "啟用"; }else{echo "停用";}?>
                    </td>
                    <td class="border_article"><?php echo $arr[$i]['articleId']; ?></td>
                    <td class="border_article"><?php echo $arr[$i]['author']; ?></td>
                    <td class="border_article"><?php echo $arr[$i]['articleTitle']; ?></td>
                    <td class="border_article"><?php echo $arr[$i]['categoryName']; ?></td>
                    <td class="border_article articleContent"><?php echo nl2br($arr[$i]['articleContent']); ?></td>
                    <td class="border_article">
                    <?php if($arr[$i]['img'] !== NULL) { ?>
                        <img src="../images/article_column/img/<?php echo $arr[$i]['img']; ?>">
                    <?php } ?>
                    </td>                
                    <td class="border_article"><?php echo $arr[$i]['created_at']; ?></td>
                    <td class="border_article"><?php echo $arr[$i]['updated_at']; ?></td>
                    <td class="border_article">
                        <button class="btn btn-mainColor btn-sm" type="button" onclick="location.href='./articleInfo.php?infoId=<?= $arr[$i]['articleId'] ?>'">詳細資料</button>
                        <button class="btn btn-mainColor btn-sm" type="button" onclick="location.href='./articleEdit.php?editId=<?= $arr[$i]['articleId'] ?>'">文章編輯</button>
                        <button class="btn btn-mainColor btn-sm" type="button" onclick="location.href='./articleMultipleImages.php?articleId=<?= $arr[$i]['articleId'] ?>'">多圖設定</button>
                        <button class="btn btn-mainColor btn-sm" type="button" onclick="if(confirm('確定要刪除這筆資料？'))location.href='./articleDelete.php?deleteId=<?= $arr[$i]['articleId'] ?>'">單筆刪除</button>                 
                    </td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td class="border_article" colspan="10">沒有資料</td>
                </tr>
            <?php
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <span>已選擇項目:</span>
                        <input type="submit" class="btn btn-mainColor btn-sm" name="smb" value="多筆刪除" onclick="return confirm('確定要刪除勾選的資料？')">
                    </td>
                    <td colspan="6">
                    <?php
                    if($page > 1){
                        echo '<a class="btn btn-mainColor btn-sm" href="article.php?page='.($page-1).'&articleStatus='.$_GET['articleStatus'].'&article_search='.$_GET['article_search'].'&strsearch='.$_GET['strsearch'].'">上一頁</a>';
                    }
                    for( $i = 1 ; $i <= $totalPages ; $i++){?>
                        <button type="button" class="btn btn-mainColor btn-sm" onclick="location.href='?page=<?= $i ?>'"><?= $i ?></button>
                    <?php } 
                        if($page < $totalPages){
                            echo '<a class="btn btn-mainColor btn-sm" href="article.php?page='.($page+1).'&articleStatus='.$_GET['articleStatus'].'&article_search='.$_GET['article_search'].'&strsearch='.$_GET['strsearch'].'">下一頁</a>';
                        }
                    ?>
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>        
    </form>
<script>
    // 全選&全不選函式
    function check_all(obj,cName){
        var checkboxs = document.getElementsByName(cName);
        for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
    }

    // //type="submit" 的確認函式
    // function clicked() {
    //    if (confirm('確定要刪除勾選的資料？')) {
    //        yourformelement.submit();
    //    } else {
    //        return false;
    //    }
    // }
</script>
</body>
</html>