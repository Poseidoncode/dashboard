<?php 
session_start();
require_once('./db.inc.php');
require_once('./tpl/tpl-html-head.php'); 
require_once('./tpl/header.php');
// require_once("./tpl/func-buildTree.php");
// require_once("./tpl/func-getRecursiveCategoryIds.php"); 
?>

<div class="container-fluid">
    <div class="row">


        <!-- 商品項目清單 -->
        <div class="col-md-9">
        <?php
        if(isset($_GET['productId'])) {
            //SQL 敘述
            $sql = "SELECT `product`.`productId`, `product`.`productName`, `product`.`productImg`, `product`.`productPrice`, 
            `product`.`productAmount`, `product`.`categoryId`, `product`.`mapId`, `product`.`productAddress`, `product`.`productEndingDate`, `product`.`companyId`, `product`.`created_at`, `product`.`updated_at`,
            `category`.`categoryName`
             FROM `product` INNER JOIN `category` 
            ON `product`.`categoryId` = `category`.`categoryId`
            WHERE `productId` = ? ";

            $arrParam = [
                (int)$_GET['productId']
            ];

            //查詢
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

            //若商品項目個數大於 0，則列出商品
            if($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="row mb-3 d-flex justify-content-center">
                        <img class="item-view border" src="./images/products/<?php echo $arr[0]["productImg"]; ?>">
                    </div>
                    <div class="row">
                        <img class="item-preview img-thumbnail border" src="./images/products/<?php echo $arr[0]["productImg"]; ?>" alt="...">
           
                    </div>
                </div>
                <div class="col-md-7">
                    <h3>商品名稱: <?php echo $arr[0]["productName"]; ?></h3>
                    <p>商品價格: <?php echo $arr[0]["productPrice"]; ?></p>
                    <p>商品數量: <?php echo $arr[0]["productAmount"]; ?></p>
                    <form name="cartForm" id="cartForm" method="POST" action="./addCart.php">
                        <label>數量: </label>
                        <input type="text" name="cartQty" id="cartQty" value="1" maxlength="5">
                        <button type="button" class="btn btn-primary btn-lg" id="btn_addCart" data-item-id="<?php echo $_GET['productId'] ?>">加入購物車</button>
                        <button type="button" class="btn btn-info btn-lg" id="btn_addItemTracking" data-item-id="<?php echo $_GET['productId'] ?>">追蹤此商品</button>
                        <input type="hidden" name="productId" id="productId" value="<?php echo $_GET['productId'] ?>">
                    </form>
                </div>
                
            </div>
            <div class="row mt-4 mb-4">
                <div class="col-md-12">商品描述</div>
            </div>
            <div class="row"><?php require_once("./tpl/tpl-comments-list.php"); ?></div>
            <div class="row"><?php require_once("./tpl/tpl-comments.php"); ?></div>
        </div>

        <?php
            }
        }
        ?>
        </div>
    </div>
</div>
<?php
require_once('./tpl/footer.php');
require_once('./tpl/tpl-html-foot.php'); 
?>