<?php 
session_start();
require_once('../db.inc.php'); 
require_once('../tpl/tpl-html-head.php');
require_once('../tpl/header.php');
require_once("../tpl/func-buildTree.php");
require_once("../tpl/func-getRecursiveCategoryIds.php"); 
?>


<?php require_once('../tpl/footer.php'); ?>
<?php require_once('../tpl/tpl-html-foot.php'); ?>