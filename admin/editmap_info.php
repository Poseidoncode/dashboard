<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />

<h3>地圖編輯管理</h3>
<hr>
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./map.php'" value="商品地圖列表">
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./map_info.php'" value="景點地圖列表">
<input class="btn-secondary btn btn-sm mb-3" type="button"  onclick="location.href='./insert_newmap.php'" value="新增地圖">

<form name="myForm" enctype="multipart/form-data" method="POST" action="updatemap_info.php">
    <table class="table table-striped border_article">
    <thead class="thead-mainColor">
            <tr>
                <th class="border">景點編號</th>
                <th class="border">景點名稱</th>
                <th class="border">景點圖片</th>
                <th class="border">景點電話</th>
                <th class="border">景點地址</th>
                <th class="border">建立時間</th>
                <th class="border">更新時間</th>
            </tr>
        </thead>
        <tbody>
     
        <?php

        //SQL 敘述
        $sql = "SELECT `map_infoId`,`map_infoName`, `map_infoImg`, `map_infoAddress`, `map_infoPhone`,`created_at`,`updated_at`
        FROM `map_info` 
        WHERE `map_infoId` = ? ";
              
        $arrParam = [
            (int)$_GET['map_infoId']
        ];

        //查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        //資料數量大於 0，則列出相關資料
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        ?>
            <tr>
                <td class="border"><?php echo $arr['map_infoId']; ?></td>
                <td class="border">
                    <input type="text" name="map_infoName" value="<?php echo $arr['map_infoName']; ?>" maxlength="20" />
                </td>
                <td class="border_b">
                    <div id="imgbox">
                    <?php 
                    if($arr['map_infoImg'] != Null){
                    echo '<img class="map_infoImg productImg" src="../images/map_infoImg/'.$arr['map_infoImg'].'" />';
                    }else {
                        echo "尚未上傳圖檔";
                    }
                    ?>
                    </div>
                    <input class="w200px" type="file" id="map_infoImg" name="map_infoImg" value="" />
                </td>
                <td class="border">
                    <input  type="text" name="map_infoPhone" value="<?php echo $arr['map_infoPhone']; ?>" maxlength="50" />
                </td>
                <td class="border">
                    <input class="w300px" type="text" name="map_infoAddress" value="<?php echo $arr['map_infoAddress']; ?>" maxlength="50" />
                </td>
                <td class="border"><?php echo $arr['created_at']; ?></td>
                <td class="border"><?php echo $arr['updated_at']; ?></td>
            </tr>
        <?php
        } else {
        ?>
            <tr>
                <td colspan="7">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <input type="hidden" name="map_infoId" value="<?php echo (int)$_GET['map_infoId']; ?>">
            <tr>
                <td class="border" colspan="7"><input  class="btn-mainColor btn btn-sm my-3" type="submit" name="smb" value="更新"></td>
            </tr>
        </tfoo>
    </table>
    
</form>
</body>
</html>