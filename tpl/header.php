<nav class="navbar navbar-dark fixed-top bg-color1 flex-md-nowrap p-0 shadow nav-height">
<!-- <div class="nav-height bg-color1 d-flex flex-column flex-md-row align-items-center border-bottom shadow-sm p-0 "> -->
    <!-- <h5 class="my-0 mr-md-auto font-weight-normal "> -->
    <nav  class="navbar-brand col-sm-2 col-md-1 mr-0  mr-md-auto">    
        <a  class="0 text-white " href="index.php">
        <img src="./images/logo/location-on-map.png" width="30" height="30" class="d-inline-block align-top" alt="">
        文青地圖
        </a>
    </nav>

    <nav lass="my-2 col-md-2 my-md-0 mr-md-3 ">
        <select id="inputState" class="form-control">
            <option selected>請選擇地區</option>
            <option>台北市</option>
            <option>新北市</option>
            <option>台北市</option>
            <option>台北市</option>
        </select>
    </nav>
    <nav class="my-2 col-md-2 my-md-0 mr-md-3 ">
        <input id="party" type="date" name="partydate" placeholder="請選擇日期" value="" class="form-control"> 
    </nav>
    <nav class="my-2 col-md-2 my-md-0 mr-md-3">
        <input class="form-control form-control-dark w-100" type="text" placeholder="想尋找什麼體驗呢" aria-label="Search">   
    </nav>
    <?php
    ?>

    <nav class="my-2 col-md-4 my-md-0 mr-md-3" style="max-width:30%;">
        <a class="p-2 text-white" href="./map.php">地圖探索</a>  
        <a class="p-2 text-white" href="./itemList.php">商品一覽</a>
        <a class="p-2 text-white" href="./article.php">文章專欄</a>
        <a class="p-2 text-white" href="./itemTracking.php">
            <span>願望清單</span>
            (<span id="wishItemNum">
                
                <?php
                if(isset($_SESSION["Id"])){
                    $sqlItemTracking = "SELECT count(1) FROM `wishlist` WHERE `memberId` = '{$_SESSION["Id"]}'";
                    $countItemTracking = $pdo->query($sqlItemTracking)->fetch(PDO::FETCH_NUM)[0];
                    echo $countItemTracking;
                }else echo 0?>
                
        </span>)
        </a>
        <a class="p-2 text-white" href="./myCart.php">
            <span>購物車</span>
            (<span id="cartItemNum">
            <?php 
            if(isset($_SESSION["cart"])) {
                echo count($_SESSION["cart"]);
            } else {
                echo 0;
            }
            ?>
        </span>)
        </a>

        <!-- <?php if(isset($_SESSION["username"])) { ?>
        <a class="p-2 text-white" href="./comments.php">會員中心</a>
        <?php } ?> -->

    </nav>

        <?php  
            if(isset($_SESSION["identity"]) && $_SESSION["identity"] === 'company'){
                if($_SESSION["name"] === 'admin'){
        ?>
        
                    <a class="btn btn-outline-light" style="margin-right: 20px;" href="./admin/info.php">管理員後台</a>
        
        <?php
                }else{
        ?>
                    <a class="btn btn-outline-light" style="margin-right: 20px;" href="./company/admin2.php">廠商後台</a>
        <?php   
                }
            }elseif(isset($_SESSION["identity"]) && $_SESSION["identity"] === 'member'){
        ?>
                <a class="btn btn-outline-light" style="margin-right: 20px;" href="./comments.php">會員中心</a>
        <?php
            }
        ?>

        <?php if(!isset($_SESSION["username"])){ ?>
            <a class="btn btn-outline-light" href="./register.php">註冊</a>
        <?php } else { ?>
            <span style="color:white;margin-right:10px;"><?php echo $_SESSION["name"] ?> 您好 </span>
        <?php } ?>


        <?php require_once("login.php") ?>
    </nav>
 
</nav>
<div class="my-5"></div>