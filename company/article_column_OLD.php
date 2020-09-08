<?php
require_once('../db.inc.php');
?>

<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="DarrenYang">
    <title>文章專欄</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="css/carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body class="d-flex flex-column h-100">

<div class="album py-5 bg-light flex-shrink-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 d-flex justify-content-center">
                <h1>文章專欄</h1>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
        <?php
        //SQL 敘述
        $sql = "SELECT `article`.`articleId`, `article`.`articleName`, `article`.`img`,  
                        `article`.`categoryId`, `article`.`created_at`, `article`.`updated_at`,
                        `article_categories`.`categoryName`
                FROM `article` INNER JOIN `article_categories`
                ON `article`.`categoryId` = `article_categories`.`categoryId`
                ORDER BY `article`.`articleId` ASC ";
        // $sql.= "LIMIT ?, ? ";
        //設定繫結值
        // $arrParam = [($page - 1) * $numPerPage, $numPerPage];

        //查詢分頁後的商品資料
        $stmt = $pdo->prepare($sql);
        $stmt->execute(); //$arrParam

        //若數量大於 0，則列出商品
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arr); $i++) {
        ?>
            <div class="col-md-3 col-sm-6">
                <div class="card mb-3 shadow-sm">
                    <a href="articleDetail.php?articleId=<?php echo $arr[$i]['articleId']; ?>">
                        <img class="list-item" src="../images/article_column/img/<?php echo $arr[$i]['img']; ?>">
                    </a>
                    <div class="card-body">
                        <p class="card-text list-item-card"><?php echo $arr[$i]['articleName']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <!-- <button type="button" class="btn btn-sm btn-outline-secondary">詳細</button> -->
                                <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button> -->
                            </div>
                            <small class="text-muted">上架日期：<?php echo $arr[$i]['created_at']; ?></small>
                        </div>
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