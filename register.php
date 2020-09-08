<?php
session_start();
require_once('./db.inc.php');
require_once('./tpl/tpl-html-head.php'); 
require_once('./tpl/header.php');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
<script>

$(function(){

    $('#inputUserImg').change(function(){
        var src=URL.createObjectURL(this.files[0])
        $('#ipv').attr('src',src)
        $('#ipv').css('width',"200px")

    })

    $('#')

})
</script>




<div class="container">
<a class="btn btn-info" style="margin-right: 20px;" href="#">會員註冊</a>
<a class="btn btn-light" style="margin-right: 20px;" href="./register_company.php">廠商註冊</a>
    <hr/>
    <form name="myForm" method="POST" action="./addUser.php" enctype="multipart/form-data">
        <div class="form-row">
            
            <div class="form-group col-md-6">
                <img id="ipv" src="" >
                <label for="inputUserImg" >上傳頭像</label><br>
                <input type="file"  id="inputUserImg" name="memberImg" style="margin-top:5px;" >
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputUsername">登入帳號(聯絡信箱)</label>
                <input type="text" class="form-control" id="inputUsername" name="memberMail" placeholder="範例:xz123@xxx" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==7){
                //     echo "<p style='color:red;fontweight:600;'>請輸入登入信箱</p>";
                // }?>               
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputPassword">登入密碼</label>
                <input type="password" class="form-control" id="inputPassword" name="memberPwd" placeholder="請輸入密碼" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==8){
                //     echo "<p style='color:red;fontweight:600;'>請輸入登入密碼</p>";
                // }?>   
            </div>
            <!-- <div class="form-group col-md-4">
                <label for="inputPassword">再次輸入密碼</label>
                <input type="password" class="form-control" id="inputPasswordchk" name="memberPwdchk" placeholder="再次輸入密碼" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==9){
                //     echo "<p style='color:red;fontweight:600;'>請再次輸入密碼</p>";
                // }?>   
            </div> -->
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputName">姓名</label>
                <input type="text" class="form-control" id="inputName" name="memberName" placeholder="請輸入您的姓名" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==1){
                //     echo "<p style='color:red;fontweight:600;'>請輸入您的姓名</p>";
                // }?>   
            </div>

            <div class="form-group">
                <label for="inputGender">性別</label>
                <select id="inputGender" name="memberGender" class="form-control">
                    <option value="男" selected>男</option>
                    <option value="女">女</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputName">身分證</label>
                <input type="text" class="form-control" id="inputName" name="memberIdentity" placeholder="請輸入您的身分證" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==5){
                //     echo "<p style='color:red;fontweight:600;'>請輸入身分證</p>";
                // }?>  
            </div>
            <div class="form-group ">
                <label for="inputBirthday">生日</label>
                <input type="date" class="form-control" id="inputBirthday" name="memberBirth" placeholder="請輸入出生年月日" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==3){
                //     echo "<p style='color:red;fontweight:600;'>請輸入出生年月日</p>";
                // }?> 
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="inputPhoneNumber">手機號碼</label>
                <input type="text" class="form-control" id="inputPhoneNumber" name="memberPhone" placeholder="請輸入手機電話號碼" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==4){
                //     echo "<p style='color:red;fontweight:600;'>請輸入手機電話號碼</p>";
                // }?> 
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress ">住址</label>
                <input type="text" class="form-control" id="inputAddress" name="memberAddress" placeholder="請輸入住址">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==6){
                //     echo "<p style='color:red;fontweight:600;'>請輸入住址</p>";
                // }?> 
            </div>
        </div>
        <?php
        if(isset($_GET['err']) && $_GET['err']==1){
            echo "<h2 style='color:red;'>請輸入完整資料</h2>";
        }elseif(isset($_GET['err']) && $_GET['err']==2){
            echo "<h2 style='color:red;'>註冊失敗,請重新確認</h2>";
        }elseif(isset($_GET['complete']) && $_GET['complete']==1){
            echo "<h2 style='color:red;'>註冊成功,請重新登入</h2>";
        }
        ?>
        <button type="submit" class="btn btn-primary">註冊</button>
    </form>
  
</div>

<?php
require_once('./tpl/footer.php');
require_once('./tpl/tpl-html-foot.php'); 
?>