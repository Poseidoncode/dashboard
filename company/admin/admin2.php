<?php
require_once('./checkAdmin.php');
require_once('../db.inc.php'); 


$companyId = (int)$_SESSION['Id'];
$sqlTotal = "SELECT count(1) FROM `product`
             WHERE `companyId` = $companyId"; 
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0]; 
$numPerPage = 5; 
$totalPages = ceil($total/$numPerPage); 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$page = $page < 1 ? 1 : $page; 

$sqlTotalCatogories = "SELECT count(1) FROM `category`
                       WHERE `companyId` = $companyId";

$totalCatogories = $pdo->query($sqlTotalCatogories)->fetch(PDO::FETCH_NUM)[0];
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>商品列表</h3>
<hr>
<?php 

if($totalCatogories > 0) {
?>
<form name="myForm" entype= "multipart/form-data" method="POST" action="delete.php">
    <table class="border_b table">
        <thead>
            <tr>
                <th class="border_b">
                    <input class="checkbox" type="checkbox" id="chkAll">
                    <br/>
                    全選
                </th>
                <th class="border_b">商品名稱</th>
                <th class="border_b">商品照片</th>
                <th class="border_b w70px">商品價格</th>
                <th class="border_b w70px">商品數量</th>
                <th class="border_b w120px">商品地址</th>
                <th class="border_b w70px">商品種類</th>
                <th class="border_b">商品結束日期</th>
                <th class="border_b">新增時間</th>
                <th class="border_b">更新時間</th>
                <th class="border_b w120px" >功能</th>
            </tr>
        </thead>
        <tbody>
        <?php
        
        $sql = "SELECT `product`.`productId`, `product`.`productName`, `product`.`productImg`, `product`.`productPrice`, 
                        `product`.`productAmount`, `product`.`productAddress`, `product`.`productEndingDate`,`product`.`categoryId`, `product`.`created_at`, `product`.`updated_at`,
                        `category`.`categoryName`
                FROM `product` LEFT JOIN `category`
                ON `product`.`categoryId` = `category`.`categoryId`
                WHERE `product`.`companyId` = $companyId
                ORDER BY `product`.`productId` ASC 
                LIMIT ?, ? ";

      
        $arrParam = [($page - 1) * $numPerPage, $numPerPage];

        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arr); $i++) {
        ?>
            <tr>
                <td class="border_b">
                    <input class="checkbox" type="checkbox" name="chk[]" value="<?php echo $arr[$i]['productId']; ?>" />
                </td>
                <td class="border_b"><?php echo $arr[$i]['productName']; ?></td>
                <td class="border_b">
                <?php
                if($arr[$i]['productImg'] != Null){
                    echo '<img class="productImg" src="../images/products/'.$arr[$i]['productImg'].'" />';
                }
                ?>
                </td>
                <td class="border_b"><?php echo $arr[$i]['productPrice']; ?></td>
                <td class="border_b"><?php echo $arr[$i]['productAmount']; ?></td>
                <td class="border_b"><?php echo $arr[$i]['productAddress']; ?></td>
                <td class="border_b"><?php echo $arr[$i]['categoryName']; ?></td>
                <td class="border_b"><?php echo $arr[$i]['productEndingDate']; ?></td>
                <td class="border_b"><?php echo $arr[$i]['created_at']; ?></td>
                <td class="border_b"><?php echo $arr[$i]['updated_at']; ?></td>
                <td class="border_b">
                    <a href="./edit.php?productId=<?php echo $arr[$i]['productId']; ?>">詳細編輯</a>
                    <br/>
                    
                </td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td class="border_b" colspan="11">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="border_b" colspan="11">
                <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                    <a href="?page=<?=$i?>"><?= $i ?></a>
                <?php } ?>
                </td>
            </tr>
            
            <?php if($total > 0) { ?>
            <tr>
                <td class="border_b" colspan="11"><input type="submit" name="smb" value="刪除"></td>
            </tr>
            <?php } ?>
            
        </tfoot>
    </table>
</form>
<?php 
} else { 
    //引入尚未建立商品種類的文字描述
    
    require_once('./templates/noCategory.php');
}?>
</body>
<script>
    document.getElementById('chkAll').addEventListener("click",function(){
        let chk = document.getElementsByName('chk[]');
        if(this.checked){
            for(let i = 0; i < chk.length; i++){
                chk[i].checked = true;
            }
        }else {
            for(let i = 0; i < chk.length; i++){
                chk[i].checked = false;
            }
        }
    })
</script>
</html>