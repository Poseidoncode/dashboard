<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//建立種類列表

function buildTree($pdo, $parentId = 0){
    $companyId = (int)$_SESSION['Id'];
    $sql = "SELECT `categoryId`, `categoryName`, `categoryParentId`, `companyId`
            FROM `category` 
            WHERE `companyId` = $companyId
            AND `categoryParentId` = ?";

    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        echo "<ul>";
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            echo "<li>";
            echo "<input type='radio' name='categoryId' value='".$arr[$i]['categoryId']."' />";
            echo $arr[$i]['categoryName'];
            echo " | <a href='./editCategory.php?editCategoryId=".$arr[$i]['categoryId']."'>編輯</a>";
            echo " | <a href='./deleteCategory.php?deleteCategoryId=".$arr[$i]['categoryId']."'>刪除</a>";
            buildTree($pdo, $arr[$i]['categoryId']);
            echo "</li>";
        }
        echo "</ul>";
    }
}
?>

<?php require_once('./templates/title.php'); ?>
<?php require_once('./templates/sidebar.php'); ?>
                <hr>
                <h3>編輯類別</h3>
                <form name="myForm" method="POST" action="./insertCategory.php">

                <?php buildTree($pdo, 0); ?>

                <table class="border">
                    <thead>
                        <tr>
                            <th class="border">類別名稱</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border">
                                <input type="text" name="categoryName" value="" maxlength="100" required/>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="border"><input type="submit" name="smb" value="新增" ></td>
                        </tr>
                    </tfoot>
                </table>

                </form>

                
            </main>
        </div>
    </div>



</body>
</html>