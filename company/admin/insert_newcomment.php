<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />

<h3>新增評價</h3>
<hr>
<input class="backButton" type="button" value="返回列表" onclick="location.href='./editcomment.php'">

<form name="myForm" enctype="multipart/form-data" method="POST" action="addcomment.php">
    <table class="border">
                <tr>
                    <th class="border">商品ID: </th>
                    <td class="border">
                    <input type="text" name="itemId" value="" maxlength="11" />
                    </td>   
                </tr>
                 <tr>
                    <th class="border">評論內容: </th>
                    <td class="border">
                    <input class="commentTextArea" type="text" name="content" value="" maxlength="100" />
                </td>
                <td class="border">
             
            </tr>
            <tr>
                <th class="border">評論星等: </th>
                 <td>  
                    <select name="rating">
                            <option value="5" selected>5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                    </select>   
                </td>      
            </tr>
        <tfoot>
            <tr>
                <td class="border" colspan="5"><input type="submit" name="smb" value="新增"></td>
            </tr>
        </tfoot>
    </table>
</form>
</body>
</html>