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
    <title>文章資料</title>
    <style>
    .companyborder {
        /* border: 1px solid #aaa; */
        padding:10px 0;
    }
    .w200px {
        width: 200px;
    }
    .input{
        width:350px;
    }
    .img{
        width:200px;
    }

    </style>

</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<?php require_once('./templates/title_article_column.php'); ?>

<form name="myForm" method="POST" action="" enctype="multipart/form-data">
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
                    <td class="companyborder">文章編號：</td>
                    <td class="companyborder">
                        <?= $arr['articleId'] ?>
                    </td>
                </tr>           
                <tr>
                    <td class="companyborder">作者：</td>
                    <td class="companyborder">
                        <?= $arr['author'] ?>
                    </td>
                </tr>           
                <tr>
                    <td class="companyborder">文章標題：</td>
                    <td class="companyborder">
                        <?= $arr['articleTitle'] ?>
                    </td>
                </tr>           
                <tr>
                    <td class="companyborder">文章內容：</td>
                    <td class="companyborder">
                        <?= $arr['articleContent'] ?>
                    </td>
                </tr>                     
                <tr>
                    <td class="companyborder">建立時間：</td>
                    <td class="companyborder">
                        <?=  $arr['created_at']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="companyborder">更新時間：</td>
                    <td class="companyborder">
                        <?=  $arr['updated_at']; ?>
                    </td>
                </tr>  
                <!-- <tr>
                    <td class="companyborder">文章狀態：</td>
                    <td class="companyborder">
                        <select name="articleStatus">
                            <option value="<?= $arr['articleStatus'] ?>" selected>
                                <?php if($arr['articleStatus'] === "true"){ echo "啟用"; }else{echo "停用";}  ?>
                            </option>
                            <option value="true">啟用</option>
                            <option value="false">停用</option>
                        </select>
                    </td>
                </tr>             -->
                <tr>
                    <td class="companyborder">文章附圖：</td>
                    <td class="companyborder" colspan="2">
                    <?php  
                    if($arr['img'] !== NULL){?>
                        <img class="img" src="../images/article_column/img/<?php echo $arr['img'] ?>" />
                    <?php
                     }
                     ?>
                    </td>
                </tr>
                <tr>
                    <td class="companyborder">功能</td>
                    <td class="companyborder">
                        <!-- <input type="submit" name="smb" value="更新"> -->
                        <input type="button" value="刪除" onclick="if(confirm('是否確認刪除這筆資料？')) location.href='./article_delete.php?deleteId=<?= $arr['articleId'] ?>'">
                    </td>
                </tr>
        <?php 
            }else{
        ?>
            <tr>
                <td class="companyborder" colspan="6">沒有資料</td>
            </tr>
        <?php
            }
        ?>
    </table>
    <input type="hidden" name="articleId" value="<?= (int)$arr['articleId']; ?>">
</form>

</body>
</html>