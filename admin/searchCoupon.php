<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>我的 PHP 程式</title>
</head>
<body>



<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<h1 class="mt-5">搜尋結果</h1>
<div class="container">
<?php
   $conn = mysqli_connect($db_host,$db_username,$db_password,$db_name);
   if(isset($_POST['submit-search'])){
       $search = mysqli_real_escape_string($conn, $_POST['search']);

       $sql = "SELECT * FROM coupon WHERE discountName LIKE '%$search%' OR discountCode LIKE '%$search%'";
       $result = mysqli_query($conn, $sql);
       $queryResult = mysqli_num_rows($result);

       if($queryResult>0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<div>
            <h3>".$row['discountName']."</h3>
            <p>".$row['discountCode']."</p>
            </div>";
         }  
       }else{
       echo "找不到相關內容";
       }

   }
?>
</div>
    
</body>
</html>