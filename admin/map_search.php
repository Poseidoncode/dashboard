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
    </style>
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>

<hr>
<h3>地圖管理頁面</h3>
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

<input type="button" value="返回列表" onclick="location.href='./map.php'">



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


<form name="myForm2" method="POST"  action="map_search.php">
    <table class="search">
        <tr>  
            <td>
                <label for="commentOther">其它：</label>
                <select name="map_search" id="">
                    <option value="" seclected>全部</option>
                    <option value="map`.`mapId">地圖編號</option>
                    <option value="company`.`companyId">廠商編號</option>
                    <option value="product`.`productName">商品名稱</option>
                    <option value="category`.`categoryName">商品類別</option>
                    <option value="product`.`productAddress">商品地址</option>
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
    <a  class="button" href="./insert_newmap.php">新增資料</a>
    <label>
        <input type="checkbox" name="CheckAll" value="核取方塊" id="CheckAll" />
        全選</label>
    <input type="submit"  class="button" value="勾選刪除" onclick= "return confirm('是否確認刪除這些資料')">
    <table class="tb">
    <thead>
    <tr>
                <th class="border">勾選</th>
                <th class="border linkcolor">
                <?php
                if($s!=1 and $c == 'mapId'){
                 echo '<a href="./map_search.php?c=mapId&amp;s=1">地圖編號</a><span class="tri_up"></span>';
                }else if($s!=2 and $c == 'mapId'){
                 echo '<a href="./map_search.php?c=mapId&amp;s=2">地圖編號</a><span class="tri_down"></span>';
                }else{
                 echo '<a href="./map_search.php?c=mapId&amp;s=1">地圖編號</a>';
                 }
                ?>  
                </th>
                <th class="border linkcolor">
                <?php
                if($s!=1 and $c == 'companyId'){
                 echo '<a href="./map_search.php?c=companyId&amp;s=1">廠商編號</a><span class="tri_up"></span>';
                }else if($s!=2 and $c == 'companyId'){
                 echo '<a href="./map_search.php?c=companyId&amp;s=2">廠商編號</a><span class="tri_down"></span>';
                }else{
                 echo '<a href="./map_search.php?c=companyId&amp;s=1">廠商編號</a>';
                 }
                ?>               
                </th>
                <th class="border linkcolor">
                <?php
                if($s!=1 and $c == 'productId'){
                 echo '<a href="./map_search.php?c=productId&amp;s=1">商品編號</a><span class="tri_up"></span>';
                }else if($s!=2 and $c == 'productId'){
                 echo '<a href="./map_search.php?c=productId&amp;s=2">商品編號</a><span class="tri_down"></span>';
                }else{
                 echo '<a href="./map_search.php?c=productId&amp;s=1">商品編號</a>';
                 }
                ?>                     
                </th>
                <th class="border">商品名稱</th>
                <th class="border">商品類別</th>
                <th class="border">商品地址</th>
                <th class="border">地圖上層編號</th>
                <th class="border">更新時間</th>
                <th class="border">功能</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $p=$_POST['map_search'];


            $sql = "SELECT `map`.`mapId`, `map`.`productId`,`map`.`companyId`, `map`.`mapParentId`, `map`.`created_at`, `map`.`updated_at`,`product`.`productId`,`product`.`productAddress`,`product`.`productName`,`product`.`categoryId`,`company`.`companyId`,`category`.`categoryName` 
            FROM `map`
            LEFT JOIN `product` 
            ON  `map`.`productId` =`product`.`productId`
            LEFT JOIN `company` 
            ON  `map`.`companyId` =`company`.`companyId`
            LEFT JOIN `category` 
            ON  `product`.`categoryId` =`category`.`categoryId`";
            
            if($p !== ""){
             $sql.= "WHERE `{$p}` LIKE '%{$_POST['search']}%'";
            }           
            if($c==''){
                $sql.= "ORDER BY `map`.`updated_at` ASC";
            }elseif($s=='1'){
               $sql.= "ORDER BY `map`.`$c` ASC";
           }else{
               $sql.= "ORDER BY  `map`.`$c` DESC";
           }        
           

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
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['mapId']; ?>" />
                    </td>
                    <td class="border"><?php echo $arr[$i]['mapId'] ?></>
                    <td class="border"><?php echo $arr[$i]['companyId'] ?></>
                    <td class="border"><?php echo $arr[$i]['productId'] ?></>
                    <td class="border"><?php echo $arr[$i]['productName'] ?></>
                    <td class="border"><?php echo $arr[$i]['categoryName'] ?></>
                    <td class="border"><?php echo $arr[$i]['productAddress'] ?></>
                    <td class="border"><?php echo $arr[$i]['mapParentId'] ?></td>
                    <td class="border"><?php echo $arr[$i]['updated_at'] ?></td>
                    <td class="border">
                    <a  class="button" href="./editmap.php?mapId=<?php echo $arr[$i]['mapId']; ?>">編輯</a>
                    <a  class="button" href="./map_delete.php?mapId=<?php echo $arr[$i]['mapId']; ?>" onclick= "return confirm('是否確認刪除這些資料')">單筆刪除</a>
                    </td>
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