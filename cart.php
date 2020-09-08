<?php
session_start();
require_once('./db.inc.php');
require_once('./tpl/tpl-html-head.php'); 
require_once('./tpl/header.php');
// require_once("./tpl/func-buildTree.php");
// require_once("./tpl/func-getRecursiveCategoryIds.php");
?>
<form name="myForm" method="POST" action="./addOrder.php">

<div class="container-fluid">
    <div class="row">


        <!-- 商品項目清單 -->
        <div class="col-md-10 col-sm-9">
            <div class="row pl-3 pr-3">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="p-2 px-3 text-uppercase">商品名稱</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">價格</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">數量</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">小計</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">功能</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        //放置結合當前資料庫資料的購物車資訊
                        $arr = [];

                        $total = 0;

                        if( isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0 ){
                            //重新排序索引
                            $_SESSION["cart"] = array_values($_SESSION["cart"]);

                            //SQL 敘述
                            $sql = "SELECT `product`.`productId`, `product`.`productName`, `product`.`productImg`, `product`.`productPrice`, 
                                            `product`.`productAmount`, `product`.`categoryId`, `product`.`created_at`, `product`.`updated_at`,
                                            `category`.`categoryId`, `category`.`categoryName`
                                    FROM `product` INNER JOIN `category`
                                    ON `product`.`categoryId` = `category`.`categoryId`
                                    WHERE `productId` = ? ";

                            for($i = 0; $i < count($_SESSION["cart"]); $i++){
                                $arrParam = [
                                    (int)$_SESSION["cart"][$i]["productId"]
                                ];
                                
                                //查詢
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute($arrParam);
                                
                                //若商品項目個數大於 0，則列出商品
                                if($stmt->rowCount() > 0) {
                                    $arrTmp = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                                    $arrTmp['cartQty'] = $_SESSION["cart"][$i]["cartQty"];
                                    $arr[] = $arrTmp;
                                } 
                            } 

                            for($i = 0; $i < count($arr); $i++) { 
                                //計算總額
                                $total += $arr[$i]["productPrice"] * $arr[$i]["cartQty"];
                        ?>
                            <tr>
                                <th scope="row" class="border-0">
                                    <div class="p-2">
                                        <img src="./images/items/<?php echo $arr[$i]["productImg"] ?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                                        <div class="ml-3 d-inline-block align-middle">
                                            <h5 class="mb-0"><a href="#"class="text-dark d-inline-block align-middle"><?php echo $arr[$i]["productName"] ?></a></h5>
                                            <span class="text-muted font-weight-normal font-italic d-block">Category: <?php echo $arr[$i]["categoryName"] ?></span>
                                        </div>
                                    </div>
                                </th>
                                <td class="border-0 align-middle">
                                    <input id="price" class="form-control" readonly="readonly" value="<?php echo $arr[$i]["productPrice"] ?> ">
                                <td class="border-0 align-middle">
                                    <input type="text" class="form-control" name="cartQty[]" value="<?php echo $arr[$i]["cartQty"] ?>" maxlength="3" id="amount" onchange="change_total()">
                                </td>
                                <td class="border-0 align-middle">
                                    <input id="total" type="text" class="form-control" name="subtotal[]" value="<?php echo ($arr[$i]["productPrice"] * $arr[$i]["cartQty"]) ?>" maxlength="10" readonly="readonly">
                                </td>
                                <td class="border-0 align-middle"><a href="./deleteCart.php?idx=<?php echo $i ?>" class="text-dark">刪除</a></td>
                            </tr>
                            <input type="hidden" name="productId[]" value="<?php echo $arr[$i]["productId"] ?>">
                            <input type="hidden" name="productPrice[]" value="<?php echo $arr[$i]["productPrice"] ?>">
                        <?php 
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if( isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0 ){ ?>
            <div class="row d-flex justify-content-start pl-3 pr-3 pb-3">
                <?php
                $sqlPaymentType = "SELECT `paymentTypeId`, `paymentTypeName`, `paymentTypeImg`
                                    FROM `payment_types`
                                    ORDER BY `paymentTypeId` ASC";
                $stmtPaymentType = $pdo->prepare($sqlPaymentType);
                $stmtPaymentType->execute();
                if($stmtPaymentType->rowCount() > 0) {
                    $arrPaymentType = $stmtPaymentType->fetchAll(PDO::FETCH_ASSOC);
                    for($j = 0; $j < count($arrPaymentType); $j++) {
                ?>
                <div class="col-md-2">
                    <input type="radio" name="paymentTypeId" id="paymentTypeId" value="<?php echo $arrPaymentType[$j]['paymentTypeId'] ?>">
                    <?php echo $arrPaymentType[$j]['paymentTypeName'] ?>
                    <img class="payment_type_icon" src="./images/payment_types/<?php echo $arrPaymentType[$j]['paymentTypeImg'] ?>">
                </div>
                <?php
                    }
                }
                ?>
            </div>
            <div class="row d-flex justify-content-end pl-3 pr-3 pb-3">
                <h3>目前總額: <mark id="totalprice"><?php echo $total ?></mark></h3>
            </div>
            <div class="row d-flex justify-content-end pl-3 pr-3 pb-3">
                <input class="btn btn-primary btn-lg" type="submit" name="smb" value="送出">
            </div>
            <?php } ?>

        </div>
    </div>
</div>

</form>

<?php
require_once('./tpl/footer.php');
require_once('./tpl/tpl-html-foot.php'); 
?>


<script>

    function change_total(){
        var base_salary = $('#amount').val();  
        var allowance = $('#price').val();
        var total = base_salary*allowance;
        $("#total").val(total);
    }
</script>