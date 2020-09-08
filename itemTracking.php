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
        <div class="col-md-12">
            <div class="container-fluid">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="p-2 text-uppercase">新增日期</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="p-2 text-uppercase">商品名稱</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">商品圖片</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">單價</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">狀態</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">功能</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="wishtbd">
        <?php
        //SQL 敘述
        if(isset($_SESSION['Id'])){
            $sql = "SELECT `product`.`productId`, `product`.`productName`, `product`.`productImg`, `product`.`productPrice`, 
                    `product`.`productAmount`, `product`.`categoryId`, `product`.`created_at`, `product`.`updated_at`,
                    `category`.`categoryId`, `category`.`categoryName`,`wishlist`.`wishId` AS `itemTrackingId`
                    ,`wishlist`.`memberId`, `wishlist`.`created_at`, `wishlist`.`updated_at`
                FROM `product` INNER JOIN `category`
                ON `product`.`categoryId` = `category`.`categoryId`
                INNER JOIN `wishlist`
                ON `product`.`productId` = `wishlist`.`productId`
                WHERE `memberId` = ? ";

        $arrParam = [
            $_SESSION['Id']
        ];

        //查詢 SQL
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        //若商品項目個數大於 0，則列出商品
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arr); $i++){ 
        ?>
            <tr>
                <td class="border-0 align-middle"><?= $arr[$i]['created_at'] ?></td>
                <td class="border-0 align-middle"><?= $arr[$i]['productName'] ?></td>
                <td class="border-0 align-middle">
                    <img src="./images/items/<?= $arr[$i]["productImg"] ?>" alt="" class="item-tracking-preview img-fluid rounded shadow-sm">
                </td>
                <td class="border-0 align-middle"><?= $arr[$i]['productPrice'] ?></td>
                <td class="border-0 align-middle">
                <?php if($arr[$i]['productAmount'] > 0){ ?>
                    <button type="button" class="btn btn-primary" id="btn_addCartForItemTracking" data-item-id="<?php echo$arr[$i]['productId'] ?>">加入購物車</button>
                <?php } else { echo "已賣完"; } ?>
                </td>
                <td class="border-0 align-middle">
                <a href="./deleteItemTracking.php?deleteItemTrackingId=<?= $arr[$i]['itemTrackingId'] ?>">刪除</a>
                </td>
            </tr>             
        <?php
            }
        }
        

        }
        ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once('./tpl/footer.php');
require_once('./tpl/tpl-html-foot.php'); 
?>