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
    <title>會員優惠券列表</title>
    <style>
    .couponborder {
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
    .myForm td , .myForm th{
        padding: 12px;
        text-align:center;
    }

    .search td{
        /* border:1px solid black; */
        padding:5px 10px;
    }

    .input{
        width:300px;
    }
    tfoot{
        font-size: 20px;
        line-height: 40px;
    }
    body > div > div > main > form.myForm.table.table-striped.border_article > input[type=submit] {
    float: left;
    margin-top: 20px;
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
<h3>會員優惠券列表</h3>
<hr />
<form action="couponRel_search.php" method="POST">
    <input type="text" name="search" placeholder="行銷名稱/折扣代碼/會員代碼"/ size="30">
    <input type="submit" name="submit-search" value="搜尋" />
</form>
<!-- 折扣碼管理頁面 - <a href="./coupon.php">折扣碼一覽</a> | <a href="./couponRel.php">會員折扣碼配置</a> | <a href="./newCoupon.php">新增折扣碼</a>| <a href="./newRel.php">新增會員折扣碼</a> -->
<form class="myForm table table-striped border_article" name="myForm" method="POST" action="deleteRelId.php">
    <table class="border">
        <thead class="thead-mainColor">
            <tr>
                <th class="couponborder">
                <input id="chkAll"type="checkbox">
                選擇
                </th>
                <!-- <th class="border">流水號ID</th> -->
                <th class="couponborder">折扣碼ID</th>
                <th class="couponborder">會員代碼</th>
                <th class="couponborder">數量</th>
                <th class="couponborder">行銷名稱</th>
                <th class="couponborder">折扣代碼</th>
                <th class="couponborder">折扣數</th>
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
        $sql = "SELECT `coupon`.`couponId`, `coupon`.`discountName`, `coupon`.`discountCode`, `coupon`.`discountPercent`, `coupon`.`startTime`, `coupon`.`endTime`, `coupon`.`created_at`, `coupon`.`updated_at`,`rel_member_coupon`.`id`,`rel_member_coupon`.`memberId`,`rel_member_coupon`.`memberCouponNum`
                FROM `coupon`
                INNER JOIN `rel_member_coupon`
                ON `coupon`.`couponId` = `rel_member_coupon`.`couponId`
                ORDER BY `couponId`,`memberId` ASC 
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
                    <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['id']; ?>" />
                </td>
                <!-- <td class="border"><?php echo $arr[$i]['id']; ?></td> -->
                <td class="couponborder"><?php echo $arr[$i]['couponId']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['memberId']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['memberCouponNum']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['discountName']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['discountCode']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['discountPercent']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['startTime']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['endTime']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['created_at']; ?></td>
                <td class="couponborder"><?php echo $arr[$i]['updated_at']; ?></td>
                </td>
                <td class="couponborder">
                    <a class="btn btn-mainColor btn-sm" href="./editRel.php?editId=<?php echo $arr[$i]['id']; ?>">編輯</a>
                    <a class="btn btn-mainColor btn-sm" href="./deleteRel.php?deleteRelId=<?php echo $arr[$i]['id']; ?>">刪除</a>
                </td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td class="border" colspan="12">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="couponborder" colspan="12">
                <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                    <a class="btn btn-mainColor btn-sm" href="?page=<?= $i ?>"><?= $i ?></a>
                <?php } ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="submit" name="smb" value="多筆刪除" onclick="return confirm('是否確認刪除這些資料');">
</form>
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