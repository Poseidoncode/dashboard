<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


?>

?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>會員個人資料</title>
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
    })

})
</script>


</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>

<a class="btn btn-secondary btn-sm" href="./member.php">上一頁</a>
<br>

<?php
    if(isset($_GET['ok']) && $_GET['ok']==1){
            echo "<h2 style='color:red;'>更新完成</h2>";
    }elseif(isset($_GET['err']) && $_GET['err']==1){
            echo "<h2 style='color:red;'>更新失敗</h2>";
    }
?>


<form name="myForm" method="POST" action="member_edit_update.php" enctype="multipart/form-data">
    <table>
        <tbody>
        <?php
            $sql = "SELECT *
            FROM `member` 
            WHERE `memberId`= ? ";
            
            $arrParam = [$_GET['editId']];

            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

            if(count($arr)>0){                       
        ?>
                <tr>
                    <!-- <td class="memberborder">頭像</td> -->
                    <td class="memberborder" colspan="2">
                        <img class="memberImg" id="ipv" src="../images/member/<?php echo $arr['memberImg'] ?>" />

                    </td>
                </tr>
                <tr>
                    <td class="memberborder">頭像替換：</td>
                    <td class="memberborder">
                    <input type="file" name="memberImg" id="inputmemberImg"/>
                    </td>
                </tr>
                <tr>
                    <td class="memberborder">姓名：</td>
                    <td class="memberborder">
                        <input type="text"  name="memberName" value="<?= $arr['memberName'] ?>">
                    </td>
                </tr>
                <tr>
                    <td class="memberborder">性別：</td>
                    <td class="memberborder">
                        <select name="memberGender">
                            <option value="<?= $arr['memberGender'] ?>" selected><?= $arr['memberGender'] ?></option>
                            <option value="男">男</option>
                            <option value="女">女</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="memberborder">生日：</td>
                    <td class="memberborder">
                        <input type="date" name="memberBirth" value="<?= $arr['memberBirth'] ?>">
                    </td>
                </tr>            
                <tr>
                    <td class="memberborder">電話：</td>
                    <td class="memberborder">
                        <input type="tel"  name="memberPhone" value="<?= $arr['memberPhone'] ?>">
                    </td>
                </tr>            
                <tr>
                    <td class="memberborder">身分證：</td>
                    <td class="memberborder">
                        <input type="text" name="memberIdentity" value="<?= $arr['memberIdentity'] ?>">
                    </td>
                </tr>            
                <tr>
                    <td class="memberborder">聯絡地址：</td>
                    <td class="memberborder">
                        <input  type="text" class="input" name="memberAddress" value="<?= $arr['memberAddress'] ?>">
                    </td>
                </tr>            
                <tr>
                    <td class="memberborder">信箱帳號：</td>
                    <td class="memberborder">
                        <input type="text" class="input" name="memberMail" value="<?= $arr['memberMail'] ?>">
                    </td>
                </tr>            
                <tr>
                    <td class="memberborder">登入密碼：</td>
                    <td class="memberborder">
                        <input type="text" class="input" name="memberPwd_change" value="" placeholder="如無需更新,則不用填寫">
                    </td>
                </tr>
                <tr>
                    <td class="memberborder">註冊時間：</td>
                    <td class="memberborder">
                        <?=  $arr['created_at']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="memberborder">更新時間：</td>
                    <td class="memberborder">
                        <?=  $arr['updated_at']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="memberborder">會員狀態：</td>
                    <td class="memberborder">
                        <select name="memberStatus">
                            <option value="<?= $arr['memberStatus'] ?>" selected>
                                <?php if($arr['memberStatus'] === "true"){ echo "啟用"; }else{echo "停用";}  ?>
                            </option>
                            <option value="true">啟用</option>
                            <option value="false">停用</option>
                        </select>
                    </td>
                </tr>            
                <tr>
                    <td class="memberborder">功能</td>
                    <td class="memberborder">
                        <input type="submit" name="smb" value="更新">
                        <input type="button" value="刪除" onclick="if(confirm('是否確認刪除這筆資料？')) location.href='./member_delete.php?deleteId=<?= $arr['memberId'] ?>'">
                    </td>
                </tr>
        <?php 
            }else{
        ?>
            <tr>
                <td class="memberborder" colspan="6">沒有資料</td>
            </tr>
        <?php
            }
        ?>
        </tbody> 
    </table>
    <input type="hidden" name="memberId" value="<?= (int)$arr['memberId']; ?>">
    <input type="hidden" name="memberPwd" value="<?= $arr['memberPwd']; ?>">
</form>












</body>
</html>