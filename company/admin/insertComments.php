<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

$sql = "UPDATE `comments` SET `status` = ?, `adminReply` =? WHERE `id` = ?";
$stmt = $pdo->prepare($sql);
$arrParam = [
    '已回覆', 
    $_POST['content'],
    $_POST["id"]
];
$stmt->execute($arrParam);
if($stmt->rowCount() > 0) {
    header("Refresh: .5; url=./comments.php?id={$_POST['id']}");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "新增成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    // exit();
} else {
    header("Refresh: .5; url=./comments.php?id={$_POST['id']}");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "新增失敗";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}


$sql1 = "INSERT `comment_reply` SET `comment_replyContent` = ?, `id`=?";
$stmt1 = $pdo->prepare($sql1);
$arrParam1 = [
    $_POST['content'],
    $_POST['id']
];
$stmt1->execute($arrParam1);

?>







