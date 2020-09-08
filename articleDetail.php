<?php 
session_start();
require_once('./db.inc.php');
require_once("./tpl/func-article-buildTree.php");
require_once("./tpl/func-article-getRecursiveCategoryIds.php");
?>

<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="DarrenYang">
    <title>文章</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="css/carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<?php 
require_once('./tpl/tpl-html-head.php'); 
require_once('./tpl/header.php');
?>
<body class="d-flex flex-column h-100">
    <div class="container-fluid">
        <div class="row">
            <!-- 樹狀文章類別連結 -->
            <div class="col-md-2"><?php buildTree($pdo, 0); ?></div>

            <!-- 文章項目清單 -->
            <div class="col-md-10">
            <?php
            if(isset($_GET['articleId'])) {
                //SQL 敘述
                $sql = "SELECT `article`.`articleId`, `article`.`articleTitle`, `article`.`img`, `article`.`categoryId`,`article`.`articleContent`, `article`.`created_at`, `article`.`updated_at`,
                            `article_categories`.`categoryId`, `article_categories`.`categoryName`
                        FROM `article` INNER JOIN `article_categories`
                        ON `article`.`categoryId` = `article_categories`.`categoryId`
                        WHERE `articleId` = ? ";

                $arrParam = [
                    (int)$_GET['articleId']
                ];

                //查詢
                $stmt = $pdo->prepare($sql);
                $stmt->execute($arrParam);

                //若文章項目個數大於 0，則列出文章
                if($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5">
                        <div class="row mb-3 d-flex justify-content-center">
                            <img class="item-view border" src="./images/article_column/img/<?php echo $arr[0]["img"]; ?>">
                        </div>
                        <div class="row">
                            <img class="item-preview img-thumbnail border" src="./images/article_column/img/<?php echo $arr[0]["img"]; ?>" alt="...">
                        <?php 
                        //找出預覽圖片
                        $sqlMultipleImages = "SELECT `multipleImageId`, `multipleImageImg`
                                                FROM `article_multiple_images` 
                                                WHERE `articleId` = ?";
                        $stmtMultipleImages = $pdo->prepare($sqlMultipleImages);
                        $stmtMultipleImages->execute($arrParam);
                        if($stmtMultipleImages->rowCount() > 0) {
                            $arrMultipleImages = $stmtMultipleImages->fetchAll(PDO::FETCH_ASSOC);
                            for($i = 0; $i < count($arrMultipleImages); $i++){
                        ?>
                                <img class="item-preview img-thumbnail border" src="./images/article_column/multiple_images/<?php echo $arrMultipleImages[$i]['multipleImageImg']; ?>" alt="...">
                        <?php
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h2><?php echo $arr[0]["articleTitle"]; ?></h2>
                        <p><?php echo $arr[0]["articleContent"]; ?></p>
                    </div>
                </div>
            </div>
            <?php
                }
            }
            ?>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/rater.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
<?php
require_once('./tpl/footer.php');
require_once('./tpl/tpl-html-foot.php'); 
?>