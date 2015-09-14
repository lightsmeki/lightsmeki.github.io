<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="templates/images/ourphp_login.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';

$ourphp_name = $_GET['ourphp'];
if ($ourphp_name == 'usersearch'){
$ourphp_search = '?ourphp=usersearch&op=user';
}
?>
<div style="height:10px;">
  <form id="form1" name="form1" method="post" action="<?php echo $ourphp_search ?>">
  <table width="90%" border="0" cellpadding="10">
    <tr>
      <td width="32%"><input type="text" name="k" class="win" /></td>
      <td width="68%"><input type="submit" name="Submit" value="搜 索" style="width:100px; height:30px; background:#0099FF; color:#FFFFFF; border:0px;" /></td>
    </tr>
  </table>
  </form>
</div>
<div style="clear:both"></div>
<table width="90%" border="0" style="margin-top:50px;">
<?php
if(isset($_GET["op"]) == ""){
	echo '';	
}elseif($_GET["op"] == 'user'){

	$k = !empty($_POST["k"])?$_POST["k"]:'0';
	$sql="select * from `ourphp_user` where `OP_Useremail` = '".$k."' or `OP_Username` = '".$k."' order by id desc";
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if ($num == 0 or $query == ''){
?>

  <tr>
    <td width="40%"><?php echo $ourphp_adminfont['parametererror'] ?></td>
  </tr>
  
<?php
	}else{
	while($ourphp_rs=mysql_fetch_array($query)){
?>
  <tr>
    <td width="40%">账户：<?php echo $ourphp_rs['OP_Useremail'] ?></td>
	<td>姓名：<?php echo $ourphp_rs['OP_Username'] ?></td>
  </tr>
  
<?php 
	}
	}
}
?>
</table>
</body>
</html>