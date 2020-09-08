<style>
body {
  background: #EEE;
  font-family: helvetica, arial, sans-serif;
  margin: 0;
  padding: 0;
  margin-top: 20px;
}

#scissor {
	width: 300px;
	height: 46px;
	margin: 0 auto;
}

#cut-out {
  width: 300px;  
  height: 200px;
  margin: 0px auto 20px auto;
  border: 10px dashed black;
  font-size: 25px;
  font-weight: bold;
  text-align: center;
  padding-top:30px;
}

#cut-out p {
	margin-top: 136px;
}
</style>

<?php
header("Content-Type: text/html; chartset=utf-8");

//引入判斷是否登入機制
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//SQL 敘述
$sql = "INSERT INTO `coupon` 
        (`couponId`, `discountName`, `discountCode`, `discountPercent`, `quantity`, `startTime`, `endTime`) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";


//繫結用陣列
$arr = [
    $_POST['couponId'],
    $_POST['discountName'],
    trim($_POST['discountCode']),
    $_POST['discountPercent'],
    $_POST['quantity'],
    $_POST['startTime'],
    $_POST['endTime']
];

$pdo_stmt = $pdo->prepare($sql);
$pdo_stmt->execute($arr);
if($pdo_stmt->rowCount() === 1) {
    header("Refresh: 3; url=./coupon.php");
    echo '<div id="scissor"><img src="https://i.imgur.com/PRgxt.png"></div>';
    echo '<div id="cut-out">新增成功<br><br>New Coupon!</新增成功></div>';

} else {
    header("Refresh: 3; url=./coupon.php");
    echo "新增失敗";
}