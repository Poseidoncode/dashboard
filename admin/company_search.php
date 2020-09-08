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
    .companyborder {
        border: 1px solid #aaa;
    }
    .wpx {
        width: 60px;
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
<h3>廠商管理頁面</h3>
<hr>
<input type="button" value="返回列表" onclick="location.href='./company.php'">
<hr>
<form name="myForm2" method="POST"  action="company_search.php">
    <table class="search">
        <tr>
            <td>
                <label for="companyStatus">狀態：</label>
                <select   select name="companyStatus" id="">
                    <option value="true" selected>啟用</option>
                    <option value="false">停用</option>
                </select> 
            </td>     
            <td>
                <label for="companyOther">其它：</label>
                <select name="company_search" id="">
                    <option value="companyName">廠商名稱</option>
                    <option value="companyIdentity">統一編號</option>
                    <option value="companyMail">信箱帳號</option>
                    <option value="companyPhone">連絡電話</option>
                    <option value="companyAddress">連絡地址</option>
                </select>
                <input class="input" type="text" name="search">
            </td>
            <td><input type="submit" value="搜尋"></td>
        </tr>
        <tr>
            
        </tr>   
    </table>


 

</form>

<form name="myForm" class="myForm" method="POST" action="./companys_delete.php" >

    <table class="tb">
        <thead>
            <tr>
                <th class="companyborder">ID</th>
                <th class="companyborder">狀態</th>
                <th class="companyborder">廠商logo</th>
                <th class="companyborder">廠商名稱</th>
                <th class="companyborder">統一編號</th>
                <th class="companyborder">聯絡電話</th>
                <th class="companyborder">聯絡地址</th>
                <th class="companyborder">信箱帳號</th>
                <th class="companyborder">功能</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $s=$_POST['company_search'];
            $sql = "SELECT `companyId`,`companyName`,`companyPhone`,`companyIdentity`,
                            `companyAddress`,`companyMail`,`companyLogo`,`companyStatus` 
                    FROM `company` 
                    WHERE `{$s}` LIKE '%{$_POST['search']}%' 
                    AND `companyStatus` = '{$_POST['companyStatus']}'                   
                    ORDER BY `companyId` ASC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            if( $stmt->rowCount() > 0){
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for( $i = 0 ; $i < count($arr) ; $i++ ){
            ?>
                <tr>
                    <td class="companyborder">
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['companyId']; ?>">
                        <?php echo $arr[$i]['companyId'] ?>
                    </td>

                    <td class="companyborder">
                    <?php
                        if($arr[$i]['companyStatus'] === "true"){ echo "啟用"; }else{echo "停用";}?>
                    </td>

                    <td class="companyborder">
                    <?php 
                    if($arr[$i]['companyLogo'] !== NULL){?>
                        <img class="wpx" src="../images/company/<?php echo $arr[$i]['companyLogo']  ?>" alt="">
                    <?php } ?>
                    </td>
                    <td class="companyborder"><?php echo $arr[$i]['companyName'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['companyIdentity'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['companyPhone'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['companyAddress'] ?></td>
                    <td class="companyborder"><?php echo $arr[$i]['companyMail'] ?></td>
                    <td class="companyborder">
                        <input type="button" value="詳細資料" onclick="location.href='./company_info.php?infoId=<?= $arr[$i]['companyId'] ?>'">
                        <input type="button" value="刪除" onclick="location.href='./company_delete.php?deleteId=<?= $arr[$i]['companyId'] ?>'">
                    </td>
                </tr>
            <?php
                }
            }else{
            ?>
                <tr>
                    <td class="companyborder" colspan="10">沒有資料</td>
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