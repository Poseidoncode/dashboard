<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


$sqlOrder = "SELECT `orderlist`.`orderId`,`member`.`memberName`,SUM(`item_lists`.`checkSubtotal`) AS `total`,`payment_types`.`paymentTypeName`,`payment_types`.`paymentTypeImg`,`orderlist`.`orderStatus`,`orderlist`.`created_at`,`orderlist`.`updated_at`
                    FROM `orderlist`
                    INNER JOIN `member`
                    ON  `orderlist`.`memberId` = `member`.`memberId`
                    INNER JOIN `payment_types`
                    ON `orderlist`.`paymentTypeId` = `payment_types`.`paymentTypeId`
                    INNER JOIN `item_lists`
                    ON  `orderlist`.`orderId` = `item_lists`.`orderId`
                    WHERE `{$_POST['order_search']}` LIKE '%{$_POST['search_text']}%' 
                    AND `orderlist`.`orderStatus` LIKE '%{$_POST['orderStatus']}%'
                    GROUP BY `item_lists`.`orderId`
                    ORDER BY `orderlist`.`orderId` ASC";
        $stmtOrder = $pdo->prepare($sqlOrder);
        $stmtOrder->execute();
        if($stmtOrder->rowCount() > 0){
            $arrOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arrOrders); $i++) {
                echo '<tr>';
                echo '<td class="border">';
                echo "<input type='checkbox' name='chk[]' value=' {$arrOrders[$i]["orderId"]}' />";
                echo '</td>';
                echo "<td scope='row' class='border'>{$arrOrders[$i]['orderId']}</td>";
                echo "<td scope='row' class='border'>{$arrOrders[$i]['orderStatus']}</td>";
                echo "<td class='border'>{$arrOrders[$i]["memberName"]}</td>";
                echo '<td class="border">';
                echo "<img width='50px'src='../images/payment_types/{$arrOrders[$i]["paymentTypeImg"]}' alt=''>";
                echo $arrOrders[$i]["paymentTypeName"];
                echo '</td>';
                echo "<td class='border'>{$arrOrders[$i]["total"]}</td>";
                echo "<td class='border'>{$arrOrders[$i]["created_at"]}</td>";

                echo '<td class="border">';
                echo "<a href='./orderdetail.php?orderId={$arrOrders[$i]["orderId"]}' class='mr-1 btn-mainColor btn btn-sm '>詳細資訊</a>";
                echo "<a href='./order_deleteorder.php?orderId={$arrOrders[$i]["orderId"]}' class='btn-mainColor btn btn-sm '>刪除</a>";
                
                echo '</td>';
                echo '</tr>';
            
        
                echo "<input type='submit' name='smb' value='多筆刪除' onclick='return confirm('是否確認刪除這些資料');'>";
                echo '<a type="button" class=""href="./insetOrder.php">新增訂單</a>';
            }
        
        }else{
        
            echo '<tr>';
            echo '<td class="border text-center" colspan="8">找不到訂單!</td>';
                    echo '</tr>';
        
        }
        