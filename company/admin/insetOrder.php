<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


$sqlOrder = "SELECT `payment_types`.`paymentTypeId`,`payment_types`.`paymentTypeName`
            FROM `payment_types`";
$stmtOrder = $pdo->prepare($sqlOrder);
$stmtOrder->execute();
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>新增訂單</h3>
<hr/>


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
        <th class="border">商品ID</th>
        <td class="border">
            <input type="text" name="productId" id="productId" value="" maxlength="10" />
        </td>
    </tr>
    <tr>
        <th class="border">數量</th>
        <td class="border">
            <input type="text" name="amountId" id="amountId" value="" maxlength="10" />
        </td>
    </tr>
    <tr>
        <td class="border" colspan="7"><input type="submit" name="smb" value="新增"></td>
    </tr>  
</table>
          

</form>

</body>
</html>