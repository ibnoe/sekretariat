<?php
// Ini adalah Config yang memadahi
$title_page ="MY CORE ENGINE - WITH JQUERY";
$home_url       = '118.98.233.100/sekretariat/';

$left_width		= 10;
$right_width	= 1010;

// pengkodean url rewrite
# /index.php?_mod=$1&task=$2&act=$3 [L]
# $1 = modul, $2= file di dalam modul, $3 = action pada file;

//config database
//$conn = mysql_connect("localhost","root","Huk0r#123!"); 
$conn = mysql_connect("localhost","root",""); 
$db=mysql_select_db("sekretariat");	

?>