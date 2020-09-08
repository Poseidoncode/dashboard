<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>查看評價與回覆</h3>
<hr>

<input class="btn-mainColor btn btn-sm my-3"  type="button" value="返回列表" onclick="location.href='./editcomment.php'">

<div class="container ">
<?php
if(isset($_GET['id'])){

    //SQL 敘述
    $sql = "SELECT `comments`.`id`, `comments`.`status`,`comments`.`content`,  `comments`.`rating`, `comments`.`itemId`, `comments`.`created_at`, `comments`.`updated_at`,`item_lists`.`productId`, `comments`.`adminReply`,`orderlist`.`memberId`,`item_lists`.`orderId`,`product`.`productName`,`item_lists`.`itemListId`
            FROM `comments`
            LEFT JOIN `item_lists` 
            ON  `comments`.`itemId` =`item_lists`.`productId`
            LEFT JOIN `product` 
            ON  `comments`.`itemId` =`product`.`productId`
            LEFT JOIN `orderlist` 
            ON  `item_lists`.`orderId` =`orderlist`.`orderId` 
            WHERE `id` = ? 
            ORDER BY `comments`.`created_at` DESC ";

    //查詢分頁後的商品資料
    $stmt = $pdo->prepare($sql);
    $arrParam = [ $_GET['id'] ];
    $stmt->execute($arrParam); 

    //若商品項目個數大於 0，則列出商品
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
?>
        <form name="myForm" method="POST" action="./insertComments.php">
           
              
                    <!-- <div class="commentMemberImg">
                    <img class="memberImg2  mr-3" src="../images/member/<?php echo $arr[$i]['memberImg'] ?>" />
                    </div> -->
                    <div class="row h5 font-weight-bold">【會員評論紀錄】-會員編號: <?php echo $arr[$i]["memberId"]; ?></div>
                        <div class="row">
                            <div class="media replyRecord-box  my-1">
                                <div class="media-body ">
                                <p>評論時間: <?php echo $arr[$i]["created_at"]; ?></p>
                                <p>評分: <?php echo $arr[$i]["rating"]; ?></p>
                                <p class=>評論內容:<div class="articleContent"> <?php echo nl2br($arr[$i]["content"]); ?></div></p>                                
                                <!-- <p>更新時間: <?php echo $arr[$i]["updated_at"]; ?></p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
        
 <hr>
           
            <div class="row"><?php require_once("commentReply_list.php"); ?></div>
        </form>
    <?php
        }
    }
} 
?>
</div>

 
<?php
require_once('../tpl/footer.php');
require_once('../tpl/tpl-html-foot.php'); 
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/custom.js"></script>
</body>
</html>
