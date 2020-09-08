<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>訂單明細    </h3>
<hr/>

<a type="button" href="./orders.php"class="btn btn-secondary ">回到訂單資訊</a>
<a type="button" href="./order_detail_insetproduct.php?orderId=<?php echo$_GET['orderId']?>"class="btn btn-secondary ">新增商品</a>
<form name="myForm" class="myForm mt-3"method="POST" action="./orderdetail_deletes.php">
    <table class="table table-striped border_article">
        <thead class="thead-mainColor">
            <tr>
                <th class="border">
                <input class="checkbox"id="CheckAll"type="checkbox">
                選擇</th>
                <th class="border">商品名稱</th>
                <th class="border">商品照片</th>
                <th class="border">單價</th>
                <th class="border">數量</th>
                <th class="border">金額</th>
                <th class="border">功能</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //列出目前訂單明細
        $sqlOrder = "SELECT `item_lists`.`itemListId`,`product`.`productName`,`product`.`productImg`,`item_lists`.`checkPrice`,`item_lists`.`checkQty`,`item_lists`.`checkSubtotal`
        FROM `item_lists`
        INNER JOIN `product`
        ON  `item_lists`.`productId` = `product`.`productId`
        WHERE `product`.`companyId` = ?
        AND `item_lists`.`orderId` = ?";
        $arrParam=[
            $_SESSION['Id'],
            $_GET['orderId']
        ];

        $stmtOrder = $pdo->prepare($sqlOrder);

        $stmtOrder->execute($arrParam);
        if($stmtOrder->rowCount() > 0){
            $arrOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arrOrders); $i++) {
        ?>
                <td class="border">
                    <input class="checkbox"type="checkbox" name="chk[]" value="<?php echo $arrOrders[$i]["itemListId"]; ?>" />
                </td>
                <td scope="row" class="border"><?php echo $arrOrders[$i]["productName"] ?></td>
                <td scope="row" class="border">
                <?php
                if($arrOrders[$i]['productImg'] != Null){
                    echo '<img class="productImg" src="../images/products/'.$arrOrders[$i]['productImg'].'" />';
                }
                ?>
                </td>
                <td class="border"><?php echo number_format($arrOrders[$i]["checkPrice"]) ?></td>
                <td class="border"><?php echo $arrOrders[$i]["checkQty"] ?></td>
                <td class="border"><?php echo number_format($arrOrders[$i]["checkSubtotal"]) ?></td>

                <td class="border">
                <a id="detail_delete"href="./orderdetail_change.php?orderId=<?php echo $_GET['orderId']?>&itemListId=<?php echo $arrOrders[$i]["itemListId"]?>" class="btn-mainColor btn btn-sm">修改</a>
                <a id="detail_delete"href="./orderdetail_delete.php?orderId=<?php echo $_GET['orderId']?>&itemListId=<?php echo $arrOrders[$i]["itemListId"]?>" class="btn-mainColor btn btn-sm"onclick="return confirm('是否確定刪除');">刪除</a>
                
                </td>
            </tr>
            
        <?php
            }
        ?>
        
        <?php
        }else{
        ?>
            <tr>
                    <td class="border" colspan="8">沒有訂單</td>
            </tr>
        <?php
        }
        ?>
        <input type="hidden" name="orderId"value="<?php echo $_GET['orderId']?>"></input>
        
        </tbody>
        <tfoot>
            <tr>
                <td class="text-left"colspan="2">
                    <span>已選擇項目:</span>
                    <input type="submit" class="btn btn-mainColor btn-sm" name="smb" value="多筆刪除" onclick="return confirm('確定要刪除勾選的資料？')">
                </td>
            <?php
            //計算總額
            $sqltotal = "SELECT `item_lists`.`itemListId`,SUM(`item_lists`.`checkSubtotal`) AS `total`
                            FROM `item_lists`
                            iNNER JOIN `product`
                            ON `item_lists`.`productId` = `product`.`productId`
                            WHERE `product`.`companyId` = ?
                            AND `item_lists`.`orderId` = ?";
            $arrParamtotal=[
                $_SESSION['Id'],
                $_GET['orderId']
            ];
            $stmttotal = $pdo->prepare($sqltotal);
            $stmttotal->execute($arrParamtotal); 
            if($stmttotal->rowCount() > 0){
                $arrtotal = $stmttotal->fetchAll(PDO::FETCH_ASSOC)[0];
            ?>
            <td colspan="8" class="h3 text-right">總計:<?php echo number_format($arrtotal['total'])?></td>
            <?php
            }
            ?>
            </tr>
            
        
        </tfoot>
    </table>
    </div>
</form>


    <?php
        //搜尋所有商品類別
        $sqlcategory = "SELECT `category`.`categoryId`,`category`.`categoryName`
        FROM `category`";
        $stmtcategory = $pdo->prepare($sqlcategory);
        $stmtcategory->execute();
    ?>

    <!-- <h3 class="mt-5">新增商品</h3>
    <form name="myForm" method="POST" action="./insert.php">
        <table class="border">
            <thead>
                <tr>
                    <th class="border">商品類別</th>
                    <th class="border">商品名稱</th>
                    <th class="border">數量</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border">
                        <select id="category"name="category">
                        <option value="0">-----請選擇-----</option>
                        <?php 
                        //撈出商品
                        if($stmtcategory->rowCount() > 0){
                            $arrcategory = $stmtcategory->fetchAll(PDO::FETCH_ASSOC);
                            for($i = 0; $i < count($arrcategory); $i++) {       
                        ?>
                            <option value="<?php echo $arrcategory[$i]['categoryId']?>"><?php echo $arrcategory[$i]['categoryName']?></option>
                        <?php 
                            }
                        }
                        ?>
                        </select>
                    </td> 
                    <td class="border">
                        <select id="productName"name="productName">
                            <option value="0">-----請選擇-----</option>
                            
                        </select>
                    </td>
                    <td class="border">
                        <input type="text" name="productId" id="productId" value="" maxlength="10" />
                    </td> 
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="border" colspan="5"><input type="submit" name="smb" value="新增"></td>
                </tr>
            </tfoot>
        </table>
    </form> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        $("#CheckAll").click(function(){
            if($("#CheckAll").prop("checked")){//如果全選按鈕有被選擇的話（被選擇是true）
                $("input[name='chk[]']").each(function(){
                    $(this).prop("checked",true);//把所有的核取方框的property都變成勾選
                })
            }else{
                $("input[name='chk[]']").each(function(){
                    $(this).prop("checked",false);//把所有的核方框的property都取消勾選
                })
            }
        })
        $(document).on("change",'#paymentTypeId', function(){
                $.ajax({
                method: "POST",
                url: "order_detail_changepaymentTypeIdP.php",
                dataType: "json",
                data: { 
                    paymentTypeId: $('#paymentTypeId').val(),
                    orderId: <?php echo $_GET['orderId']?>
                }
            })
                .done(function(json) {
                    alert( json.info);
                })
        });        
    })
    // $(document).ready(function(){
    //     $(document).on("change",'#category', function(){
    //         if($('#category').val() == "0"){
    //             $("#productName").val("0");
    //         }else{
    //             $.ajax({
    //             method: "POST",
    //             url: "order_detail_insetproductP.php",
    //             dataType: "html",
    //             data: { 
    //                 categoryId: $('#category').val()
    //             }
    //         })
    //             .done(function( data ) {
    //             $("#productName").html(data)
    //             })
    //             .fail(function( jqXHR, textStatus ) {
    //             alert( "Request failed: " + textStatus );
    //             });
    //         }
    //     });     
    // })
 
</script>
</body>
</html>