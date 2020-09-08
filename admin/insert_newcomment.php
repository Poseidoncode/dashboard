<?php
require_once('./checkAdmin.php'); 
require_once('../db.inc.php'); 
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />

<h3>新增評價</h3>
<hr>

<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./editcomment.php'" value="評價列表">
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./insert_newcomment.php'" value="新增評價">

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
                    <textarea rows="15" cols="20" class="commentTextArea articleContent" type="text" name="content" value="" ></textarea>
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
                <td class="border" colspan="5"><input class="btn-mainColor btn btn-sm my-3"  type="submit" name="smb" value="新增"></td>
            </tr>
        </tfoot>
    </table>
</form>
</body>
</html>