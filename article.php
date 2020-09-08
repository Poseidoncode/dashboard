<?php 
session_start();
require_once('./db.inc.php'); 
require_once('./tpl/tpl-html-head.php');
require_once('./tpl/header.php');
require_once("./tpl/func-article-buildTree.php");
require_once("./tpl/func-article-getRecursiveCategoryIds.php"); 
?>

<div class="container-fluid">
    <div class="row">
        <!-- 樹狀商品種類連結 -->
        <div class="col-md-2 col-sm-3"><?php buildTree($pdo, 0); ?></div> 

        <!-- 商品項目清單 -->
        <div class="col-md-8 col-sm-6">
            <div class="row">
            <?php
            if(isset($_GET['categoryId'])){
                $strCategoryIds = "";;
                $strCategoryIds.= $_GET['categoryId'];
                getRecursiveCategoryIds($pdo, $_GET['categoryId']);
            }

            //SQL 敘述
            $sql = "SELECT `article`.`articleId`, `article`.`author`, `article`.`articleTitle`, `article_categories`.`categoryName`, `article`.`articleContent`, `article`.`img`, `article`.`articleStatus`, `article`.`created_at`, `article`.`updated_at`
            FROM `article` LEFT JOIN `article_categories`
            ON `article`.`categoryId` = `article_categories`.`categoryId`";

            //若網址有商品種類編號，則整合字串來操作 SQL 語法
            if(isset($_GET['categoryId'])){ $sql .= "WHERE `article`.`categoryId` in ({$strCategoryIds})"; }

            $sql .="ORDER BY `article`.`articleId` ASC ";

            //查詢分頁後的商品資料
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            //若商品項目個數大於 0，則列出商品
            if($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for($i = 0; $i < count($arr); $i++) {
            ?>
                <div class="col-md-4 col-sm-6 filter-items" data-price="<?php 
                // echo $arr[$i]['articlePrice']; 
                ?>">
                    <div class="card mb-3 shadow-sm">
                        <a href="./articleDetail.php?articleId=<?php echo $arr[$i]['articleId']; ?>">
                            <img class="list-item" src="images/article_column/img/<?php echo $arr[$i]['img']; ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text list-item-card"><?php echo $arr[$i]['articleTitle']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">發文日期：<?php echo $arr[$i]['created_at']; ?></small>
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

        <!-- 商品過濾 -->
        <!-- <div class="col-md-2 col-sm-3"><?php require_once("./tpl/tpl-filter.php"); ?></div> -->
    </div>

