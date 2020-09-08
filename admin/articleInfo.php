<?php
//引入判斷是否登入機制
require_once('./checkAdmin.php');

//引用資料庫連線
require_once('../db.inc.php');
?>

<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文章詳細資料</title>
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
        form[name="myForm"] {
            width: 50%;
        }
        .article_border {
            padding:10px;
        }
        .img{
            width:200px;
        }
        tr td:first-child {
            width: 100px;
            text-align: center;
        }
        </style>
</head>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>
<body>
    <form name="myForm" method="POST" action="#" enctype="multipart/form-data">
        <table>
            <?php
                $sql = "SELECT `articleId`, `author`, `articleTitle`, `articleContent`, `img`, `articleStatus` ,`created_at`,`updated_at`
                FROM `article` 
                WHERE `articleId`= ? ";
                
                $arrParam = [$_GET['infoId']];

                $stmt = $pdo->prepare($sql);
                $stmt->execute($arrParam);
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

                if(count($arr)>0){                       
            ?>
                    <tr>
                        <td class="article_border">文章編號：</td>
                        <td class="article_border">
                            <?= $arr['articleId'] ?>
                        </td>
                    </tr>           
                    <tr>
                        <td class="article_border">作者：</td>
                        <td class="article_border">
                            <?= $arr['author'] ?>
                        </td>
                    </tr>           
                    <tr>
                        <td class="article_border">文章標題：</td>
                        <td class="article_border">
                            <?= $arr['articleTitle'] ?>
                        </td>
                    </tr>           
                    <tr>
                        <td class="article_border">文章內容：</td>
                        <td class="article_border articleContent">
                            <?= $arr['articleContent'] ?>
                        </td>
                    </tr>                     
                    <tr>
                        <td class="article_border">建立時間：</td>
                        <td class="article_border">
                            <?=  $arr['created_at']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="article_border">更新時間：</td>
                        <td class="article_border">
                            <?=  $arr['updated_at']; ?>
                        </td>
                    </tr>  
                    <tr>
                        <td class="article_border">文章附圖：</td>
                        <td class="article_border" colspan="2">
                        <?php  
                        if($arr['img'] !== NULL){?>
                            <img class="img" src="../images/article_column/img/<?php echo $arr['img'] ?>" />
                        <?php
                        }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="article_border">功能：</td>
                        <td class="article_border">
                            <!-- <a class="btn btn-mainColor btn-sm" role="button" href="./articleEdit.php?editId=<?= $arr[$i]['articleId'] ?>">文章編輯</a> -->
                            <input type="button" class='btn btn-mainColor btn-sm' value="編輯" onclick="location.href='./articleEdit.php?editId=<?= $arr['articleId'] ?>'">
                            <input type="button" class='btn btn-mainColor btn-sm' value="刪除" onclick="if(confirm('是否確認刪除這筆資料？')) location.href='./articleDelete.php?deleteId=<?= $arr['articleId'] ?>'">
                        </td>
                    </tr>
            <?php 
                }else{
            ?>
                    <tr>
                        <td class="article_border" colspan="6">沒有資料</td>
                    </tr>
            <?php
                }
            ?>
        </table>
        <input type="hidden" name="articleId" value="<?= (int)$arr['articleId']; ?>">
    </form>

</body>
</html>