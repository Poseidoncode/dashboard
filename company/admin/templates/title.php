<html>
<head>
    <meta charset="UTF-8">
    <title>我的 PHP 程式</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <style>
    body{
        font-family:"微軟正黑體";
        background-color:#e1dcd9;
    }

    .nav-height{
        height:65px;
    }
    .nav-font{
        font-size:20px;
        color:#32435f;
    }
   .nav-name{
        border-bottom:2px solid #8f8681;
    }
    .dropright .dropdown-toggle::after {
        margin-left: 1.5em;}
    .row-height{
        height:100%;
    }

    .icon{
        width:90px; 
        height:90px; 
        border-radius: 50%;;
        background-color: white;
        margin-top:50px;
    }
    .icon-img{
        object-fit: cover;
        width:100% ;
        height: 100%;
    }

    .border {
        border: 5px solid white;
    }

    .w70px {
        width:70px;
    }
    
    .w120px {
        width: 120px;
    }

    .w200px {
        width: 200px;
    }

    .w250px {
        width:250px;
    }

    .w300px {
        width:300px;
    }
    .w1050px{
        width:1050px;
    }
    .w100{
        width:100%
    }

    img.productImg {
        width: 200px;
        height:200px;
        object-fit: contain;
    }
    img.preImgs {
        width: 150px;
        height:150px;
        object-fit: contain;
    }
    .flex-grow{
        flex-grow:1;
    }
    img.payment_type_icon{
        width: 50px;
    }
    img.previous_images{
        width: 100px;
        margin-bottom: 10px;
    }
    /* #files{
        display: none;
    } */
    .bg-color1{
        background-color:#8f8681;
    }
    
    .commentMemberImg{
        width:200px;
        height:200px;
        /* border-radius:50%; */
        overflow:hidden;
        object-fit:cover;
        margin-right:30px;
    }
    .memberImg2{
        width:100%;
        height:100%;
    }
    
    ul {
        list-style-type:none;
    }

    .checkbox{
        width: 20px;
        height: 20px;
        margin: 5px;
    }

    .table {
        text-align: center;
    }

    .table td,.table thead th {
        vertical-align: middle;
    }
    .border_b{
        border:1px solid #aaa !important;
    }

    .commentTextArea{
        width:400px;
        height:200px;
    }
    .fontSize{
        font-size:18px;
    }
    .table .thead-dark th {
    background-color: #81776e;
    }
    .replyRecord-box{
        width:970px;
        border:1px solid white;
    }
    .backButton{
        background-color: #8f8681; 
        border: none;
        color: white;
        padding: 6px 18px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 15px;
        margin-bottom:10px;
    }
    </style>
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>


<body>
    <nav class="navbar navbar-dark fixed-top bg-color1 flex-md-nowrap p-0 shadow nav-height">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0 " href="../../index.php">
        <img src="../images/logo/location-on-map.png" width="30" height="30" class="d-inline-block align-top" alt="">
        文青地圖 管理者平台
        </a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="../../logout.php?logout=1">登出</a>
            </li>
        </ul>
    </nav>
  