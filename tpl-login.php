<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
       body{
        font-family:"微軟正黑體";
        background: url(images/logo/5c4b72c08a29aef249da9070a8b69943.jpg) no-repeat ;
        background-size:cover;
        /* background-color:#e1dcd9; */
    }

    .nav-height{
        height:65px;
    }
    .nav-font{
        font-size:20px;
        color:#32435f;
    }
    .row-height{
        height:100%;
    }

    .box{
      width:200px;
      /* height:auro; */
      background-color:#e1dcd9; 
      box-shadow:0 0 20px grey, 0 0 30px white;
    }

    .icon{
        width:200px; 
        height:200px; 
        border-radius: 50%;;
        background-color: white;
        margin-top:50px;
    }

    .border {
        border: 5px solid white;
    }
    .w200px {
        width: 200px;
    }

    .alert_text {
        color: red;
    }
    img.itemImg {
        width: 250px;
    }
    img.payment_type_icon{
        width: 50px;
    }
    img.previous_images{
        width: 100px;
    }
    input#files{
        display: none;
    }
    .bg-color1{
        background-color:#8f8681;
    }

    /* Chrome, Firefox, Opera, Safari 10.1+ */
    ::placeholder,
    .form-control::placeholder {
        color: gray;
        opacity: 1;
    /* Firefox */
    }

    /* Internet Explorer 10-11 */
    :-ms-input-placeholder,
    .form-control::-ms-input-placeholder {
        color: red;
    }

    /* Microsoft Edge */
    ::-ms-input-placeholder,
    .form-control::-ms-input-placeholder {
      color: red;
    }
     
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }


    </style>
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.3/examples/floating-labels/floating-labels.css" rel="stylesheet">

</head>
  <body>
    <!-- <nav class="navbar navbar-dark fixed-top bg-color1 flex-md-nowrap p-0 shadow nav-height">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index.php">
        <img src="../images/logo/location-on-map.png" width="30" height="30" class="d-inline-block align-top" alt="">
        文青地圖 
        </a>
  
    </nav>
   -->

   <?php 
   require_once('tpl/header.php');
    ?>
    
      <form class="form-signin my-2 my-md-0 box" name="myForm" method="post" action="./login.php">
          <div class="text-center mb-4">
            <img class="mb-4" src="./images/logo/location-on-map.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">文青地圖</h1>
            <a href="#">體驗，遇見更好的自己</a>
          </div>
        
          <div class="form-label-group">
            <input type="text" id="inputAccount" name="username" value="" class="form-control" placeholder="帳號" required autofocus>
            <!-- <label for="inputEmail"  class="text-white mx-3"></label> -->
          </div>
        
          <div class="form-label-group">
            <input type="password"  name="pwd" value="" id="inputPassword" class="form-control" placeholder="密碼" required>
            <label for="inputPassword" class="text-white mx-3"></label>
          </div>
        
          <div class="checkbox mb-3">       
            <label class="text-white mx-1">買家        
              <input class="form-control " type="radio" name="identity" value="member" checked />
            </label>
            <label class="text-white mx-1">賣家
              <input class="form-control " type="radio" name="identity" value="company" />
            </label>
            <label style="margin-left: 215px;">
              <input type="checkbox" value="remember-me">記住帳號
            </label>
          </div>
          <p class="alert_text"><?php 
                if ( isset($_GET['error_id']) && $_GET['error_id'] == 1){
                  echo "登入失敗";
                }
                if ( isset($_GET['error_id']) && $_GET['error_id'] == 2){
                  echo "請確實登入";
                }
          ?></p>
          <button class="btn btn-lg btn-light btn-block" type="submit">Sign in</button>
          <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2019</p>
          <!-- <p>管理帳：admin ; 密：admin ; 類別：賣家</p>
          <p>廠商帳：company ; 密：company ; 類別：賣家</p>
          <p>會員帳：member ; 密：member ; 類別：買家</p> -->
        </form>

  

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>