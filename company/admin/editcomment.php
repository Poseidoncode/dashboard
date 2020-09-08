<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//SQL搜尋語法:取得 member 資料表總筆數
$sqlTotal = "SELECT count(1) FROM `comments` ";

//取得總筆數
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];

//每頁幾筆
$numPerPage = 15;

//總頁數
$totalPages = ceil($total/$numPerPage);

$page = isset($_GET['page'])?(int)$_GET['page'] : 1;
//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;

?>

<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>查詢結果</title>
    <style>
    .border {
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

    .tri_up{
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 5px 10px 5px;
        border-color: transparent transparent white transparent;
        position: relative;
        left:3px;
        top:-13px;
        }
    .tri_down{
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 10px 5px 0 5px;
        border-color: white transparent transparent transparent;
        position: relative;
        left:3px;
        top:15px;
        }

    .linkcolor a{
        color:black;
    }
    </style>
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />

<h3>評價管理頁面</h3>
<hr>

<?php
if(isset($_GET['s']) && isset($_GET['c']) ){
    $s=$_GET['s'];
    $c=$_GET['c']; 
}else{
    $s="";
    $c="";  
}

?>

<form name="myForm2" method="GET"  action=".editcomment.php">
<table class="search">
<tr class="border_b">
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
            
        </tr>   
    </table>

</form>

<form name="myForm" class="myForm" method="POST" action="comments_delete.php" >     
    <label for="commentOther">功能：</label>
    <input type="button"  onclick="location.href='./insert_newcomment.php'" value="新增資料">
    <label>
      <input type="checkbox" name="CheckAll" value="核取方塊" id="CheckAll" />
    全選</label>

    <input type="submit"  value="刪除勾選項目" onclick= "return confirm('是否確認刪除這些資料')">
    
    <table class="tb">
        <thead>
            <tr>
                <th class="border">勾選</th>
                <th class="border linkcolor ">
                <?php
                if($s!=1 and $c == 'orderId'){
                ?>   
                 <a href="./editcomment.php?c=orderId&amp;s=1&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>"> 訂單編號</a><span class="tri_up"></span>
                <?php
                }else if($s!=2 and $c == 'orderId'){
                ?>
                 <a href="./editcomment.php?c=orderId&amp;s=2&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>"> 訂單編號</a><span class="tri_down"></span>
                <?php
                }else{
                ?>    
                 <a href="./editcomment.php?c=orderId&amp;s=1&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>">訂單編號</a>
                <?php
                 }
                ?>  
                </th>
                <th class="border">商品名稱</th>
                <th class="border">會員ID</th>
                <th class="border">評論內容</th>

                <th class="border linkcolor">
                <?php
                if($s!=1 and $c == 'rating'){
                ?>   
                 <a href="./editcomment.php?c=rating&amp;s=1&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>">評論星等</a><span class="tri_up"></span>
                <?php
                }else if($s!=2 and $c == 'rating'){
                ?>
                 <a href="./editcomment.php?c=rating&amp;s=2&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>">評論星等</a><span class="tri_down"></span>
                <?php
                }else{
                ?>    
                <a href="./editcomment.php?c=rating&amp;s=1&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>">評論星等</a>
                <?php
                 }
                ?>  
                </th>

                <th class="border linkcolor">
                <?php
                if($s!=1 and $c == 'status'){
                ?>   
                 <a href="./editcomment.php?c=status&amp;s=1&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>">回覆狀態</a><span class="tri_up"></span>
                <?php
                }else if($s!=2 and $c == 'status'){
                ?>
                 <a href="./editcomment.php?c=status&amp;s=2&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>">回覆狀態</a><span class="tri_down"></span>
                <?php
                }else{
                ?>    
                 <a href="./editcomment.php?c=status&amp;s=1&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>">回覆狀態</a>
                <?php
                 }
                ?>  
                </th>     

                <th class="border linkcolor">
                <?php
                if($s!=1 and $c == 'updated_at'){
                ?>   
                 <a href="./editcomment.php?c=updated_at&amp;s=1&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>">評論時間</a><span class="tri_up"></span>
                <?php
                }else if($s!=2 and $c == 'updated_at'){
                ?>
                 <a href="./editcomment.php?c=updated_at&amp;s=1&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>">評論時間</a><span class="tri_up"></span><span class="tri_down"></span>
                <?php
                }else{
                ?>    
                <a href="./editcomment.php?c=updated_at&amp;s=1&editcomment_search=<?php echo $_GET['editcomment_search']?>&search=<?php echo $_GET['search']?>&replyStatus=<?php echo $_GET['replyStatus']?>&commentRating=<?php echo $_GET['commentRating']?>">評論時間</a>
                <?php
                 }
                ?>  
               </th>
                <th class="border">功能</th>
            </tr>
        </thead>
        <tbody>
            <?php
      
            if(isset($_GET['editcomment_search']) ){
                $p=$_GET['editcomment_search'];
            }else{
                $p ='';
            }

            $sql = "SELECT `comments`.`id`, `comments`.`status`,`comments`.`content`, `comments`.`rating`, `comments`.`itemId`, `comments`.`updated_at`,`item_lists`.`productId`, `comments`.`adminReply`,`orderlist`.`memberId`,`item_lists`.`orderId`,`product`.`productName`,`product`.`companyId`,`item_lists`.`itemListId`
            FROM `comments`
            LEFT JOIN `item_lists` 
            ON  `comments`.`itemId` =`item_lists`.`productId`
            LEFT JOIN `product` 
            ON  `comments`.`itemId` =`product`.`productId`
            LEFT JOIN `orderlist` 
            ON  `item_lists`.`orderId` =`orderlist`.`orderId` 
            WHERE `product`.`companyId` =   ?  ";

            if($p != ""){
                $sql.= "AND `{$p}` LIKE '%{$_GET['search']}%' 
                        AND `status` LIKE '%{$_GET['replyStatus']}%'                 
                        AND `rating` LIKE '%{$_GET['commentRating']}%' ";
            }    

            if($c==''){
                $sql.= "ORDER BY `id` ASC";
            }elseif($s=='1'){
            $sql.= "ORDER BY `$c` ASC";
            }else{
            $sql.= "ORDER BY  `$c` DESC";
            }


            $arrParam = [$_SESSION['Id']];
           

            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

      
            if( $stmt->rowCount() > 0){
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo '<div class="my-3"><p>共'.count($arr).'筆資料</p></div>';
                for( $i = 0 ; $i < count($arr) ; $i++ ){
            ?>
                <tr>
                    <td class="border">
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['id']; ?>" />
                    </td>
                    <td class="border"><?php echo $arr[$i]['itemListId'] ?></>
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
                    <td class="border"><?php echo $arr[$i]['updated_at'] ?></td>
                    <td class="border">
                    <input type="button" onclick="location.href='./comments.php?id=<?php echo $arr[$i]['id']; ?>'" value="編輯回覆">
                    <input type="button" onclick="if(confirm('是否確認刪除這些資料')) location.href='./comment_delete.php?id=<?php echo $arr[$i]['id']; ?>'"  value="單筆刪除" >
                    </td>
                    
                </tr>
            <?php
                }
            }else{
            ?>
                <tr>
                    <td class="border" colspan="10">沒有資料</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td  class="memberborder" colspan="10">
                <?php
                    if($page > 1){
                        echo '<a href=editcomment.php?page="'.($page-1).'">上一頁|</a>　';
                    }
                    for( $i = 1 ; $i <= $totalPages ; $i++){?>

                        <a href="?page=<?= $i ?>"> <?= $i ?> </a>　

                <?php } 
                    if($page < $totalPages){
                        echo '<a href=editcomment.php?page='.($page+1).'>|下一頁</a>';
                    }
                
                ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <!-- <input type="submit" name="smb" value="多筆刪除"> -->
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