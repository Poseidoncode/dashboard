<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

    $sql2 = "SELECT `imgId`, `productImgs`, `created_at`, `updated_at`
            FROM `multiple_imgs`
            WHERE `productId` = ?
            ORDER BY `imgId` ASC";
    $stmt2 = $pdo->prepare($sql2);
    
    $arrParam2 = [ isset($_GET['productId'])?(int)$_GET['productId']:(int)$_POST['productId']];
         
    
    $stmt2->execute($arrParam2);
    if($stmt2->rowCount() > 0) {
        $arr2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);?>
    <div class="d-flex justify-content-center">   
    <?php
        for($i = 0; $i < count($arr2); $i++) {
    ?>
        <div class="mx-2">
        <input class="checkbox" type="checkbox" name="chk[]" value="<?php echo $arr2[$i]['imgId']; ?>" />
        <br/>
        <img class="previous_images" src="../images/productImgs/<?php echo $arr2[$i]['productImgs'] ?>">
        </div>
    <?php
    }       
    ?>
    </div> 
    <button type="button" name="smb_delete" id="deleteImgs"  data-productId="<?php echo (isset($_GET['productId'])?(int)$_GET['productId']: (int)$_POST['productId']); ?>">刪除</button>
    <?php
    }else{
        // print_r($stmt2->rowCount());
        echo "尚未上傳圖檔";
    }
?>