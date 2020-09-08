<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//建立種類列表
function buildTree($pdo, $parentId = 0, $cId){
    $companyId = (int)$_SESSION['Id'];
    $sql = "SELECT `categoryId`, `categoryName`, `categoryParentId`,`companyId`
            FROM `category` 
            WHERE `companyId` = $companyId
            AND `categoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            echo "<option value='".$arr[$i]['categoryId'];
            if ($arr[$i]['categoryId'] == $cId){
                echo "' selected";
            }else{
                echo "'";
            }
            echo ">";
            echo $arr[$i]['categoryName'];
            echo "</option>";
            buildTree($pdo, $arr[$i]['categoryId'],$cId); 
        }
    }
}
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<?php
    //SQL 敘述
    $sql = "SELECT `product`.`productId`, `product`.`productName`, `product`.`productImg`, `product`.`productPrice`, `product`.`productAmount`, `product`.`productAddress`, `product`.`productEndingDate`,`product`.`productContent`,`product`.`categoryId`, `product`.`created_at`, `product`.`updated_at`,`category`.`categoryName`
            FROM `product` LEFT JOIN `category`
            ON `product`.`categoryId` = `category`.`categoryId`
            WHERE `productId` = ? ";

    $arrParam = [
        (int)$_GET['productId']
    ];

    //查詢
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
?>
<hr />
<!-- 顯示當前商品名字 -->
<h3><?php echo $arr['productName']?>&lt;商品詳細&gt;</h3> 

<form name="myForm" enctype="multipart/form-data" method="POST" action="update.php">
    <table class="border_b table">
        <thead>
            <tr>
                <th class="border_b">商品名稱</th>
                <th class="border_b">商品主圖預覽</th>
                <th class="border_b">商品價格</th>
                <th class="border_b w120px">商品數量</th>
                <th class="border_b w300px">商品地址</th>
                <th class="border_b">商品種類</th>
                <th class="border_b ">商品結束時間</th>
            </tr>
        </thead>
        <tbody>
        
        <?php
        //資料數量大於 0，則列出相關資料
        if($stmt->rowCount() > 0) {
            // $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        ?>
            <tr>
                <td class="border_b ">
                    <input type="text" name="productName" value="<?php echo $arr['productName']; ?>" />
                </td>
                <td class="border_b">
                    <div id="preImg">
                    <?php 
                    if($arr['productImg'] != Null){
                    echo '<img class="productImg" src="../images/products/'.$arr['productImg'].'" />';
                    }else {
                        echo "尚未上傳圖檔";
                    }
                    ?>
                    </div>
                    <input class="w200px" type="file" id="pre_img" name="productImg" value="" />
                </td>
                <td class="border_b">
                    <input type="text" name="productPrice" value="<?php echo $arr['productPrice']; ?>" maxlength="11" size="8"/>
                </td>
                <td class="border_b">
                    <input type="text" name="productAmount" value="<?php echo $arr['productAmount']; ?>" maxlength="3" size="8"/>
                </td>
                <td class="border_b px-0">
                    <input type="text" name="productAddress" value="<?php echo $arr['productAddress']; ?>" size="30"/>
                </td>
                <td class="border_b">
                    <select name="categoryId">
                    <?php buildTree($pdo, 0, $arr['categoryId'] ); ?>
                    </select>
                </td>
                <td class="border_b">
                    <input type="datetime-local" name="productEndingDate" value="<?php echo date('Y-m-d\TH:i:s',strtotime($arr['productEndingDate'])); ?>"  />
                </td>
            </tr>
            <tr>
                <td class="border_b font-weight-bold" >商品詳細描述</td>
                <td colspan="6" >
                    <textarea style="resize:none" name="productContent" cols="135%" rows="20" ><?php echo $arr['productContent']; ?></textarea>
                </td>
            </tr>
                <td class="border_b font-weight-bold" >商品圖編輯</td>
                <td id="imgsDeleteArea" class="border_b" colspan="6">

                <?php require_once('./imgsDeleteArea.php'); ?>     

                </td>
            <tr>
            </tr>
            <tr>
                <td class="border_b font-weight-bold ">新增商品圖預覽</td>
                <td class="border_b" colspan="6">
                
                <div class="d-flex flex-wrap w1050px mx-auto my-1" id="preImgs">
                </div>
                <input class="w200px " type="file" id="pre_imgs" name="productImgs[]" value="" multiple/>
            </td>
            </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="border_b" colspan="7"><input type="submit" name="smb" value="更新"></td>
                </tr>
            </tfoot>
            </table>
            <input type="hidden" name="productId" value="<?php echo (int)$_GET['productId']; ?>">
            <p>上次更新時間：<?php echo $arr['updated_at']; ?>&nbsp;&nbsp;&nbsp;&nbsp;新增時間：<?php echo $arr['created_at']; ?></p>
        <?php
        } else {
        ?>
                <tr>
                    <td colspan="9">沒有資料</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="border_b" colspan="7"><input type="submit" name="smb" value="更新"></td>
                </tr>
            </tfoot>
        </table>
        <input type="hidden" name="productId" value="<?php echo (int)$_GET['productId']; ?>">
        <?php
        }
        ?>        
</form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
                preImg.innerHTML='<img class="productImg" src="../images/products/<?php echo $arr['productImg']?>" />';
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
                        '<img class="productImg m-2" src="', 
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
                productId: btn.attr('data-productId'), 
                chk: cb_value
            }
        })
        .done(function( json ) {
            alert(json.info);
            $("td#imgsDeleteArea").empty();
            $("td#imgsDeleteArea").load('./imgsDeleteArea.php',{"productId" : btn.attr('data-productId')});
        })
        .fail(function( jqXHR, textStatus ) {
            console.log(cb_value);
            alert( "Request failed: " + textStatus );
            // window.location.reload()
        });
    });
</script>

</html>