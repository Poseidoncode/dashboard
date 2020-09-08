<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>訂單一覽</h3>
<hr/>

<table class="search">
        <tr>
            <td>
                <label for="orderStatus">訂單狀態：</label>
                <select   select name="orderStatus" id="orderStatus">
                    <option data-item=""value="" selected>全部</option>
                    <option data-item=""value="未完成">未完成</option>
                    <option value="已完成" >已完成</option>                  
                </select> 
            </td>     
            <td>
                <label for="memberOther">其它：</label>
                <select id="order_search"name="order_search" >
                    <option value="orderlist`.`orderId">訂單編號</option>
                    <option value="member`.`memberName">會員名稱</option>
                </select>
                <input id="search_text"class="input" type="text" name="search">
            </td>
            <td><input class="btn-mainColor btn btn-sm"id="search_order"type="submit" value="搜尋"></td>
        </tr>
        <tr>
            
        </tr>   
    </table>
<form name="myForm" class="myForm"method="POST" action="./deleteCheck.php">
    <table class="table table-striped border_article">
        <thead class="thead-mainColor">
            <tr>
                <th class="border">
                <input class="checkbox"id="CheckAll"type="checkbox">
                選擇</th>
                <th class="border">訂單編號</th>
                <th class="border">訂單狀態</th>
                <th class="border">會員名稱</th>
                <th class="border">付款方式</th>
                <th class="border">金額</th>
                <th class="border">訂單成立時間</th>
                <th class="border">功能</th>
            </tr>
        </thead>
        <tbody id="tbd">
        <?php
        $sqlOrder = "SELECT `orderlist`.`orderId`,`member`.`memberName`,SUM(`item_lists`.`checkSubtotal`) AS `total`,`payment_types`.`paymentTypeName`,`payment_types`.`paymentTypeImg`,`orderlist`.`orderStatus`,`orderlist`.`created_at`,`orderlist`.`updated_at`,`product`.`companyId`
        FROM `orderlist`
        INNER JOIN `member`
        ON  `orderlist`.`memberId` = `member`.`memberId`
        INNER JOIN `payment_types`
        ON `orderlist`.`paymentTypeId` = `payment_types`.`paymentTypeId`
        INNER JOIN `item_lists`
        ON `item_lists`.`orderId` = `orderlist`.`orderId`
        INNER JOIN `product`
        ON  `product`.`productId` = `item_lists`.`productId`
        WHERE `product`.`companyId` = {$_SESSION['Id']}
        GROUP BY `item_lists`.`orderId`
        ORDER BY `orderlist`.`orderId` ASC";
        $stmtOrder = $pdo->prepare($sqlOrder);
        $stmtOrder->execute();
        if($stmtOrder->rowCount() > 0){
            $arrOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arrOrders); $i++) {
        ?>
            <tr>    
                <td class="border">
                    <input class="checkbox"type="checkbox" name="chk[]" value="<?php echo $arrOrders[$i]["orderId"]; ?>" />
                </td>
                <td scope="row" class="border"><?php echo $arrOrders[$i]["orderId"] ?></td>
                <td scope="row" class="border"><?php echo $arrOrders[$i]["orderStatus"] ?></td>
                <td class="border"><?php echo $arrOrders[$i]["memberName"] ?></td>
                <td class="border">
                <img width="50px"src="../images/payment_types/<?php echo $arrOrders[$i]["paymentTypeImg"]?>" alt="">
                <?php echo $arrOrders[$i]["paymentTypeName"] ?>
                </td>
                <td class="border"><?php echo number_format($arrOrders[$i]["total"]) ?></td>
                <td class="border"><?php echo $arrOrders[$i]["created_at"] ?></td>

                <td class="border">
                <a href="./orderdetail.php?orderId=<?php echo $arrOrders[$i]["orderId"] ?>" class="btn-mainColor btn btn-sm">訂單明細</a>
                
                </td>
            </tr>
            
      
        <?php
            }
        ?>
        

        <?php
        }else{
        ?>
            <tr>
                    <td class="border" colspan="8">目前沒有訂單哦!!</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    
    
</div>

</form>
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
  $('#search_order').on("click", function(){
        $.ajax({
            method: "POST",
            url: "./order_search.php",
            dataType: "html",
            data: { 
                orderStatus: $('#orderStatus').val(),
                order_search: $('#order_search').val(),
                search_text: $('#search_text').val()

            }
        })
        .done(function( data ) {
            $('#tbd').html(data)
        })
        .fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    });     
 })
 
</script>
</body>
</html>