<?php
session_start();
require_once('./db.inc.php');
require_once('./tpl/tpl-html-head.php'); 
require_once('./tpl/header.php');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
<script>

$(function(){

    $('#companyLogo').change(function(){
        var src=URL.createObjectURL(this.files[0])
        $('#ipv').attr('src',src)
        $('#ipv').css('width',"200px")

    })

    $('#')

})
</script>


<div class="container">
<a class="btn btn-light" style="margin-right: 20px;" href="./register.php">會員註冊</a>
<a class="btn btn-info" style="margin-right: 20px;" href="#">廠商註冊</a>
    <hr/>
    <form name="myForm" method="POST" action="./addCompany.php" enctype="multipart/form-data">
        <div class="form-row">
            
            <div class="form-group col-md-6">
                <img id="ipv" src="" >
                <label for="companyLogo" >公司Logo</label><br>
                <input type="file"  id="companyLogo" name="companyLogo" style="margin-top:5px;" >
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="companyMail">登入帳號(聯絡信箱)</label>
                <input type="text" class="form-control" id="companyMail" name="companyMail" placeholder="範例:xz123@xxx" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==7){
                //     echo "<p style='color:red;fontweight:600;'>請輸入登入信箱</p>";
                // }?>               
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="companyPwd">登入密碼</label>
                <input type="password" class="form-control" id="companyPwd" name="companyPwd" placeholder="請輸入密碼" value="">
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
                <label for="companyName">廠商名稱</label>
                <input type="text" class="form-control" id="companyName" name="companyName" placeholder="請輸入您的姓名" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==1){
                //     echo "<p style='color:red;fontweight:600;'>請輸入您的姓名</p>";
                // }?>   
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="companyIdentity">統一編號</label>
                <input type="text" class="form-control" id="companyIdentity" name="companyIdentity" placeholder="請輸入廠商統一編號" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==5){
                //     echo "<p style='color:red;fontweight:600;'>請輸入身分證</p>";
                // }?>  
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="companyPhone">連絡電話</label>
                <input type="text" class="form-control" id="companyPhone" name="companyPhone" placeholder="請輸入廠商聯絡電話" value="">
                <?php
                // if(isset($_GET['error']) && $_GET['error']==4){
                //     echo "<p style='color:red;fontweight:600;'>請輸入手機電話號碼</p>";
                // }?> 
            </div>
            <div class="form-group col-md-6">
                <label for="companyAddress">廠商地址</label>
                <input type="text" class="form-control" id="companyAddress" name="companyAddress" placeholder="請輸入廠商地址">
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
            echo "<h2 style='color:red;'>申請已提出,請靜待審核結果通知</h2>";
        }
        ?>
        <button type="submit" class="btn btn-primary">提出申請</button>
    </form>
  
</div>

<?php
require_once('./tpl/footer.php');
require_once('./tpl/tpl-html-foot.php'); 
?>