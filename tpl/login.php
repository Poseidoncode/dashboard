<span class="ml-3 mr-3"> | </span>
<?php if(!isset($_SESSION["username"])){ ?>
    <!-- <form class="form-inline my-2 my-md-0" name="myForm" method="post" action="./tpl/tpl-login.php"> --> 
        <!-- <label class="text-white mx-3">帳號:</label>
        <input class="form-control" type="text" name="username" value="" maxlength="50" />
        <label class="text-white mx-3">密碼:</label>
        <input class="form-control" type="password" name="pwd" value="" maxlength="50" /> -->
        <!-- <label class="text-white mx-1">買家</label>
        <input class="form-control mx-1" type="radio" name="identity" value="users" checked />
        <label class="text-white mx-1">賣家</label>
        <input class="form-control mx-1" type="radio" name="identity" value="admin" /> -->
        <!-- <input class=" " type="submit" value="登入" /> -->
        <a class="btn btn-outline-light" href="tpl-login.php">登入</a>
    <!-- </form> -->
<?php } else { ?>
<a class="pr-3 text-white" href="./logout.php?logout=1">登出</a>
<?php } ?>