<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('./templates/title.php');
require_once('./templates/sidebar.php'); ?>
<hr/>
<h3>廠商資訊</h3>
<hr>

<?php
                $sql = "SELECT `companyId`,`companyName`,`companyPhone`,`companyIdentity`,
                `companyAddress`,`companyMail`,`companyLogo`,`companyStatus` ,`companyPwd`
                FROM `company` 
                WHERE `companyName` = ?";

                $arrParam = [$_SESSION['name']];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($arrParam);
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);                           
            ?>            
        
            <div  class="" >
                <form  name="myForm" method="POST" action="./addCompany.php" enctype="multipart/form-data">        
                <img  class="img.productImg" src="../images/company/<?php echo $arr[0]['companyLogo']  ?>">
                    <div class="">
                        <input type="file"  id="companyLogo" name="companyLogo" style="margin-top:5px;" >
                        <button type="submit" class="backButton btn-primary">更新logo</button>
                    </div>
                </form>    
            </div>      

<div class="">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="companyMail">廠商名稱</label>
                <p type="text" class="form-control" id="companyMail" name="companyMail"  value="" readonly="readonly">              
                <?php echo $arr[0]['companyName']  ?></p>
            </div>
        </div>
        <div  class="form-row">
            <div class="form-group col-md-4">
                <label for="companyStatus">帳號狀態</label>
                <p type="text" class="form-control" id="companyAddress" name="companyStatus"  readonly="readonly" value="">
                <?php if($arr[0]['companyStatus'] === 'true'){echo "啟用中";}  ?></p>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="companyMail">登入帳號(聯絡信箱)</label>
                <p type="text" class="form-control" id="companyMail" name="companyMail"  value="" readonly="readonly">
                <?php echo $arr[0]['companyMail']  ?></p>              
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="companyPwd">登入密碼</label>
                <p type="password" class="form-control" id="companyPwd" name="companyPwd"  value="" readonly="readonly">
                <?php echo $arr[0]['companyPwd']  ?></p>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="companyPhone">連絡電話</label>
                <p type="text" class="form-control" id="companyPhone" name="companyPhone"  value="" readonly="readonly">
                <?php echo $arr[0]['companyPhone']  ?></p>
            </div>
        </div>   
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="companyMail">廠商地址</label>
                <p type="text" class="form-control" id="companyMail" name="companyAddress"  value="" readonly="readonly"><?php echo $arr[0]['companyAddress']?></p>              
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="companyIdentity">統一編號</label>
                <p type="text" class="form-control" id="companyIdentity" name="companyIdentity"  value="" readonly="readonly"><?php echo $arr[0]['companyIdentity']  ?></p>
            </div>
        </div>
</div>



</body>
</html>