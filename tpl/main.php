<div class="album py-5 bg-light flex-shrink-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 d-flex justify-content-center my-3">
                <h1>商品一覽</h1>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
        <?php
        //SQL 敘述
        $sql = "SELECT `product`.`productId`, `product`.`productName`, `product`.`productImg`, `product`.`productPrice`, 
                        `product`.`productAmount`, `product`.`categoryId`, `product`.`mapId`, `product`.`productAddress`, `product`.`productEndingDate`, `product`.`companyId`, `product`.`created_at`, `product`.`updated_at`,
                        `category`.`categoryName`
                FROM `product` INNER JOIN `category` 
                ON `product`.`categoryId` = `category`.`categoryId`
                ORDER BY `product`.`productId` ASC ";
        // $sql.= "LIMIT ?, ? ";
        //設定繫結值
        // $arrParam = [($page - 1) * $numPerPage, $numPerPage];

        //查詢分頁後的商品資料
        $stmt = $pdo->prepare($sql);
        $stmt->execute(); //$arrParam

        //若數量大於 0，則列出商品
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arr); $i++) {
        ?>
            <div class="col-md-3 col-sm-6">
                <div class="card mb-3 shadow-sm">
                    <a href="./itemDetail.php?productId=<?php echo $arr[$i]['productId']; ?>">
                        <img class="list-item" src="./images/products/<?php echo $arr[$i]['productImg']; ?>">
                    </a>
                    <div class="card-body">
                        <p class="card-text list-item-card"><?php echo $arr[$i]['productName']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <!-- <button type="button" class="btn btn-sm btn-outline-secondary">詳細</button> -->
                                <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button> -->
                            </div>
                            <small class="text-muted">上架日期：<?php echo $arr[$i]['created_at']; ?></small>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
        }
        ?>
        </div>
    </div>
</div>