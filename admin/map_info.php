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
<h3>景點地圖列表</h3>
<hr>

<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./map.php'" value="商品地圖列表">
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./map_info.php'" value="景點地圖列表">
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./insert_newmap.php'" value="新增地圖">

<form name="myForm2" method="GET"  action="map_info.php">
    <table class="">
        <tr class="">  
            <td>
                <select name="map_info_search" id="">
                    <option value="" seclected>全部</option>
                    <option value="map_infoId">景點編號</option>
                    <option value="map_infoName">景點名稱</option>
                    <option value="map_infoAddress">景點地址</option>
                    <option value="map_infoPhone">景點電話</option>
                </select>
                <input class="input " type="text" name="search">
            </td>
            <td><input  class="btn-mainColor btn btn-sm " type="submit" value="搜尋"></td>          
        </tr>
    </table>
</form>

<form name="myForm" class="myForm" method="POST" action="./maps_info_delete.php" > 
            <label>
                <input type="checkbox" name="CheckAll" value="核取方塊" id="CheckAll" />
                全選/全不選</label>
    <table class="table table-striped border_article">
        <thead class="thead-mainColor">
            <tr> 
                <th class="border w-2">勾選</th>
                <th class="border w-3">景點編號</th>
                <th class="border w-4">景點名稱</th>
                <th class="border w-4">景點圖片</th>
                <th class="border w-4">景點地址</th>
                <th class="border w-3">景點電話</th>
                <th class="border w-3">更新時間</th>
                <th class="border w-4">功能</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if(isset($_GET['map_info_search'])){
                $p=$_GET['map_info_search'];
            }else{
                $p ='';
            }

            $sql = "SELECT `map_infoId`, `map_infoName`, `map_infoImg`, `map_infoAddress`, `map_infoPhone`,`updated_at`
            FROM `map_info` ";
            if($p != ""){
                $sql.= "WHERE `{$p}` LIKE '%{$_GET['search']}%'";
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
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['map_infoId']; ?>" />
                    </td>
                    <td class="border"><?php echo $arr[$i]['map_infoId'] ?></td>
                    <td class="border"><?php echo $arr[$i]['map_infoName'] ?></td>
                    <td class="border"><?php
                    if($arr[$i]['map_infoImg'] != Null){
                        echo '<img class="productImg" src="../images/map_infoImg/'.$arr[$i]['map_infoImg'].'" />';
                    }?>
                    </td>
                    <td class="border"><?php echo $arr[$i]['map_infoAddress'] ?></td>
                    <td class="border"><?php echo $arr[$i]['map_infoPhone'] ?></td>
                    <td class="border"><?php echo $arr[$i]['updated_at'] ?></td>
                    <td class="border"> 
                    <input class="btn-mainColor btn btn-sm " type="button" onclick="location.href='./editmap_info.php?map_infoId=<?php echo $arr[$i]['map_infoId']; ?>'" value="編輯"></a>
                    <input class="btn-mainColor btn btn-sm " type="button" onclick="if(confirm('是否確認刪除這些資料'))location.href='./map_info_delete.php?map_infoId=<?php echo $arr[$i]['map_infoId']; ?>'" value="單筆刪除"></a>
                    </td>
                </tr>
            <?php
                }echo ' <tr><td>共'.count($arr).'筆資料</td><td colspan="7"></td></tr>';
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

                        <a href="?page=<?= $i ?>"> <?= $i ?> </a>　

                <?php } 
                    if($page < $totalPages){
                        echo '<a class="btn-mainColor btn btn-sm"href="editcomment.php?page="'.($page+1).'>|下一頁</a>';
                    }
                
                ?>
                </td>
            </tr>
        </tfoot>

  </table>  

    <input  class="btn-mainColor btn btn-sm my-3" type="submit"  onclick="confirm('是否確認刪除這些資料')" value="多筆刪除"></a>
    <!-- <input type="submit" name="smb" value="多筆刪除"> -->
    </td>
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

<script>
    function handleFileSelect(evt) {
        var files = evt.target.files;
        var x = evt.target.id;
        // console.log(x);
        if(x == "pre_imgs"){
            let preImgs = document.getElementById('preImgs');
            preImgs.innerHTML='';
        }else{
            let preImg = document.getElementById('preImg');
            <?php if($arr['productImg'] != Null){ ?>
                preImg.innerHTML='<img class="productImg" src="../images/map_infoImg/<?php echo $arr['map_infoImg']?>" />';
            <?php }else { ?>
                preImg.innerHTML='尚未上傳圖檔';
            <?php }?>
        }
        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    var div = document.createElement('div');
                    if(x =="pre_img"){
                        div.innerHTML = [
                        '<img class="map_infoImg m-2" src="', 
                        e.target.result,
                        '" title="', 
                        escape(theFile.name), 
                        '"/>'
                        ].join('');
                        let preImg = document.getElementById('preImg');
                        preImg.innerHTML='';
                        document.getElementById('preImg').insertBefore(div, null);
                    }else if(x == "pre_imgs"){
                        
                        div.innerHTML = [
                        '<img class="preImgs p-2" src="', 
                        e.target.result,
                        '" title="', 
                        escape(theFile.name), 
                        '"/>'
                        ].join('');
                        document.getElementById('preImgs').insertBefore(div, null);
                    }
                };
            })(f);

            reader.readAsDataURL(f);
        }
    }
    document.getElementById('pre_img').addEventListener('change', handleFileSelect, false);
    document.getElementById('pre_imgs').addEventListener('change', handleFileSelect, false);

    $(document).on("click", "button#deleteImgs", function(e){
        let btn = $(this);
        let cb = $("input[name='chk[]']:checked");
        let cb_value = [];
        for(let i = 0; i < cb.length; i++){
            cb_value.push($(cb[i]).val()) ;
        }
        
        $.ajax({
            method: "POST",
            url: "./deleteMultipleImgs.php",
            dataType: "json",
            data: { 
                map_infoId: btn.attr('data-map_infoId'), 
                chk: cb_value
            }
        })
        .done(function( json ) {
            alert(json.info);
            $("td#imgsDeleteArea").empty();
            $("td#imgsDeleteArea").load('./imgsDeleteArea.php',{"productId" : btn.attr('data-map_infoId')});
        })
        .fail(function( jqXHR, textStatus ) {
            console.log(cb_value);
            alert( "Request failed: " + textStatus );
            // window.location.reload()
        });
    });
</script>