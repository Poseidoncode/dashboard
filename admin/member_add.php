<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


?>

?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新增會員</title>
    <style>
    .memberborder {
        /* border: 1px solid #aaa; */
        padding:10px 0;
    }

    .input{
        width:350px;
    }
    .memberImg{
        width:200px;
    }

    </style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
<script>

$(function(){

    $('#inputmemberImg').change(function(){
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

<a href="./member.php"><--上一頁</a>
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


<form name="myForm" method="POST" action="member_add_update.php" enctype="multipart/form-data">
    <table>
        <tbody>
                <tr>
                    <!-- <td class="memberborder">頭像</td> -->
                    <td class="memberborder" colspan="2">
                        <img  id="ipv" src="" />

                    </td>
                </tr>
                <tr>
                    <td class="memberborder">上傳頭像：</td>
                    <td class="memberborder">
                    <input type="file" name="memberImg" id="inputmemberImg"/>
                    </td>
                </tr>
                                <tr>
                    <td class="memberborder">信箱帳號：</td>
                    <td class="memberborder">
                        <input type="text" class="input" name="memberMail" value="">
                    </td>
                </tr>            
                <tr>
                    <td class="memberborder">登入密碼：</td>
                    <td class="memberborder">
                        <input type="text" class="input" name="memberPwd" value="">
                    </td>
                </tr>   
                <tr>
                    <td class="memberborder">姓名：</td>
                    <td class="memberborder">
                        <input type="text"  name="memberName" value="">
                    </td>
                </tr>
                <tr>
                    <td class="memberborder">性別：</td>
                    <td class="memberborder">
                        <select name="memberGender">
                            <option value="男">男</option>
                            <option value="女">女</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="memberborder">生日：</td>
                    <td class="memberborder">
                        <input type="date" name="memberBirth" value="">
                    </td>
                </tr>            
                <tr>
                    <td class="memberborder">電話：</td>
                    <td class="memberborder">
                        <input type="tel"  name="memberPhone" value="">
                    </td>
                </tr>            
                <tr>
                    <td class="memberborder">身分證：</td>
                    <td class="memberborder">
                        <input type="text" name="memberIdentity" value="">
                    </td>
                </tr>            
                <tr>
                    <td class="memberborder">聯絡地址：</td>
                    <td class="memberborder">
                        <input  type="text" class="input" name="memberAddress" value="">
                    </td>
                </tr>                
                <tr>
                    <td class="memberborder">功能</td>
                    <td class="memberborder">
                        <input type="submit" name="smb" value="註冊">
                    </td>
                </tr>

        </tbody> 
    </table>
</form>












</body>
</html>