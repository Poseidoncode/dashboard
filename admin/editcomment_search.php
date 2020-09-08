<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

 
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>查詢結果</title>
    <style>
    .memberborder {
        border: 1px solid #aaa;
    }
    .w200px {
        width: 200px;
    }
    .tb{
        width: 100%;
    }
    .myForm td , .myForm th{
        padding:3px 10px;
        text-align:center;
    }

    .search td{
        /* border:1px solid black; */
        padding:5px 10px;
    }

    .input{
        width:300px;
    }
    .redcolor{
        color:red;
    }

    </style>
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<input type="button" value="返回列表" onclick="location.href='./editcomment.php'">

<hr>

 
<?php
// //SQL 敘述
//         $sql = "SELECT `product`.`productId`, `product`.`productName`, `product`.`productImg`, `product`.`productPrice`, `product`.`productAmount`, `product`.`productAddress`, `product`.`productEndingDate`,`product`.`categoryId`, `product`.`created_at`, `product`.`updated_at`,`category`.`categoryName`
//                 FROM `product` LEFT JOIN `category`
//                 ON `product`.`categoryId` = `category`.`categoryId`
//                  ";



// //查詢
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute();
//         $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

?> 


<form name="myForm2" method="POST"  action="editcomment_search.php">
<table class="search">
        <tr>
            <td>
                <label for="replyStatus">回覆狀態：</label>
                <select   select name="replyStatus" id="">
                    <option value="" selected>全部</option>
                    <option value="未回覆">未回覆</option>
                    <option value="已回覆" >已回覆</option>                  
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

<form name="myForm" class="myForm" method="POST" action="./comment_delete.php" >
    <label for="commentOther">功能：</label>
        <a  class="button" href="./insert_newcomment.php">新增資料</a>
        <label>
        <input type="checkbox" name="CheckAll" value="核取方塊" id="CheckAll" />
        全選</label>

        <input type="submit"  class="button" value="刪除勾選項目" onclick= "return confirm('是否確認刪除這些資料')">
        
        <table class="tb">
            <thead>
            <tr>
                <th class="border">勾選</th>
                <th class="border">商品圖片</th>
                <th class="border">商品名稱</th>
                <th class="border">評論內容</th>
                <th class="border">評論星等</th>
                <th class="border">回覆狀態</th>
                <th class="border">功能</th>
                <th class="border">更新時間</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $s=$_POST['editcomment_search'];


            $sql = "SELECT `comments`.`id`, `comments`.`status`,`comments`.`content`, `comments`.`rating`, `comments`.`itemId`, `comments`.`updated_at`,`item_lists`.`productId`, `comments`.`adminReply`,`orderlist`.`memberId`,`item_lists`.`orderId`,`product`.`productName`,`item_lists`.`itemListId`
                    FROM `comments` 
                    LEFT JOIN `item_lists` 
                    ON  `comments`.`itemId` =`item_lists`.`productId`
                    LEFT JOIN `product` 
                    ON  `comments`.`itemId` =`product`.`productId`
                    LEFT JOIN `orderlist` 
                    ON  `item_lists`.`orderId` =`orderlist`.`orderId`
                    WHERE `{$s}` LIKE '%{$_POST['search']}%' 
                    AND `status` LIKE '%{$_POST['replyStatus']}%'                   
                    AND `rating` LIKE '%{$_POST['commentRating']}%'                   
                    ORDER BY `id` ASC";
                    

            // $arrParam = [($page - 1) * $numPerPage, $numPerPage];
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            // echo "<pre>";
            // print_r($stmt);
            // echo "</pre>";
            // exit();

            if( $stmt->rowCount() > 0){
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for( $i = 0 ; $i < count($arr) ; $i++ ){
            ?>
         <tr>
                    <td class="border">
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['id']; ?>" />
                    </td>
                    <td class="border"><?php echo $arr[$i]['orderId'] ?></>
                    <td class="border"><?php echo $arr[$i]['productName'] ?></>
                    <td class="border"><?php echo $arr[$i]['memberId'] ?></>
                    <td class="border"><?php echo $arr[$i]['content'] ?></td>
                    <td class="border"><?php echo $arr[$i]['rating'] ?></td>
                    <td class="border">
                        <?php if ($arr[$i]['status'] === "未回覆"){?>
                             <p class="redcolor"><?php echo $arr[$i]['status']?></p>
                        <?php }else{ ?>
                              <p><?php echo $arr[$i]['status']?></p>
                        <?php }?>
                    </td>
                    
                    <!-- <td class="border"><?php echo $arr[$i]['productId'] ?></td>  -->
                    <td class="border">
                    <a class="button" href="./comments.php?id=<?php echo $arr[$i]['id']; ?>">編輯回覆</a>
                    <a  class="button" href="./comment_delete.php?id=<?php echo $arr[$i]['id']; ?>" onclick= "return confirm('是否確認刪除這些資料')";>單筆刪除</a>
                    </td>
                   <td class="border"><?php echo $arr[$i]['updated_at'] ?></td>
                </tr>
            <?php
                }
            }else{
            ?>
                <tr>
                    <td class="memberborder" colspan="10">沒有資料</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
    
</form>



</body>
</html>


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
 })
</script>