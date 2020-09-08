<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>查詢結果</title>
    <style>
    .memberborder {
        border: 1px solid #aaa;
    }
    .w200px {
        width: 200px;
    }
    .tb{
        width: 100%;
    }
    .myForm td , .myForm th{
        padding:3px 10px;
        text-align:center;
    }

    .search td{
        /* border:1px solid black; */
        padding:5px 10px;
    }

    .input{
        width:300px;
    }
    </style>
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<input type="button" value="返回列表" onclick="location.href='./member.php'">

<hr>

<form name="myForm2" method="POST"  action="member_search.php">
    <table class="search">
        <tr>
            <td>
                <label for="memberStatus">狀態：</label>
                <select   select name="memberStatus" id="">
                    <option value="true" selected>啟用</option>
                    <option value="false">停用</option>
                </select> 
            </td>     
            <td>
                <label for="memberGender">性別：</label>
                <select name="memberGender" id="">
                    <option value="" selected>全部</option>
                    <option value="男">男性</option>
                    <option value="女">女性</option>
                </select>
            </td>
            <td>
                <label for="memberOther">其它：</label>
                <select name="member_search" id="">
                    <option value="memberName">姓名</option>
                    <option value="memberIdentity">身分證</option>
                    <option value="memberMail">信箱帳號</option>
                    <option value="memberPhone">連絡電話</option>
                    <option value="memberAddress">連絡地址</option>
                </select>
                <input class="input" type="text" name="search">
            </td>
            <td><input type="submit" value="搜尋"></td>
        </tr>
        <tr>
            
        </tr>   
    </table>


 

</form>

<form name="myForm" class="myForm" method="POST" action="./member/members_delete.php" >

    <table class="tb">
        <thead>
            <tr>
                <th class="memberborder">ID</th>
                <th class="memberborder">狀態</th>
                <th class="memberborder">姓名</th>
                <th class="memberborder">性別</th>
                <th class="memberborder">生日</th>
                <th class="memberborder">聯絡電話</th>
                <th class="memberborder">身分證</th>
                <th class="memberborder">聯絡地址</th>
                <th class="memberborder">信箱帳號</th>
                <th class="memberborder">功能</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $s=$_POST['member_search'];


            $sql = "SELECT `memberId`,`memberName`,`memberGender`,
                            `memberBirth`,`memberPhone`,`memberIdentity`,
                            `memberAddress`,`memberMail`,`memberImg`,`memberStatus` 
                    FROM `member`
                    WHERE `{$s}` LIKE '%{$_POST['search']}%' 
                    AND `memberStatus` = '{$_POST['memberStatus']}'                   
                    AND `memberGender` LIKE '%{$_POST['memberGender']}%'                   
                    ORDER BY `memberId` ASC";
                    

            // $arrParam = [($page - 1) * $numPerPage, $numPerPage];
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            // echo "<pre>";
            // print_r($stmt);
            // echo "</pre>";
            // exit();

            if( $stmt->rowCount() > 0){
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for( $i = 0 ; $i < count($arr) ; $i++ ){
            ?>
                <tr>
                    <td class="memberborder">
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['memberId']; ?>">
                        <?php echo $arr[$i]['memberId'] ?>
                    </td>
                    <td class="memberborder">
                    <?php
                        if($arr[$i]['memberStatus'] === "true"){ echo "啟用"; }else{echo "停用";}?>
                    </td>
                    <td class="memberborder"><?php echo $arr[$i]['memberName'] ?></td>
                    <td class="memberborder"><?php echo $arr[$i]['memberGender'] ?></td>
                    <td class="memberborder"><?php echo $arr[$i]['memberBirth'] ?></td>
                    <td class="memberborder"><?php echo $arr[$i]['memberPhone'] ?></td>
                    <td class="memberborder"><?php echo $arr[$i]['memberIdentity'] ?></td>
                    <td class="memberborder"><?php echo $arr[$i]['memberAddress'] ?></td>
                    <td class="memberborder"><?php echo $arr[$i]['memberMail'] ?></td>
                    <td class="memberborder">
                        <input type="button" value="編輯" onclick="location.href='./member/member_edit.php?editId=<?= $arr[$i]['memberId'] ?>'">
                        <input type="button" value="刪除" onclick="location.href='./member/member_delete.php?deleteId=<?= $arr[$i]['memberId'] ?>'">
                    </td>
                </tr>
            <?php
                }
            }else{
            ?>
                <tr>
                    <td class="memberborder" colspan="10">沒有資料</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
    <input type="submit" name="smb" value="多筆刪除">
</form>



</body>
</html>