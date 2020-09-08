<div class="container" id="comment_reply">

<?php
require_once('../db.inc.php'); 

if(isset($_GET['id'])){

    //SQL 敘述
    $sql = "SELECT `comment_replyContent`, `created_at`, `updated_at`
            FROM `comment_reply`
            WHERE `id` = ? 
            ORDER BY `created_at` DESC ";

    //查詢分頁後的商品資料
    $stmt = $pdo->prepare($sql);
    $arrParam = [ $_GET['id'] ];
    $stmt->execute($arrParam); 



    //若商品項目個數大於 0，則列出商品
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="row h5">【歷史回覆紀錄】</div>

    <?php 
        for($i = 0; $i < count($arr); $i++) {
    ?>
        <div class="row">
            <div class="media replyRecord-box  my-1">
                <div class="media-body ">
                    <p>回覆時間: <?php echo $arr[$i]["created_at"]; ?></p>
                    <p>回覆內容: <?php echo nl2br($arr[$i]["comment_replyContent"]); ?></p>
                    <!-- <p>更新時間: <?php echo $arr[$i]["updated_at"]; ?></p> -->
                </div>
            </div>
        </div>
<?php
        } 
    }  
}

?>
</div>
