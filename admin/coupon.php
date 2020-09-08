<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//SQL 敘述: 取得 students 資料表總筆數
$sqlTotal = "SELECT count(1) FROM `coupon`";

//取得總筆數
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];

//每頁幾筆
$numPerPage = 10;

// 總頁數
$totalPages = ceil($total/$numPerPage); 

//目前第幾頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>優惠券列表</title>
    <style>
    .border {
        border: 1px solid;
    }
    .w200px {
        width: 200px;
    }
    .couponborder {
        border: 1px solid #aaa;
    }
    .w200px {
        width: 200px;
    }
    .tb{
        width: 100%;
    }
    .myForm > table > tbody > tr > td,.myForm > table > thead > tr > th{
        padding:12px;
        text-align:center;
    }

    .search td{
        /* border:1px solid black; */
        padding:5px 10px;
    }

    .myForm > table > tfoot > tr > td{
        text-align:center;
    }

    .input{
        width:300px;
    }
    tfoot{
        font-size: 20px;
        line-height: 40px;
    }
    input[type="text"] {
    width: 300px;
    }
    </style>
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>優惠券列表</h3>
<hr />
<form action="coupon_search.php" method="POST">
    <input type="text" name="search" placeholder="行銷名稱/折扣代碼 "/>
    <input type="submit" name="submit-search" value="搜尋" />
</form>
<!-- 折扣碼管理頁面 - <a href="./coupon.php">折扣碼一覽</a> | <a href="./couponRel.php">會員折扣碼配置</a> | <a href="./newCoupon.php">新增折扣碼</a>| <a href="./newRel.php">新增會員折扣碼</a> -->
<form class="myForm" name="myForm" method="POST" action="deleteCouponId.php">
    <table class="table table-striped border_article">
        <thead class="thead-mainColor">
            <tr>
                <th class="couponborder">
                <input id="chkAll"type="checkbox">
                選擇</th>
                <th class="couponborder">折扣碼ID</th>
                <th class="couponborder">行銷名稱</th>
                <th class="couponborder">折扣代碼</th>
                <th class="couponborder">折扣數</th>
                <th class="couponborder">數量</th>
                <th class="couponborder">折扣開始時間</th>
                <th class="couponborder">折扣結束時間</th>
                <th class="couponborder">建立時間</th>
                <th class="couponborder">更新時間</th>
                <th class="couponborder">功能</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `couponId`, `discountName`, `discountCode`, `discountPercent`,`quantity`, `startTime`, `endTime`, `created_at`, `updated_at`
                FROM `coupon` 
                ORDER BY `couponId` ASC 
                LIMIT ?, ? ";

        //設定繫結值
        $arrParam = [($page - 1) * $numPerPage, $numPerPage];

        //查詢分頁後的學生資料
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        //資料數量大於 0，則列出所有資料
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arr); $i++) {
        ?>
            <tr>
                <td class="couponborder">
                    <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['couponId']; ?>" />
                </td>
                <td class="couponborder"><?php echo $arr[$i]['couponId']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['discountName']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['discountCode']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['discountPercent']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['quantity']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['startTime']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['endTime']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['created_at']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['updated_at']; ?></td>
                </td>
                <td class="couponborder">
                    <a class="btn btn-mainColor btn-sm" href="./editCoupon.php?editId=<?php echo $arr[$i]['couponId']; ?>">編輯</a>
                    <a class="btn btn-mainColor btn-sm" href="./deleteCoupon.php?deleteCouponId=<?php echo $arr[$i]['couponId']; ?>">刪除</a>
                </td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td class="border" colspan="10">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="couponborder" colspan="11">
                <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                    <a class="btn btn-mainColor btn-sm" href="?page=<?= $i ?>"><?= $i ?></a>
                <?php } ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="submit" name="smb" value="多筆刪除" onclick="return confirm('是否確認刪除這些資料');">
</form>


<!-- <div class="container">
  <?php
    $conn = mysqli_connect($db_host,$db_username,$db_password,$db_name);
    $sql="SELECT * FROM coupon";
    $result = mysqli_query($conn,$sql);
    $queryResults = mysqli_num_rows($result);

    if($queryResults > 0){
      while($row = mysqli_fetch_assoc($result)){
         echo "<div>
         <h3>".$row['discountName']."</h3>
         <p>".$row['discountCode']."</p>
         </div>";
      }
    }
  ?>
</div> -->
<script>
    document.getElementById('chkAll').addEventListener("click",function(){
        let chk = document.getElementsByName('chk[]');
        if(this.checked){
            for(let i = 0; i < chk.length; i++){
                chk[i].checked = true;
                console.log(chk[i].checked);
            }
        }else {
            for(let i = 0; i < chk.length; i++){
                chk[i].checked = false;
            }
        }
    })
    
</script>
</body>
</html>