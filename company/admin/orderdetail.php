<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>訂單一覽</h3>
<hr/>

<a type="button" href="./orders.php"class="btn btn-secondary ">回到訂單資訊</a>
<form name="myForm" class="myForm"method="POST" action="./deleteCheck.php">
    <table class="border">
        <thead>
            <tr>
                <th class="border">勾選</th>
                <th class="border">商品名稱</th>
                <th class="border">商品照片</th>
                <th class="border">單價</th>
                <th class="border">數量</th>
                <th class="border">小計</th>
                <th class="border">功能</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sqlOrder = "SELECT `item_lists`.`itemListId`,`product`.`productName`,`product`.`productImg`,`item_lists`.`checkPrice`,`item_lists`.`checkQty`,`item_lists`.`checkSubtotal`
                    FROM `item_lists`
                    INNER JOIN `product`
                    ON  `item_lists`.`productId` = `product`.`productId`
                    WHERE `item_lists`.`orderId` = ?";
        $arrParam=[$_GET['orderId']];

        $stmtOrder = $pdo->prepare($sqlOrder);

        $stmtOrder->execute($arrParam);
        if($stmtOrder->rowCount() > 0){
            $arrOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arrOrders); $i++) {
        ?>
                <td class="border">
                    <input type="checkbox" name="chk[]" value="<?php echo $arrOrders[$i]["itemListId"]; ?>" />
                </td>
                <td scope="row" class="border"><?php echo $arrOrders[$i]["productName"] ?></td>
                <td scope="row" class="border">
                <?php
                if($arrOrders[$i]['productImg'] != Null){
                    echo '<img class="productImg" src="../images/products/'.$arrOrders[$i]['productImg'].'" />';
                }
                ?>
                </td>
                <td class="border"><?php echo $arrOrders[$i]["checkPrice"] ?></td>
                <td class="border"><?php echo $arrOrders[$i]["checkQty"] ?></td>
                <td class="border"><?php echo $arrOrders[$i]["checkSubtotal"] ?></td>

                <td class="border">
                <a href="./deleteCheck.php?orderId=<?php echo $arrOrders[$i]["orderId"] ?>" class="text-dark">刪除</a>
                
                </td>
            </tr>
            
        <?php
            }
        ?>
        
        <input type="submit" name="smb" value="多筆刪除" onclick="return confirm('是否確認刪除這些資料');">
        <?php
        }else{
        ?>
            <tr>
                    <td class="border" colspan="8">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        
        </tbody>
    </table>
    
    
</div>

</form>

</body>
</html>