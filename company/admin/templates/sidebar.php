<div class="container-fluid">
    <div class="row row-height">
        <nav class="col-md-1 col-12 d-none d-md-block bg-light sidebar ">
            <div class="sidebar-sticky my-2 py-5 text-center ">
                <div class="overflow-hidden mt-5 mb-4 mx-auto shadow icon" id="member">
            <?php
                $sql = "SELECT `companyLogo`
                FROM `company` 
                WHERE `companyName` = ?";

                $arrParam = [$_SESSION['name']];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($arrParam);
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);                           
            ?>                            
                <img  class="icon-img" src="../images/company/<?php echo $arr[0]['companyLogo']  ?>">
                </div>      
                <div class="nav-name pb-3 nav-name">        
                <p class="fontSize font-weight-bold" >                    
                    <?php 
                        if( $_SESSION['username'] !=="admin"){
                           echo $_SESSION['name']; }
                    ?>
                    </p>
                    <a class="" href="./info.php">廠商資訊</a>
                </div> 
                <ul class="nav flex-column  ">
                    <li class=" btn-group dropright ">
                        <div  class="btn btn-light dropdown-toggle py-3 fontSize" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">    
                            商品管理
                        </div>
                        <div class="dropdown-menu w200px">
                            <a class="dropdown-item py-2 fontSize" href="./admin2.php">商品列表</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2 fontSize" href="./new.php">新增商品</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item fontSize" href="./category.php">商品類別</a>   
                            <!-- <div class="dropdown-divider"></div>
                            <a class="dropdown-item fontSize" href="./category.php">Something else here</a> -->
                        </div> 
                    </li>
                    <li class=" btn-group dropright ">
                         <div  class="btn btn-light dropdown-toggle py-3 fontSize" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            訂單管理
                        </div>
                        <div class="dropdown-menu w200px">
                            <a class="dropdown-item py-2 fontSize" href="./orders.php">訂單列表</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2 fontSize" href="./company.php">新增訂單</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item fontSize" href="./paymentType.php">付款方式</a>
                        </div> 
                    </li>
                    <li class=" btn-group dropright">
                         <div  class="btn btn-light dropdown-toggle py-3 fontSize" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            評價管理 
                        </div>                           
                        <div class="dropdown-menu w200px">
                            <a class="dropdown-item py-2 fontSize" href="./editcomment.php?replyStatus=&commentRating=&editcomment_search=productName&search=">評價列表</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2 fontSize" href="./insert_newcomment.php">新增評價</a>
                            <!-- <div class="dropdown-divider"></div> -->
                            <!-- <a class="dropdown-item py-2 fontSize" href="./company.php">Something else here</a>    -->
                        </div> 
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-11 ml-sm-auto col-lg-11 col-1 py-5 px-4">

        <script>
        $(document).ready(function () {
            let navMenu = $('li.nav-item.markrting')
            let navContainer = $('ul.show')

            navMenu.click(function () {
                navContainer.toggleClass("nav-show-menu")
                // alert("123");
            })
        })
        </script>
    

    
