<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

// echo "<pre>";
// print_r($_SESSION['Id']);
// // print_r($arrGetImgParam);
// echo "</pre>";
// exit();



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

$('#inputcompanyLogo').change(function(){
    var src=URL.createObjectURL(this.files[0])
    $('#ipv').attr('src',src)
})

})
</script>

</head>
<body>
<?php
require_once('./templates/title.php');
require_once('./templates/sidebar.php');  
?>
<br>
<h3>廠商資訊</h3>
<hr>

<form name="myForm" method="POST" action="company_update.php" enctype="multipart/form-data">
    <table>
        <tbody>
        <?php
            $sql = "SELECT *
            FROM `company` 
            WHERE `companyId`= ? ";
            
            $arrParam = [$_SESSION['Id']];

            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

            if(count($arr)>0){                       
        ?>
                <tr>
                    <!-- <td class="companyborder">頭像</td> -->
                    <td class="companyborder" colspan="2">
                                            
                    <img class="companyLogo" id="ipv" src="../images/company/<?php echo $arr['companyLogo'] ?>" />
                    
                    </td>
                </tr>
                <tr>
                    <td class="companyborder">Logo替換：</td>
                    <td class="companyborder">
                    <input type="file" name="companyLogo"  id="inputcompanyLogo"/>
                    </td>
                </tr>
                <tr>
                    <td class="companyborder">廠商名稱：</td>
                    <td class="companyborder">
                        <!-- <input type="text"  name="companyName" value="<?= $arr['companyName'] ?>"> -->
                        <?= $arr['companyName'] ?>
                    </td>
                </tr>           
                <tr>
                    <td class="companyborder">聯絡電話：</td>
                    <td class="companyborder">
                        <!-- <input type="tel"  name="companyPhone" value="<?= $arr['companyPhone'] ?>"> -->
                        <?= $arr['companyPhone'] ?>
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">統一編號：</td>
                    <td class="companyborder">
                        <!-- <input type="text" name="companyIdentity" value="<?= $arr['companyIdentity'] ?>"> -->
                        <?= $arr['companyIdentity'] ?>
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">聯絡地址：</td>
                    <td class="companyborder">
                        <!-- <input  type="text" class="input" name="companyAddress" value="<?= $arr['companyAddress'] ?>"> -->
                        <?= $arr['companyAddress'] ?>
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">信箱帳號：</td>
                    <td class="companyborder">
                        <!-- <input type="text" class="input" name="companyMail" value="<?= $arr['companyMail'] ?>"> -->
                        <?= $arr['companyMail'] ?>
                    </td>
                </tr>            
                 <tr>
                    <td class="companyborder">登入密碼：</td>
                    <td class="companyborder">
                        <input type="text" class="input" name="companyPwd_change" placeholder="如無需更新,則不用填寫" value="">
                    </td>
                </tr>        
                 <tr>
                    <td class="companyborder">帳號註冊時間：</td>
                    <td class="companyborder">
                        <?=  $arr['created_at']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="companyborder">最後更新時間：</td>
                    <td class="companyborder">
                        <?=  $arr['updated_at']; ?>
                    </td>
                </tr>  
                <tr>
                    <td class="companyborder">帳號狀態：</td>
                    <td class="companyborder">
                        <?php 
                        if($arr['companyStatus'] === "true"){ 
                            echo "啟用"; 
                        }else{echo "停用";}                     
                        ?>
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">功能</td>
                    <td class="companyborder">
                        <input type="submit" name="smb" value="更新">
                    </td>
                </tr>
        <?php 
            }else{}
        ?>
        </tbody> 
    </table>
    <input type="hidden" name="companyId" value="<?= (int)$arr['companyId']; ?>">
    <input type="hidden" name="companyPwd" value="<?= $arr['companyPwd']; ?>">
    <br>
    <h4 style="color:red;">如需更新 廠商Logo，密碼以外資料項目，請與我們聯繫</h4>
</form>





</body>
</html>