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

    $('#inputcompanyLogo').change(function(){
        var src=URL.createObjectURL(this.files[0])
        $('#ipv').attr('src',src)
    })

    })
    </script>
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>

<a href="./company.php"><--上一頁</a>
<br>

<form name="myForm" method="POST" action="company_update.php" enctype="multipart/form-data">
    <table>
        <tbody>
        <?php
            $sql = "SELECT `companyId`,`companyName`,
            `companyPhone`,`companyIdentity`,`companyAddress`,
            `companyPwd`,`companyMail`,`companyLogo`,`companyStatus` ,`created_at`,`updated_at`
            FROM `company` 
            WHERE `companyId`= ? ";
            
            $arrParam = [$_GET['infoId']];

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
                    <input type="file" name="companyLogo" id="inputcompanyLogo" />
                    </td>
                </tr>
                <tr>
                    <td class="companyborder">廠商名稱：</td>
                    <td class="companyborder">
                        <input type="text" class="input" name="companyName" value="<?= $arr['companyName'] ?>">
                    </td>
                </tr>           
                <tr>
                    <td class="companyborder">聯絡電話：</td>
                    <td class="companyborder">
                        <input type="tel"  name="companyPhone" value="<?= $arr['companyPhone'] ?>">
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">統一編號：</td>
                    <td class="companyborder">
                        <input type="text" name="companyIdentity" value="<?= $arr['companyIdentity'] ?>">
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">聯絡地址：</td>
                    <td class="companyborder">
                        <input  type="text" class="input" name="companyAddress" value="<?= $arr['companyAddress'] ?>">
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">信箱帳號：</td>
                    <td class="companyborder">
                        <input type="text" class="input" name="companyMail" value="<?= $arr['companyMail'] ?>">
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">登入密碼：</td>
                    <td class="companyborder">
                        <input type="text" class="input" name="companyPwd_change" value="" placeholder="如無需更新,則不用填寫">
                    </td>
                </tr>          
                <tr>
                    <td class="companyborder">註冊時間：</td>
                    <td class="companyborder">
                        <?=  $arr['created_at']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="companyborder">更新時間：</td>
                    <td class="companyborder">
                        <?=  $arr['updated_at']; ?>
                    </td>
                </tr>  
                <tr>
                    <td class="companyborder">廠商狀態：</td>
                    <td class="companyborder">
                        <select name="companyStatus">
                            <option value="<?= $arr['companyStatus'] ?>" selected>
                                <?php if($arr['companyStatus'] === "true"){ echo "啟用"; }else{echo "停用";}  ?>
                            </option>
                            <option value="true">啟用</option>
                            <option value="false">停用</option>
                        </select>
                    </td>
                </tr>            
                <tr>
                    <td class="companyborder">功能</td>
                    <td class="companyborder">
                        <input type="submit" name="smb" value="更新">
                        <input type="button" value="刪除" onclick="if(confirm('是否確認刪除這筆資料？')) location.href='./company_delete.php?deleteId=<?= $arr['companyId'] ?>'">
                    </td>
                </tr>
        <?php 
            }else{
        ?>
            <tr>
                <td class="companyborder" colspan="6">沒有資料</td>
            </tr>
        <?php
            }
        ?>
        </tbody> 
    </table>
    <input type="hidden" name="companyId" value="<?= (int)$arr['companyId']; ?>">
    <input type="hidden" name="companyPwd" value="<?= $arr['companyPwd']; ?>">
</form>












</body>
</html>