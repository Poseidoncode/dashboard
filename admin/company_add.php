<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


?>

?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>廠商資料</title>
    <style>
    .companyborder {
        /* border: 1px solid #aaa; */
        padding:10px 0;
    }
    .w200px {
        width: 200px;
    }
    .input{
        width:350px;
    }
    .companyLogo{
        width:200px;
    }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
    <script>

    $(function(){

        $('#companyLogo').change(function(){
            var src=URL.createObjectURL(this.files[0])
            $('#ipv').attr('src',src)
            $('#ipv').css('width',"200px")
        })

    })
    </script>

</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>

<a href="./company.php"><--上一頁</a>
<br>
<?php
        if(isset($_GET['err']) && $_GET['err']==1){
            echo "<h2 style='color:red;'>請輸入完整資料</h2>";
        }elseif(isset($_GET['err']) && $_GET['err']==2){
            echo "<h2 style='color:red;'>註冊失敗,請重新確認</h2>";
        }elseif(isset($_GET['complete']) && $_GET['complete']==1){
            echo "<h2 style='color:red;'>註冊成功</h2>";
        }
?>
<form name="myForm" method="POST" action="company_add_update.php" enctype="multipart/form-data">
    <table>
        <tbody>
                <tr>
                    <!-- <td class="companyborder">頭像</td> -->
                    <td class="companyborder" colspan="2">
                        <img  id="ipv" src="" />
                    </td>
                </tr>
                <tr>
                    <td class="companyborder">Logo：</td>
                    <td class="companyborder">
                    <input type="file" name="companyLogo" id="companyLogo"/>
                    </td>
                </tr>
                <tr>
                    <td class="companyborder">廠商名稱：</td>
                    <td class="companyborder">
                        <input type="text"  name="companyName" value="">
                    </td>
                </tr>           
                <tr>
                    <td class="companyborder">聯絡電話：</td>
                    <td class="companyborder">
                        <input type="tel"  name="companyPhone" value="">
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">統一編號：</td>
                    <td class="companyborder">
                        <input type="text" name="companyIdentity" value="">
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">聯絡地址：</td>
                    <td class="companyborder">
                        <input  type="text" class="input" name="companyAddress" value="">
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">信箱帳號：</td>
                    <td class="companyborder">
                        <input type="text" class="input" name="companyMail" value="">
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">登入密碼：</td>
                    <td class="companyborder">
                        <input type="text" class="input" name="companyPwd" value="">
                    </td>
                </tr>                   
                <tr>
                    <td class="companyborder">功能</td>
                    <td class="companyborder">
                        <input type="submit" name="smb" value="註冊">
                    </td>
                </tr>
        </tbody> 
    </table>
    <input type="hidden" name="companyId" value="<?= (int)$arr['companyId']; ?>">
</form>












</body>
</html>