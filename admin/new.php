<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 

//建立種類列表
function buildTree($pdo, $parentId = 0){
    $sql = "SELECT `categoryId`, `categoryName`, `categoryParentId`
            FROM `category` 
            WHERE `categoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            if($arr[$i]['categoryParentId'] == 0){
                echo "<optgroup label='".$arr[$i]['categoryName']."'>";
            }else{
                echo "<option value='".$arr[$i]['categoryId'];
                echo "'>";
                echo $arr[$i]['categoryName'];
                echo "</option>";
            }
            buildTree($pdo, $arr[$i]['categoryId']); 
            if($arr[$i]['categoryParentId'] == 0){
                echo "</optgroup>";
            } 
        }
    }
}
?>


<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>新增商品</h3>
<form name="myForm" enctype="multipart/form-data" method="POST" action="add.php">
<table class="border_b table">
    <thead>
        <tr>
            <th class="border_b">商品名稱</th>
            <th class="border_b">商品照片</th>
            <th class="border_b">商品價格</th>
            <th class="border_b">商品數量</th>
            <th class="border_b">商品地址</th>
            <th class="border_b">商品種類</th>
            <th class="border_b">商品結束日期</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="border_b px-0">
                <input type="text" name="productName" value="" maxlength="30"/>
            </td>
            <td class="border_b px-0" >
                <div id="preImg"></div>
                <input class="w200px" type="file" id="pre_img" id="pre_img" name="productImg" value="" />
            </td>
            <td class="border_b px-0">
                <input type="text" name="productPrice" value="" maxlength="11" size="10" />
            </td>
            <td class="border_b px-0">
                <input type="text" name="productAmount" value="" maxlength="3"  size="10" />
            </td>
            <td class="border_b px-0">
                <input type="text" name="productAddress" value="" maxlength="50" />
            </td>
            <td class="border_b px-0">
                <select name="categoryId">
                <?php buildTree($pdo, 0); ?>
                </select>
            </td>
            <td class="border_b px-0">
                <input type="datetime-local" name="productEndingDate" />
            </td>
            
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="border_b" colspan="7"><input type="submit" name="smb" value="新增"></td>
        </tr>
    </tfoot>
</table>
</form>
</body>
<script>
    function handleFileSelect(evt) {
        var files = evt.target.files;
        // console.log(files);
        if(files.length == 0){
            let preImg = document.getElementById('preImg');
            preImg.innerHTML="";
        }else{
            for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    var div = document.createElement('div');
                        div.innerHTML = [
                        '<img class="productImg m-2" src="', 
                        e.target.result,
                        '" title="', 
                        escape(theFile.name), 
                        '"/>'
                        ].join('');
                        let preImg = document.getElementById('preImg');
                        preImg.innerHTML="";
                        document.getElementById('preImg').insertBefore(div, null);
                        
                };
                })(f);

                reader.readAsDataURL(f);
                // console.log(f);   
            }
        }
    }
    document.getElementById('pre_img').addEventListener('change', handleFileSelect, false);
    
</script>
</html>