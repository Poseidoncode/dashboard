<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />

<h3>地圖編輯管理</h3>
<hr>
<input class="backButton" type="button" value="返回列表" onclick="location.href='./map.php'">

<form name="myForm" enctype="multipart/form-data" method="POST" action="update_map.php">
    <table class="border">
    <thead>
            <tr>
                <th class="border">廠商編號</th>
                <th class="border">商品編號</th>
                <th class="border">地圖上層編號</th>
                <th class="border">建立時間</th>
                <th class="border">更新時間</th>
            </tr>
        </thead>
        <tbody>
     
        <?php

        //SQL 敘述
        $sql = "SELECT `map`.`mapId`, `map`.`productId`,`map`.`companyId`, `map`.`mapParentId`, `map`.`created_at`, `map`.`updated_at`,`product`.`productId`,`product`.`productAddress`,`company`.`companyId`
        FROM `map` 
        LEFT JOIN `product` 
        ON  `map`.`productId` =`product`.`productId`
        LEFT JOIN `company` 
        ON  `map`.`companyId` =`company`.`companyId`
        WHERE `map`.`mapId` = ? ";
              
        $arrParam = [
            (int)$_GET['mapId']
        ];

        //查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        //資料數量大於 0，則列出相關資料
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        ?>
            <tr>
                 <td class="border">
                    <input type="text" name="companyId" value="<?php echo $arr['companyId']; ?>" maxlength="11" />
                </td>
                <td class="border">
                    <input type="text" name="productId" value="<?php echo $arr['productId']; ?>" maxlength="11" />
                </td>
                <td class="border">
                    <input type="text" name="mapParentId" value="<?php echo $arr['mapParentId']; ?>" maxlength="50" />
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
            <tr>
                <td class="border" colspan="7"><input type="submit" name="smb" value="更新"></td>
            </tr>
        </tfoo>
    </table>
    <input type="hidden" name="mapId" value="<?php echo (int)$_GET['mapId']; ?>">
</form>
</body>
</html>