<?php
session_start();
require_once("./checkSession.php");
require_once('./db.inc.php');
require_once('./tpl/tpl-html-head.php'); 
require_once('./tpl/header.php');
// require_once("./tpl/func-buildTree.php");
// require_once("./tpl/func-getRecursiveCategoryIds.php");
?>
 
<div class="container-fluid">
    <div class="row row-height">
        <nav class="col-md-2 col-12 d-none d-md-block bg-light sidebar ">
            <div class="sidebar-sticky py-4 text-center ">
                <div class="overflow-hidden mt-5 mx-auto shadow icon" id="member">
                    <img  style="object-fit: contain;width:100% ;height: 100%;" src="images/logo/lab_logo.jpg">
                </div>
                <ul class="nav flex-column py-4 ">
                    <li class="nav-item">
                        <a class="nav-link active nav-font" href="">
                            個人資料
                            
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active nav-font" href="check.php">
                            訂單資訊
                            
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active nav-font" href="comments.php">
                            我的評價
                            
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active nav-font" href="">
                            個人文章
                            
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active nav-font" href="">
                            願望清單  
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link nav-font" href="">
                            我的問題
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link nav-font" href="./category.php">
                            優惠券
                        </a>
                    </li>
        
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 col-1 p-5">
