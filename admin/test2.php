<?php require_once('./templates/title.php'); ?>

<div class="container-fluid">
    <div class="row row-height">
        <nav class="col-md-2 col-12 d-none d-md-block bg-light sidebar ">
            <div class="sidebar-sticky py-4 text-center ">
                <div class="overflow-hidden mt-5 mx-auto shadow icon" id="member">
                    <img  style="object-fit: contain;width:100% ;height: 100%;" src="../images/logo/lab_logo.jpg">
                </div>
                <ul class="nav flex-column py-4 ">
                    <li class=" btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            廠商管理
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/company.php">Action</a>
                            <a class="dropdown-item" href="/company.php">Another action</a>
                            <a class="dropdown-item" href="/company.php">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/company.php">Separated link</a>
                        </div>
                    </li>

                    <li class="nav-item">    
                        <a class="nav-link active nav-font" href="./company.php">
                            廠商管理
                            
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active nav-font" href="./member.php">
                            會員管理
                            
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active nav-font" href="./editcomment.php">
                            評價管理
                            
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active nav-font" href="./map.php">
                            地圖管理
                            
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active nav-font" href="../article_column/article.php">
                            文章管理
                            
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link nav-font" href="./category.php">
                            編輯類別
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link nav-font" href="./paymentType.php">
                            付款方式
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link nav-font" href="./admin.php">
                            商品列表
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-font" href="./new.php">
                            新增商品
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-font" href="./orders.php">
                            訂單一覽
                        </a>
                    </li>
                    <li onclick="myFunction()" class="nav-item markrting">
                        <a class="nav-link nav-font" href="./coupon.php">
                            行銷管理
                        </a>
                        <ul class="show">
                            <li><a href="">1</a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">1</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 col-1 py-5 px-4">

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
    

    
