<?php

require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

if(!isset($_GET['member_search'])){$_GET['member_search']="memberName";};
if(!isset($_GET['memberStatus'])){$_GET['memberStatus']="";};
if(!isset($_GET['memberGender'])){$_GET['memberGender']="";};
if(!isset($_GET['search'])){$_GET['search']="";};


$s=$_GET['member_search'];

//SQL搜尋語法:取得 member 資料表總筆數
$sqlTotal = "SELECT count(1)
FROM `member`
WHERE `{$s}` LIKE '%{$_GET['search']}%' 
AND `memberStatus` LIKE '%{$_GET['memberStatus']}%'                   
AND `memberGender` LIKE '%{$_GET['memberGender']}%' ";

//取得總筆數
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];

//每頁幾筆
$numPerPage = 10;

//總頁數
$totalPages = ceil($total/$numPerPage);

$page = isset($_GET['page'])?(int)$_GET['page'] : 1;
//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;

?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>會員資料列表</title>
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
    tfoot{
        font-size: 20px;
        line-height: 40px;
    }
    </style>
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
<hr />
<h3>會員管理頁面</h3>
<hr>




<form name="myForm2" method="GET"  action="member.php">
    <table class="search">
        <tr>
            <td>
                <label for="memberStatus">狀態：</label>
                <select  name="memberStatus" id="">
                <option value="" selected>全部</option>
                    <option value="true" >啟用</option>
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

<form name="myForm" class="myForm  table-striped table-hover border_article" method="POST" action="./members_delete.php" >

    <table class="table table-striped border_article">
        <thead class="thead-mainColor"> 
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
               
                $sql = "SELECT `memberId`,`memberName`,`memberGender`,
                `memberBirth`,`memberPhone`,`memberIdentity`,
                `memberAddress`,`memberMail`,`memberImg`,`memberStatus` 
                FROM `member`
                WHERE `{$s}` LIKE '%{$_GET['search']}%' 
                AND `memberStatus` LIKE '%{$_GET['memberStatus']}%'                   
                AND `memberGender` LIKE '%{$_GET['memberGender']}%'                   
                ORDER BY `memberId` ASC
                LIMIT ? , ? ";
            
            $arrParam = [($page - 1) * $numPerPage, $numPerPage];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

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
                        <input class="btn btn-mainColor btn-sm" type="button" value="編輯" onclick="location.href='./member_edit.php?editId=<?= $arr[$i]['memberId'] ?>'">
                        <input class="btn btn-mainColor btn-sm" type="button" value="刪除" onclick="if(confirm('是否確認刪除這筆資料？')) location.href='./member_delete.php?deleteId=<?= $arr[$i]['memberId'] ?>'">
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
            <tr>
                <td  class="memberborder" colspan="10">
                <?php
                    if($page > 1){
                        echo '<a class="btn btn-mainColor btn-sm" href="member.php?page='.($page-1).'&memberStatus='.$_GET['memberStatus'].'&memberGender='.$_GET['memberGender'].'&member_search='.$_GET['member_search'].'&search='.$_GET['search'].'">上一頁</a> ';
                    }
                    for( $i = 1 ; $i <= $totalPages ; $i++){?>
                        
                        <a class="btn btn-mainColor btn-sm" href="?page=<?= $i ?>&memberStatus=true&memberGender=&member_search=memberName&search="> <?= $i ?> </a>

                <?php } 
                    if($page < $totalPages){
                        echo '<a class="btn btn-mainColor btn-sm" href="member.php?page='.($page+1).'&memberStatus='.$_GET['memberStatus'].'&memberGender='.$_GET['memberGender'].'&member_search='.$_GET['member_search'].'&search='.$_GET['search'].'">下一頁</a>';
                    }
                
                ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="submit" name="smb" value="多筆刪除" onclick="return confirm('是否確認刪除這些資料');">
</form>

<?php


?>

</body>
</html>