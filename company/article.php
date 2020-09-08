<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文章管理列表</title>
    <style>
        .border_article {
            border: 1px solid #999;
        }
        form .input{
            width:300px;
        }
        form[name="myForm"]{
            width: 100%;
        }
        form[name="myForm"] th, form[name="myForm"] td{
            text-align: center;
        }
        .table-width-adjust{
            max-width: 400px;
            min-width: 100px;
            word-wrap: break-word;
        }
        .w50{
            width: 50px;
        }
        input[type="checkbox"]{
            width: 20px; /*Desired width*/
            height: 20px; /*Desired height*/
            cursor: pointer;
            /* -webkit-appearance: none;
            appearance: none; */
        }
    </style>
</head>
<body>

<?php
//引入判斷是否登入機制
require_once('./checkAdmin.php');

//引用資料庫連線
require_once('../db.inc.php');

//SQL 敘述: 取得 students 資料表總筆數
$sqlTotal = "SELECT count(1) FROM `article`";

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
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>

<form name="myForm2" method="POST"  action="article_search.php">
    <table class="strsearch">
        <tr>
            <td>
                <select name="article_search" id="">
                    <option value="author">作者</option>
                    <option value="articleTitle">文章標題</option>
                    <option value="categoryName">文章類別</option>
                    <option value="articleContent">文章內容</option>
                </select>
                <input class="input" type="text" name="strsearch">
            </td>
            <td><input type="submit" value="搜尋"></td>
        </tr>
    </table>
</form>

<form name="myForm" method="POST" action="articleDeleteIds.php">
    <table class="border_article">
        <thead>
            <tr>
                <th class="border_article w50">選擇</th>
                <th class="border_article table-width-adjust">文章編號</th>
                <th class="border_article table-width-adjust">作者</th>
                <th class="border_article table-width-adjust">文章標題</th>
                <th class="border_article table-width-adjust">文章類別</th>
                <th class="border_article">文章內容</th>
                <th class="border_article">上傳圖片</th>
                <th class="border_article table-width-adjust">發表時間</th>
                <th class="border_article table-width-adjust">更新時間</th>
                <th class="border_article table-width-adjust">功能</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `article`.`articleId`, `article`.`author`, `article`.`articleTitle`, `article_categories`.`categoryName`, `article`.`articleContent`, `article`.`img`, `article`.`articleStatus`, `article`.`created_at`, `article`.`updated_at`
        FROM `article` LEFT JOIN `article_categories`
        ON `article`.`categoryId` = `article_categories`.`categoryId`
        ORDER BY `article`.`articleId` ASC 
                LIMIT ?, ? ";

        //設定繫結值
        $arrParam = [($page - 1) * $numPerPage, $numPerPage];

        //查詢分頁後的學生資料
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
                <td class="border_article"><?php echo $arr[$i]['articleId']; ?></td>
                <td class="border_article"><?php echo $arr[$i]['author']; ?></td>
                <td class="border_article"><?php echo $arr[$i]['articleTitle']; ?></td>
                <td class="border_article"><?php echo $arr[$i]['categoryName']; ?></td>
                <td class="border_article"><?php echo nl2br($arr[$i]['articleContent']); ?></td>
                <td class="border_article">
                <?php if($arr[$i]['img'] !== NULL) { ?>
                    <img class="w200px" src="../images/article_column/img/<?php echo $arr[$i]['img']; ?>">
                <?php } ?>
                </td>                
                <td class="border_article"><?php echo $arr[$i]['created_at']; ?></td>
                <td class="border_article"><?php echo $arr[$i]['updated_at']; ?></td>
                <td class="border_article">
                    <a class="btn btn-outline-secondary btn-sm" role="button" href="./article_info.php?infoId=<?= $arr[$i]['articleId'] ?>">詳細資料</a>
                    <a class="btn btn-outline-secondary btn-sm" role="button" href="./articleEdit.php?editId=<?= $arr[$i]['articleId'] ?>">文章編輯</a>
                    <a class="btn btn-outline-secondary btn-sm" role="button" href="./articleMultipleImages.php?articleId=<?= $arr[$i]['articleId'] ?>">多圖設定</a>
                    <a class="btn btn-outline-danger btn-sm" role="button" onclick="if(confirm('是否確認刪除這筆資料？'))location.href='./articleDelete.php?deleteId=<?= $arr[$i]['articleId'] ?>'">單筆刪除</a>
                                       
                </td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td class="border_article" colspan="9">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td><input type="checkbox" name="all" onclick="check_all(this,'chk[]')" />全選/全不選</td>
                <td class="border_article" colspan="9">
                <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php } ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <span>已選擇項目:</span>
    <input type="submit" name="smb" value="批次刪除">
</form>
<script>
    function check_all(obj,cName){
        var checkboxs = document.getElementsByName(cName);
        for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
    }
</script>
</body>
</html>