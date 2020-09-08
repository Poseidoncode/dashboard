<?php
$db_host = "192.168.21.123";
$db_username = "test1";
$db_password = "test";
$db_name = "database_1";
$db_charset = "utf8mb4";
$db_collate = "utf8mb4_unicode_ci";


try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset={$db_charset}", $db_username , $db_password);
    
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute (PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES {$db_charset} COLLATE {$db_collate}");
} catch (PDOException $e) {
    echo "資料庫連結失敗，訊息: " . $e->getMessage();
}