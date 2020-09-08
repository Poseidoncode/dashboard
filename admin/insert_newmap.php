<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />

<h3>新增地圖</h3>
<hr>
<!-- <input class="btn-mainColor btn btn-sm my-3"class="backButton" type="button" value="返回列表" onclick="location.href='./map.php'"> -->
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./map.php'" value="商品地圖列表">
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./map_info.php'" value="景點地圖列表">
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./insert_newmap.php'" value="新增地圖">


<form name="mapForm1" enctype="multipart/form-data" method="POST" action="addmap.php">
    <table class="border">
        <thead>
                <tr>
                    <th class="border h5 py-2">【新增商品地圖】 </th>                   
                </tr>
                <tr>
                    <td class="border">
                    商品編號: <input class="w300px"  type="text" name="productId" value="" maxlength="11" />
                     </td>              
                </tr>
        </thead>
        <tfoot>
            <tr>
                <td class="border" colspan="5"><input class="btn-mainColor btn btn-sm my-3" type="submit" name="smb" value="新增"></td>
            </tr>
        </tfoot>
    </table>
</form>


<form name="mapForm2" enctype="multipart/form-data" method="POST" action="addmap_info.php">
    <table class="border">
        <thead class=""> 
                 <tr>
                    <th class="border h5 py-2">【新增景點地圖】 </th>                  
                </tr>
                <tr>   
                <th>
                     <div id="imgbox"></div>
                     </th>                            
                </tr>
                <tr>
                    <td class="border">
                    景點相片: <input class="w300px" type="file" id="pre_img" name="map_infoImg" value="" maxlength="11" />                  
                     </td>                          
                </tr>
                <tr>
                    <td class="border">
                    景點名稱: <input class="w300px" type="text" name="map_infoName" value="" maxlength="11" />
                     </td>              
                </tr>
                <tr>
                    <td class="border ">
                    景點地址: <input class="w300px" type="text" name="map_infoAddress" value="" maxlength="11" />
                     </td>              
                </tr>
                <tr>
                    <td class="border">
                    景點電話: <input class="w300px" type="text" name="map_infoPhone" value="" maxlength="11" />
                     </td>              
                </tr>
        </thead>
        <tfoot>
            <tr>
                <td class="border" colspan="5"><input class="btn-mainColor btn btn-sm my-3" type="submit" name="smb" value="新增"></td>
            </tr>
        </tfoot>
    </table>
</form>
<div id="imgbox"></div> 
</body>

<script>
    function handleFileSelect(evt) {
        var files = evt.target.files;
        // console.log(files);
        if(files.length == 0){
            let preImg = document.getElementById('imgbox');
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
                        let preImg = document.getElementById('imgbox');
                        preImg.innerHTML="";
                        document.getElementById('imgbox').insertBefore(div, null);
                        
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