
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>資料排序</title>
<style>
.show table, td{
 border: 2px darkgray solid;
 border-collapse:collapse;
}
.show th{
 text-align:center;
 color:white;
 background-color:gray;
}
.show th a:link{
 text-align:center;
 color:white;
 background-color:gray;
 text-decoration:none;
}
.show th a:visited{
 text-align:center;
 color:white;
 background-color:gray;
}
.show th a:hover{
 text-align:center;
 color:white;
 background-color:darygray;
}
.tri_up{
width: 0;
height: 0;
border-style: solid;
border-width: 0 5px 10px 5px;
border-color: transparent transparent white transparent;
position: relative;
left:3px;
top:-13px;
}
.tri_down{
width: 0;
height: 0;
border-style: solid;
border-width: 10px 5px 0 5px;
border-color: white transparent transparent transparent;
position: relative;
left:3px;
top:15px;
}
</style>
</head>


<?php
$s=$_GET['s'];
$c=$_GET['c'];
if($c==''){
 $data=mysql_query("select * from member");
}else if($s=='1'){
 $data=mysql_query("select * from member order by $c");
}else{
 $data=mysql_query("select * from member order by $c desc");
}
?>