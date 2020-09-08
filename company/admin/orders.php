<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>訂單一覽</h3>
<hr/>
<form name="myForm2" method="POST"  action="order_search.php">
<table class="search">
        <tr>
            <td>
                <label for="orderStatus">訂單狀態：</label>
                <select   select name="orderStatus" id="">
                    <option value="" selected>全部</option>
                    <option value="未完成">未完成</option>
                    <option value="已完成" >已完成</option>                  
                </select> 
            </td>     
            <td>
                <label for="commentRating">評論星等：</label>
                <select name="commentRating" id="">
                    <option value="" selected>全部</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </td>
            <td>
                <label for="memberOther">其它：</label>
                <select name="editcomment_search" >
                    <option value="productName">商品名稱</option>
                    <option value="orderId">訂單編號</option>
                    <option value="memberId">會員編號</option>
                    <option value="content">評論內容</option>
                </select>
                <input class="input" type="text" name="search">
            </td>
            <td><input type="submit" value="搜尋"></td>
        </tr>
        <tr>
            
        </tr>   
    </table>
</form>

<form name="myForm" class="myForm"method="POST" action="./deleteCheck.php">
    <table class="border">
        <thead>
            <tr>
                <th class="border">選擇</th>
                <th class="border">訂單編號</th>
                <th class="border">訂單狀態</th>
                <th class="border">會員名稱</th>
                <th class="border">付款方式</th>
                <th class="border">金額</th>
                <th class="border">訂單成立時間</th>
                <th class="border">功能</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sqlOrder = "SELECT `orderlist`.`orderId`,`member`.`memberName`,SUM(`item_lists`.`checkSubtotal`) AS `total`,`payment_types`.`paymentTypeName`,`orderlist`.`orderStatus`,`orderlist`.`created_at`,`orderlist`.`updated_at`
                    FROM `orderlist`
                    INNER JOIN `member`
                    ON  `orderlist`.`memberId` = `member`.`memberId`
                    INNER JOIN `payment_types`
                    ON `orderlist`.`paymentTypeId` = `payment_types`.`paymentTypeId`
                    INNER JOIN `item_lists`
                    ON  `orderlist`.`orderId` = `item_lists`.`orderId`
                    GROUP BY `item_lists`.`orderId`
                    ORDER BY `orderlist`.`orderId` ASC";
        $stmtOrder = $pdo->prepare($sqlOrder);
        $stmtOrder->execute();
        if($stmtOrder->rowCount() > 0){
            $arrOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arrOrders); $i++) {
        ?>
                <td class="border">
                    <input type="checkbox" name="chk[]" value="<?php echo $arrOrders[$i]["orderId"]; ?>" />
                </td>
                <td scope="row" class="border"><?php echo $arrOrders[$i]["orderId"] ?></td>
                <td scope="row" class="border"><?php echo $arrOrders[$i]["orderStatus"] ?></td>
                <td class="border"><?php echo $arrOrders[$i]["memberName"] ?></td>
                <td class="border"><?php echo $arrOrders[$i]["paymentTypeName"] ?></td>
                <td class="border"><?php echo $arrOrders[$i]["total"] ?></td>
                <td class="border"><?php echo $arrOrders[$i]["created_at"] ?></td>

                <td class="border">
                <a href="./orderdetail.php?orderId=<?php echo $arrOrders[$i]["orderId"] ?>" class="text-dark">詳細資訊</a>
                <a href="./deleteCheck.php?orderId=<?php echo $arrOrders[$i]["orderId"] ?>" class="text-dark">刪除</a>
                
                </td>
            </tr>
            
        <?php
            }
        ?>
        <input type="submit" name="smb" value="多筆刪除" onclick="return confirm('是否確認刪除這些資料');">
        <a type="button" class=""href="./insetOrder.php">新增訂單</a>

        <?php
        }else{
        ?>
            <tr>
                    <td class="border" colspan="7">目前沒有訂單哦!!</td>
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