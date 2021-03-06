<?php 
session_start();
require_once('./db.inc.php'); 
require_once('./tpl/tpl-html-head.php');
require_once('./tpl/header.php');
require_once("./tpl/func-buildTree.php");
require_once("./tpl/func-getRecursiveCategoryIds.php"); 
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
            $sql = "SELECT `product`.`productId`, `product`.`productName`, `product`.`productImg`, `product`.`productPrice`, 
                            `product`.`productAmount`, `product`.`categoryId`, `product`.`created_at`, `product`.`updated_at`,
                            `category`.`categoryName`
                    FROM `product` INNER JOIN `category`
                    ON `product`.`categoryId` = `category`.`categoryId`";

            //若網址有商品種類編號，則整合字串來操作 SQL 語法
            if(isset($_GET['categoryId'])){ $sql .= "WHERE `product`.`categoryId` in ({$strCategoryIds})"; }

            $sql .="ORDER BY `product`.`productId` ASC ";

            //查詢分頁後的商品資料
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            //若商品項目個數大於 0，則列出商品
            if($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for($i = 0; $i < count($arr); $i++) {
            ?>
                <div class="col-md-4 col-sm-6 filter-items" data-price="<?php echo $arr[$i]['productPrice']; ?>">
                    <div class="card mb-3 shadow-sm">
                        <a href="./itemDetail.php?productId=<?php echo $arr[$i]['productId']; ?>">
                            <img class="list-item" src="./images/products/<?php echo $arr[$i]['productImg']; ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text list-item-card"><?php echo $arr[$i]['productName']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">價格：<?php echo $arr[$i]['productPrice']; ?></small>
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

        <!-- 商品過濾 -->
        <div class="col-md-2 col-sm-3"><?php require_once("./tpl/tpl-filter.php"); ?></div>
    </div>
</div>

<?php require_once('./tpl/footer.php'); ?>
<?php require_once('./tpl/tpl-html-foot.php'); ?>