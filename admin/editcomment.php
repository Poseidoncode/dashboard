<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//SQL搜尋語法:取得 member 資料表總筆數
$sqlTotal = "SELECT count(1) FROM `comments` ";

//取得總筆數
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];

//每頁幾筆
$numPerPage = 10;

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
    <input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./editcomment.php'" value="評價列表">
    <input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./insert_newcomment.php'" value="新增評價">

<form name="myForm2" method="GET"  action="editcomment.php">
<table class="">
<tr class="">
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
            <td><input class="btn-mainColor btn btn-sm " type="submit" value="搜尋"></td>
        </tr>
            
        </tr>   
    </table>

</form>

<form name="myForm" class="myForm" method="POST" action="./comments_delete.php" >     
    
    <label>
      <input type="checkbox" name="CheckAll" value="核取方塊" id="CheckAll" />
    全選/全不選</label>
    <!-- <label for="commentOther">功能：</label>
    <input type="button"  onclick="location.href='./insert_newcomment.php'" value="新增資料"> -->
    
    <table class="table table-striped border_article">
        <thead class="thead-mainColor">
            <tr>
                <th class="border w-2">勾選
                
                </th>
                <th class="border linkcolor w-2">
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
                <th class="border w-4">商品名稱</th>
                <th class="border w-2">會員ID</th>
                <th class="border w-10 ">評論內容</th>

                <th class="border linkcolor w-2">
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

                <th class="border linkcolor w-2">
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

                <th class="border linkcolor w-2">
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
                <th class="border w-3">功能</th>
            </tr>
        </thead>
        <tbody>
            <?php
      
            if(isset($_GET['editcomment_search']) ){
                $p=$_GET['editcomment_search'];
            }else{
                $p ='';
            }

            $sql = "SELECT `comments`.`id`, `comments`.`status`,`comments`.`content`, `comments`.`rating`, `comments`.`itemId`, `comments`.`updated_at`,`item_lists`.`productId`, `comments`.`adminReply`,`orderlist`.`memberId`,`item_lists`.`orderId`,`product`.`productName`,`item_lists`.`itemListId`,`product`.`companyId`
            FROM `comments`
            LEFT JOIN `item_lists` 
            ON  `comments`.`itemId` =`item_lists`.`productId`
            LEFT JOIN `product` 
            ON  `comments`.`itemId` =`product`.`productId`
            LEFT JOIN `orderlist` 
            ON  `item_lists`.`orderId` =`orderlist`.`orderId`";                               

            if($p != ""){
                $sql.= "WHERE `{$p}` LIKE '%{$_GET['search']}%' 
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


            $arrParam = [($page - 1) * $numPerPage, $numPerPage];
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

      
            if( $stmt->rowCount() > 0){
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // echo '<div class="my-3"><p>共'.count($arr).'筆資料</p></div>';
                for( $i = 0 ; $i < count($arr) ; $i++ ){
            ?>
                <tr>
                    <td class="border">
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['id']; ?>" />
                    </td>
                    <td class="border "><?php echo $arr[$i]['itemListId'] ?></>
                    <td class="border"><?php echo $arr[$i]['productName'] ?></>
                    <td class="border"><?php echo $arr[$i]['memberId'] ?></>
                    <td class="border articleContent"><?php echo $arr[$i]['content'] ?></td>
                    <td class="border"><?php echo $arr[$i]['rating'] ?></td>
                    <td class="border">
                        <?php if ($arr[$i]['status'] === "未回覆"){?>
                             <p class="redcolor">廠商尚<?php echo $arr[$i]['status']?></p>
                        <?php }else{ ?>
                              <p>廠商<?php echo $arr[$i]['status']?></p>
                        <?php }?>
                    </td>
                    <td class="border"><?php echo $arr[$i]['updated_at'] ?></td>
                    <td class="border">
                    <input class="btn-mainColor btn btn-sm " type="button" onclick="location.href='./comments.php?id=<?php echo $arr[$i]['id']; ?>'" value="查看評價與回覆">
                    <input class="btn-mainColor btn btn-sm " type="button" onclick="if(confirm('是否確認刪除這些資料')) location.href='./comment_delete.php?id=<?php echo $arr[$i]['id']; ?>'"  value="刪除評論" >
                    </td>
                    
                </tr>
            <?php
                } echo ' <tr ><td>共'.count($arr).'筆資料</td><td colspan="7"></td><td></td></tr>';
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
                        echo '<a class="btn-mainColor btn btn-sm"href="editcomment.php?page="'.($page-1).'">上一頁|</a>　';
                    }
                    for( $i = 1 ; $i <= $totalPages ; $i++){?>

                        <a class="btn-mainColor btn btn-sm"href="?page=<?= $i ?>"> <?= $i ?> </a>　

                <?php } 
                    if($page < $totalPages){
                        echo '<a class="btn-mainColor btn btn-sm"href="editcomment.php?page="'.($page+1).'>|下一頁</a>';
                    }
                
                ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <input class="btn-mainColor btn btn-sm " type="submit"  value="多筆刪除" onclick= "return confirm('是否確認刪除這些資料')">
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