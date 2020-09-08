<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('./templates/title.php');
require_once('./templates/sidebar.php'); ?>
<hr/>
<h3>平台資訊</h3>
<hr>

<?php
        
     $sql1 = "SELECT COUNT(1) FROM `member`";
     $sql2= "SELECT COUNT(1) FROM `company`";     

     $sql1_count = $pdo->query($sql1)->fetch(PDO::FETCH_NUM)[0]; 
     $sql2_count = $pdo->query($sql2)->fetch(PDO::FETCH_NUM)[0]; 


     $sql3 = "SELECT `updated_at` FROM `member` ORDER BY `updated_at` DESC";
     $sql4 = "SELECT `updated_at` FROM `company` ORDER BY `updated_at` DESC";
     $sql3_time = $pdo->query($sql3)->fetch(PDO::FETCH_NUM)[0]; 
     $sql4_time = $pdo->query($sql4)->fetch(PDO::FETCH_NUM)[0];
?>

<table class="border_b table">
        <h5 class="">會員管理</h5>
        <thead class="thead-mainColor">
            <tr>
                <th class="border_b"></th>
                <th class="border_b">平台人數</th>
                <th class="border_b">最後更新時間</th>
            </tr>
        </thead>
        <tbody>
            <tr>    
                <th class="border_b">一般會員</th>
                <th class="border_b"><?php echo $sql1_count?></th>
                <th class="border_b"><?php echo $sql3_time?></th>
            </tr>
            <tr>    
                <th class="border_b">廠商會員</th>
                <th class="border_b"><?php echo $sql2_count?></th>
                <th class="border_b"><?php echo $sql4_time?></th>
            </tr>
            <tr>    
                <th class="border_b">全部會員</th>
                <th class="border_b"><?php echo $sql1_count +$sql2_count ?></th>
                <th class="border_b">
                <?php
                    if(strtotime($sql3_time) > strtotime($sql4_time)){
                        echo $sql3_time;
                    }else{echo $sql4_time;}
                ?>
            </tr>
        </tbody>
</table>

<?php      
     $sql5="SELECT `orderStatus`,`updated_at` ,`created_at` 
            FROM `orderlist` 
            WHERE `orderStatus` LIKE '%未完成%'
            ORDER BY `updated_at` DESC";
     $sql6="SELECT `orderStatus` ,`updated_at` ,`created_at`
            FROM `orderlist` 
            WHERE `orderStatus` LIKE '%已完成%'
            ORDER BY `updated_at` DESC";     

     $sql5_count = $pdo->prepare($sql5);
     $sql5_count->execute();
     $arr1 = $sql5_count->fetchAll(PDO::FETCH_ASSOC);

     $sql6_count = $pdo->prepare($sql6);
     $sql6_count->execute();
     $arr2 = $sql6_count->fetchAll(PDO::FETCH_ASSOC);

    $sql7="SELECT SUM(`checkSubtotal`) AS `total` ,`orderlist`.`orderStatus`
            FROM `item_lists` 
            LEFT JOIN `orderlist`
            ON `item_lists`. `orderId` = `orderlist`.`orderId`
            GROUP BY `orderlist`.`orderStatus`";
    $sql7_amount = $pdo->prepare($sql7);
    $sql7_amount->execute();
    $arr3 = $sql7_amount->fetchAll(PDO::FETCH_ASSOC);
  
?>


<table class="border_b table">
<h5 class="">訂單管理</h5>
        <thead class="thead-mainColor">
            <tr>
                <th class="border_b"></th>
                <th class="border_b">訂單數目</th>
                <th class="border_b">訂單金額總和</th>
                <th class="border_b">最後更新時間</th>
            </tr>
        </thead>
        <tbody>
            <tr>    
                <th class="border_b">未完成訂單</th>
                <th class="border_b"><?php 
                if(count($arr1) !== 0){
                    echo count($arr1);
                }else{
                    echo "0";
                }?></th>
                <th class="border_b"><?php 
                  if(count($arr3) !== 0){
                    echo $arr3[0]['total'];
                    }else{
                        echo "0";
                    }?></th>
                <th class="border_b"><?php if(!isset($arr1[0]['updated_at'])){echo '無任何未完成訂單';}else{echo $arr1[0]['updated_at'];}?></th>
            </tr>
            <tr>    
                <th class="border_b">已完成訂單</th>
                <th class="border_b"><?php 
                    if(count($arr2) !== 0){
                        echo count($arr2);
                    }else{
                        echo "0";
                    }?></th>
                <th class="border_b"><?php 
                    if(isset($arr3[1])){
                    echo $arr3[1]['total'];
                    }else{
                        echo "0";
                    }?></th>
                <th class="border_b"><?php if(!isset($arr2[0]['updated_at'])){echo '無任何已完成訂單';}else{echo $arr2[0]['updated_at'];}?></th>
            </tr>
            <tr>    
                <th class="border_b">全部訂單</th>
                <th class="border_b"><?php 
                    if(count($arr2) + count($arr1) !== 0){
                        echo count($arr2) + count($arr1);
                    }else{
                        echo "0";
                    }?></th>
                <th class="border_b"><?php 
                    if( isset($arr3[1]) && isset($arr3[0]) ){
                        echo $arr3[1]['total'] + $arr3[0]['total'];
                    }else{
                        if(isset($arr3[1])){
                            echo $arr3[1]['total'];
                        }elseif(isset($arr3[0])){
                            echo $arr3[0]['total'];
                        }else{echo 0;}
                        
                     }?></th>
                <th class="border_b">
                <?php
                    if(isset($arr1[0]['updated_at'])&&isset($arr2[0]['updated_at'])){
                        if(strtotime($arr1[0]['updated_at']) > strtotime($arr2[0]['updated_at'])){
                            echo $arr1[0]['updated_at'];
                        }else{echo $arr2[0]['updated_at'];}
                    }else{
                        if(isset($arr1[0]['updated_at'])){
                            echo $arr1[0]['updated_at'];
                        }elseif(isset($arr2[0]['updated_at'])){echo $arr2[0]['updated_at'];
                        }else{
                            echo "無任何任何訂單";
                        }
                    }
                    
                ?>
                </th>
            </tr>
        </tbody>
</table>
   
<?php

    $year = Getdate()['year'];
    $mon = Getdate()['mon'];
    $mday = Getdate()['mday'];
    $today = $year."-"."0".$mon."-".$mday;

    $sql8="SELECT `created_at`,`updated_at`
               FROM `product` 
               WHERE `created_at` LIKE '%{$today}%'
               ORDER BY `created_at` DESC
               ";
 
    $sql8_count = $pdo->prepare($sql8);
    $sql8_count->execute();
    $arr4 = $sql8_count->fetchAll(PDO::FETCH_ASSOC);


    $sql9="SELECT `created_at`,`updated_at`
               FROM `product`
               ORDER BY `updated_at` DESC
               ";

   $sql9_count = $pdo->prepare($sql9);
   $sql9_count->execute();
   $arr5 = $sql9_count->fetchAll(PDO::FETCH_ASSOC);         

?>

<?php
// print_r($today);
// exit();
?>


<table class="border_b table">
<h5 class="">商品管理</h5>
        <thead class="thead-mainColor">
            <tr>
                <th class="border_b"></th>
                <th class="border_b">商品數目</th>
                <th class="border_b">最後更新時間</th>
            </tr>
        </thead>
        <tbody>
            <tr>    
                <th class="border_b">今日上架商品</th>
                <th class="border_b"><?php 
                    if(count($arr4) !== ""){
                        echo count($arr4);
                    }else{
                        echo "0";
                    }
                    ?>
                </th>

                <th class="border_b"><?php 
                if(count($arr4) === 0){
                    echo  "今日無任何新商品上架";
                }else{
                    echo "$arr4[0]['created_at']";
                }
                 ?>  
               </th>
            </tr>
            <tr>    
                <th class="border_b">全部商品</th>
                <th class="border_b"><?php echo count($arr5)?></th>
                <th class="border_b"><?php echo $arr5[0]['updated_at']?></th>
            </tr>
            <tr>    
     
                </th>
            </tr> 
        </tbody>
</table>
<?php
?> 
</body>
</html>

<?php
?>