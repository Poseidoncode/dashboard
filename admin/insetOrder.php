<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
//搜尋所有商品類別
$sqlcategory = "SELECT `category`.`categoryId`,`category`.`categoryName`
            FROM `category`";
$stmtcategory = $pdo->prepare($sqlcategory);
$stmtcategory->execute();
//搜尋所有付款方式
$sqlOrder = "SELECT `payment_types`.`paymentTypeId`,`payment_types`.`paymentTypeName`
            FROM `payment_types`";
$stmtOrder = $pdo->prepare($sqlOrder);
$stmtOrder->execute();

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

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>新增訂單</h3>
<hr/>
<a type="button" class="btn btn-secondary btn-sm mb-3"href="./Orders.php">訂單列表</a>


<form name="myForm" class="myForm"method="POST" action="./addOrders.php">
<table class="border">
    <tr>
        <th class="border">會員ID</th>
        <td class="border">
            <input type="text" name="memberId" id="memberId" value="" maxlength="10" />
        </td>
    </tr>
    <tr>
        <th class="border">付款方式</th>
        <td class="border">
            <select name="paymentTypeId">
            <?php 
            if($stmtOrder->rowCount() > 0){
                $arrOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
                for($i = 0; $i < count($arrOrders); $i++) {       
            ?>
                <option value="<?php echo $arrOrders[$i]['paymentTypeId']?>"><?php echo $arrOrders[$i]['paymentTypeName']?></option>
            <?php 
                }
            }
            ?>
            </select>
        </td> 
    </tr>
    <tr>
        <th class="border">商品類別</th>
        <td class="border">
            <select id="category"name="category">
                <option value="0">-----請選擇-----</option>
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
                <option value="0">-----請選擇-----</option>
                    
            </select>
        </td> 
    </tr>
    <tr>
        <th class="border">數量</th>
        <td class="border">
            <input type="text" name="amountId" id="amountId" value="" maxlength="10" />
        </td>
    </tr>
    <tr>
        <td class="border" colspan="7"><input class="btn-mainColor btn btn-sm mt-3"type="submit" name="smb" value="新增"></td>
    </tr>  
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