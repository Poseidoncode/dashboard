<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//SQL搜尋語法:取得 member 資料表總筆數
$sqlTotal = "SELECT count(1) FROM `map` ";

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
    .button {
        background-color: #8f8681; 
        border: none;
        color: white;
        padding: 6px 18px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 15px;
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
<h3>商品地圖列表</h3>
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
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./map.php'" value="商品地圖列表">
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./map_info.php'" value="景點地圖列表">
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./insert_newmap.php'" value="新增地圖">

<form name="myForm2" method="GET"  action="map.php">
    <table class="">
        <tr class="">  
            <td>
                <select name="map_search" id="">
                    <option value="" seclected>全部</option>
                    <option value="map`.`mapId">地圖編號</option>
                    <option value="`.`companyId">廠商編號</option>
                    <option value="product`.`productName">商品名稱</option>
                    <option value="category`.`categoryName">商品類別</option>
                    <option value="productAddress">商品地址</option>
                </select>
                <input class="input " type="text" name="search">
            </td>
            <td><input  class="btn-mainColor btn btn-sm " type="submit" value="搜尋"></td>
          
        </tr>
        <tr>
            
        </tr>   
    </table>

</form>



<form name="myForm" class="myForm" method="POST" action="./maps_delete.php" > 
            <label>
                <input type="checkbox" name="CheckAll" value="核取方塊" id="CheckAll" />
                全選/全不選</label>
    <table class="table table-striped border_article">
        <thead class="thead-mainColor">
            <tr> 
            <th class="border">勾選</th>
                <th class="border linkcolor">
                <?php
                if($s!=1 and $c == 'mapId'){
                ?>
                    <a href="./map.php?c=mapId&amp;s=1&map_search=<?php echo $_GET['map_search']?>&search=<?php echo $_GET['search']?>">地圖編號</a><span class="tri_up"></span>
                <?php
                }else if($s!=2 and $c == 'mapId'){
                ?>
                    <a href="./map.php?c=mapId&amp;s=2&map_search=<?php echo $_GET['map_search']?>&search=<?php echo $_GET['search']?>">地圖編號</a><span class="tri_down"></span>
                <?php
                }else{
                ?>
                    <a href="./map.php?c=mapId&amp;s=1&map_search=<?php echo $_GET['map_search']?>&search=<?php echo $_GET['search']?>">地圖編號</a>
                <?php
                 }
                ?>  
                </th>
                <th class="border linkcolor">
                <?php
                if($s!=1 and $c == 'companyId'){
                ?>
                    <a href="./map.php?c=companyId&amp;s=1&map_search=<?php echo $_GET['map_search']?>&search=<?php echo $_GET['search']?>">廠商編號</a><span class="tri_up"></span>
                <?php
                }else if($s!=2 and $c == 'companyId'){
                ?>
                    <a href="./map.php?c=companyId&amp;s=2&map_search=<?php echo $_GET['map_search']?>&search=<?php echo $_GET['search']?>">廠商編號</a><span class="tri_down"></span>
                <?php
                }else{
                ?>
                 <a href="./map.php?c=companyId&amp;s=1&map_search=<?php echo $_GET['map_search']?>&search=<?php echo $_GET['search']?>">廠商編號</a>
                <?php
                 }
                ?>               
                </th>
                <th class="border linkcolor">
                <?php
                if($s!=1 and $c == 'productId'){
                ?>
                    <a href="./map.php?c=productId&amp;s=1&map_search=<?php echo $_GET['map_search']?>&search=<?php echo $_GET['search']?>">商品編號</a><span class="tri_up"></span>
                <?php
                }else if($s!=2 and $c == 'productId'){
                ?>
                    <a href="./map.php?c=productId&amp;s=2&map_search=<?php echo $_GET['map_search']?>&search=<?php echo $_GET['search']?>">商品編號</a><span class="tri_down"></span>
                <?php
                }else{
                ?>
                    <a href="./map.php?c=productId&amp;s=1&map_search=<?php echo $_GET['map_search']?>&search=<?php echo $_GET['search']?>">商品編號</a>
                <?php
                 }
                ?>                                         
                </th>
                <th class="border">商品名稱</th>
                <th class="border">商品類別</th>
                <th class="border">商品地址</th>
                <!-- <th class="border">地圖上層編號</th> -->
                <th class="border">更新時間</th>
                <th class="border">功能</th>
            </tr>
        </thead>


        <tbody>
            <?php
            if(isset($_GET['map_search'])){
                $p=$_GET['map_search'];
            }else{
                $p ='';
            }

            $sql = "SELECT `map`.`mapId`, `map`.`productId`,`product`.`companyId`, `map`.`mapParentId`, `map`.`created_at`, `map`.`updated_at`,`product`.`productId`,`product`.`productAddress`,`product`.`productName`,`product`.`categoryId`,`company`.`companyId`,`category`.`categoryName`
            FROM `map` 
            LEFT JOIN `product` 
            ON  `map`.`productId` =`product`.`productId`
            LEFT JOIN `map_info` 
            ON  `map`.`mapId` =`map_info`.`map_infoId`
            LEFT JOIN `company` 
            ON  `product`.`companyId` =`company`.`companyId`
            LEFT JOIN `category` 
            ON  `product`.`categoryId` =`category`.`categoryId`";

            if($p != ""){
                $sql.= "WHERE `{$p}` LIKE '%{$_GET['search']}%'";
            }           
             if($c==''){
                 $sql.= "ORDER BY `map`.`updated_at` ASC";
             }elseif($s=='1'){
                $sql.= "ORDER BY `map`.`$c` ASC";
            }else{
                $sql.= "ORDER BY  `map`.`$c` DESC";
            }


            $arrParam = [($page - 1) * $numPerPage, $numPerPage];
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            if( $stmt->rowCount() > 0){
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for( $i = 0 ; $i < count($arr) ; $i++ ){
            ?>
                <tr>
                    <td class="border">
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['mapId']; ?>" />
                    </td>
                    <td class="border"><?php echo $arr[$i]['mapId'] ?></>
                    <td class="border"><?php echo $arr[$i]['companyId'] ?></>
                    <td class="border"><?php echo $arr[$i]['productId'] ?></>
                    <td class="border"><?php echo $arr[$i]['productName'] ?></>
                    <td class="border"><?php echo $arr[$i]['categoryName'] ?></>
                    <td class="border"><?php echo $arr[$i]['productAddress'] ?></>
                    <!-- <td class="border"><?php echo $arr[$i]['mapParentId'] ?></td> -->
                    <td class="border"><?php echo $arr[$i]['updated_at'] ?></td>
                    <td class="border">
           
                    <input class="btn-mainColor btn btn-sm " type="button" onclick="if(confirm('是否確認刪除這些資料'))location.href='./map_delete.php?mapId=<?php echo $arr[$i]['mapId']; ?>'" value="單筆刪除"></a>
                    </td>
                </tr>
            <?php
                }echo ' <tr><td colspan="">共'.count($arr).'筆資料</td><td colspan="8"></td>';
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

    <input class="btn-mainColor btn btn-sm my-3" type="submit" onclick="confirm('是否確認刪除這些資料')" value="多筆刪除">
  
 
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