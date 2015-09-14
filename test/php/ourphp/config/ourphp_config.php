<?php
//网站路径
$ourphp_webpath="/"; 
//登录口令
$ourphp_validation="12345"; 
//管理员默认目录 
$ourphp_adminpath="client/manage"; 
//数据库连接地址
$ourphp_mysqlurl="localhost"; 
//数据库连接账号
$ourphp_mysqlname="root"; 
//数据库连接密码
$ourphp_mysqlpass=""; 
//数据库名称
$ourphp_mysqldb="ourphp"; 
//附件上传大小
$ourphp_filesize="1000000"; 

define('OURPHPNO', true);
define('WEB_ROOT',substr(dirname(__FILE__), 0, -7));
$conn = mysql_connect($ourphp_mysqlurl,$ourphp_mysqlname,$ourphp_mysqlpass);
mysql_query('set names utf8',$conn);
mysql_select_db($ourphp_mysqldb, $conn) or die(mysql_error());
if (!$conn)
{
die('Could not connect: ' . mysql_error());
exit;
}
?>