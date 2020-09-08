<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<?php 
session_start();
require_once('./db.inc.php');
?>

<form name="test" id="testform" method="GET" action="test1.php">
    <label>text: </label>
    <textarea name="content" rows="15" cols="100" value=""></textarea>
    <input type="submit" name="smb" id="btn_insertComment_reply"  value="更新">
</form>
<!-- 
$sql2 = "SELECT `comment_replyContent`, `created_at`, `updated_at`
            FROM `comment_reply`
            WHERE `id` = ? 
            ORDER BY `created_at` DESC ";

    //查詢分頁後的商品資料
    $stmt2 = $pdo->prepare($sql2);
    $arrParam2 = [ $_GET['id'] ];
    $stmt2->execute($arrParam2); 


    //若商品項目個數大於 0，則列出商品
    if($stmt2->rowCount() > 0) {
        $arr = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
    ?> -->

<script>
$(document).on("click", "input#btn_insertComment_reply", function(){

    .done(function() {
        
        //動態新增評論元素
        $("div#comment_reply").prepend(`
        <div class="row">
            <div class="media">
                <div class="media-body">
                    <p>${json.data.comment_replyContent}</p>
                    <p>新增時間: ${json.data.created_at}</p>
                    <p>更新時間: ${json.data.updated_at}</p>
                </div>
            </div>
        </div>`);
    })
    .fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
    });
});
</script>

</body>
</html>


