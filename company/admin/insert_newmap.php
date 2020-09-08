<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />

<h3>新增地圖</h3>
<hr>
<input class="backButton" type="button" value="返回列表" onclick="location.href='./map.php'">

<form name="myForm" enctype="multipart/form-data" method="POST" action="addmap.php">
    <table class="border">
        <thead>
                <tr>
                    <th class="border">商品編號: </th>
                    <td class="border">
                    <input type="text" name="productId" value="" maxlength="11" />
                     </td>              
                </tr>
        </thead>
        <tbody>
            <tr>
                <th class="border">廠商編號: </th>
                <td class="border">
                    <input type="text" name="companyId" value="" maxlength="11" />
                </td>                 
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="border" colspan="5"><input type="submit" name="smb" value="新增"></td>
            </tr>
        </tfoot>
    </table>
</form>
</body>
</html>