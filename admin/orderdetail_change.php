<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>更改商品</h3>
<hr/>
<?php
//原本的購買資料
$sqlitem = "SELECT `item_lists`.`productId`,`product`.`categoryId`,`category`.`categoryName`,`product`.`productName`,`item_lists`.`checkQty`
            FROM `item_lists`
            INNER JOIN `product`
            ON `item_lists`.`productId`= `product`.`productId`
            INNER JOIN `category`
            ON  `product`.`categoryId` = `category`.`categoryId`
            WHERE `itemListId`= {$_GET['itemListId']}";
$stmtitem = $pdo->prepare($sqlitem);
$stmtitem->execute(); 
$item_lists= $stmtitem->fetchAll(PDO::FETCH_ASSOC)[0];

//建立商品列表
function buildTree($pdo, $parentId = 0){
    $sql = "SELECT `categoryId`, `categoryName`, `categoryParentId`
            FROM `category` 
            WHERE `categoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            if($arr[$i]['categoryParentId'] == 0){
                echo "<optgroup label='".$arr[$i]['categoryName']."'>";
            }else{
                echo "<option value='".$arr[$i]['categoryId'];
                echo "'>";
                echo $arr[$i]['categoryName'];
                echo "</option>";
            }
            buildTree($pdo, $arr[$i]['categoryId']); 
            if($arr[$i]['categoryParentId'] == 0){
                echo "</optgroup>";
            }
        }
    }
}
?>


<form name="myForm" class="myForm"method="POST" action="./orderdetail_changeP.php">
    <table id="tbd"class="border">
        <tr>
            <th class="border">商品類別</th>
            <td class="border">
                <select id="category"name="category">
                <option value="<?php echo $item_lists['categoryId']?>"><?php echo $item_lists['categoryName']?></option>
                <?php 
                //撈出商品
                buildTree($pdo, 0); 
                ?>
                </select>
            </td> 
        </tr>
        <tr>
            <th class="border">商品名稱</th>
            <td class="border">
                <select id="productName"name="productId">
                    <option value="<?php echo $item_lists['productId']?>"><?php echo $item_lists['productName']?></option>
                    <?php
                    //搜尋該商品類別有哪些商品 
                    $sqlproduct = "SELECT `productId`,`productName`
                    FROM `product`
                    WHERE `categoryId` = {$item_lists['categoryId']}";
                    $stmtproduct = $pdo->prepare($sqlproduct);
                    $stmtproduct->execute();
                    if($stmtproduct->rowCount() > 0){
                        $arrproduct = $stmtproduct->fetchAll(PDO::FETCH_ASSOC);
                        for($i = 0; $i < count($arrproduct); $i++) {  
                            if($arrproduct[$i]['productId'] != $item_lists['productId']){  
                    ?>
                                <option value="<?php echo $arrproduct[$i]['productId']?>"><?php echo $arrproduct[$i]['productName']?></option>
                    <?php
                            }
                        }
                    }    
                    ?>
                </select>
            </td> 
        </tr>
        <tr>
            <th class="border">數量</th>
            <td class="border">
                <input type="text" name="amountId" id="amountId" value="<?php echo $item_lists['checkQty'] ?>" maxlength="10" />
            </td>
        </tr>
        <tr>
            <td class="border" colspan="7"><input class="btn-mainColor btn btn-sm"type="submit" name="smb" value="更新"></td>
        </tr> 
        <input name="orderId"type="hidden"value="<?php echo$_GET['orderId']?>">
        <input name="itemListId"type="hidden"value="<?php echo$_GET['itemListId']?>">
    </table>
          

</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        $(document).on("change",'#category', function(){
            if($('#category').val() == "0"){
                $("#productName").val("0");
            }else{
                $.ajax({
                method: "POST",
                url: "order_detail_insetproductP.php",
                dataType: "html",
                data: { 
                    categoryId: $('#category').val()
                }
            })
                .done(function( data ) {
                $("#productName").html(data)
                })
                .fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
                });
            }
        });     
    })
 
</script>
</body>
</html>