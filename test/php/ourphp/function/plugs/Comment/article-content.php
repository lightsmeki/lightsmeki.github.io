<?php
include '../../../config/ourphp_code.php';
include '../../../config/ourphp_config.php';
include '../../../config/ourphp_version.php';
include '../../../config/ourphp_Language.php';
include '../../ourphp_function.class.php';
include '../../ourphp_page.class.php';

//全局定义
session_start();
date_default_timezone_set('Asia/Shanghai'); //设置时区
$ValidateCode = $_SESSION["code"];

$OP_Class = isset($_GET['id'])?$_GET['id']:"0";
$OP_Type = isset($_GET['type'])?$_GET['type']:"articleview";
$OP_Row = isset($_GET['row'])?$_GET['row']:"10";
$userlogin = '游客';

if($OP_Type == 'articleview'){
$select = "OP_Articletitle";
$from = "article";
}elseif($OP_Type == 'photoview'){
$select = "OP_Phototitle";
$from = "photo";
}elseif($OP_Type == 'downview'){
$select = "OP_Downtitle";
$from = "down";
}elseif($OP_Type == 'jobview'){
$select = "OP_Jobtitle";
$from = "job";
}elseif($OP_Type == 'videoview'){
$select = "OP_Videotitle";
$from = "video";
}

//判断数据是否正确
$query = $db-> sqllist("select `id` from `ourphp_".$from."` where `id` = ".intval($OP_Class));
if(!mysql_num_rows($query)){
	exit(0);
}

$query=mysql_query("select a.OP_Webocomment ,b.".$select." from `ourphp_webdeploy` a ,`ourphp_".$from."` b where a.id=1 and b.id=".intval($OP_Class));
$ourphp_rs=mysql_fetch_array($query);
$OP_Webocomment = $ourphp_rs[0];
$OP_Articletitle = $ourphp_rs[1];
mysql_free_result($query);

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "add"){

			//验证
			if($OP_Webocomment == 2){
			exit("评论被关闭:(");
			}elseif($OP_Webocomment == 3){
				if(!isset($_SESSION['username'])){
				exit("请先登录:(");
				}
			}

			if (!empty($_POST["content"]) == '' || $_POST["code"] == ''){
			exit("<script language=javascript> alert('评论或验证码不能为空！');history.go(-1);</script>");
			}elseif ($_POST["code"] != $ValidateCode){
			exit("<script language=javascript> alert('验证码错误！');history.go(-1);</script>");
			}

			if(!isset($_SESSION['username'])){
			$OP_Name = $userlogin;
			}else{
			$OP_Name = $_SESSION['username'];
			}
			
			$OP_Ip = $_SERVER["REMOTE_ADDR"];
			
			$sql="insert into `ourphp_comment` set 
			`OP_Content` = '".dowith_sql(ourphp_sensitive($_POST["content"]))."',
			`OP_Class` = '".dowith_sql($_POST["OP_Class"])."',
			`OP_Type` = '".dowith_sql($_POST["OP_Type"])."',
			`OP_Name` = '".$OP_Name."',
			`OP_Ip` = '".$OP_Ip."',
			`time` = '".date("Y-m-d H:i:s")."'
			";
			$query=mysql_query($sql);
			exit("<script language=javascript> alert('OK!:)');history.go(-1);</script>");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $OP_Articletitle; ?> 的相关评论</title>
<style type="text/css">*{ font-size:12px;}</style>
</head>
<body>
<table width="100%" border="1" align="center" cellpadding="10" bordercolor="#EEEEEE" style="border-collapse:collapse;">
  <tr>
    <td colspan="2"><h1><?php echo $OP_Articletitle; ?> 的相关评论:</h1></td>
  </tr>
<?php
$listpage = $OP_Row;
if (intval(isset($_GET['page'])) == 0){
	$listpagesum = 1;
		}else{
	$listpagesum = intval($_GET['page']);
}
$start=($listpagesum-1)*$listpage;
$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_comment` where OP_Class = ".intval($OP_Class)."");
$ourphptotal=mysql_fetch_assoc($ourphptotal);

$sql="select * from `ourphp_comment` where OP_Class = ".intval($OP_Class)." && OP_Type = '".dowith_sql($OP_Type)."' order by time desc LIMIT 0,".intval($OP_Row);
$query=mysql_query($sql);
$i = 1;
	
while($ourphp_rs=mysql_fetch_array($query)){

$userip = preg_replace('/((?:\d{1,3}\.){3})\d{1,3}/','$1*',$ourphp_rs['OP_Ip']);
if($ourphp_rs['OP_Name'] == $userlogin){
$username = $ourphp_rs['OP_Name'];
}else{
$username = half_replace($ourphp_rs['OP_Name']);
}
?>
  <tr>
   <td width="12%" rowspan="2" valign="top"><div align="center"><img src="../../../skin/userhead_s.jpg" border="0" /></div></td>
    <td width="88%" height="20"><span style="float:right;"><?php echo $ourphp_rs['time']; ?></span><?php echo $username; ?> <font color="#CCCCCC" size="2">(<?php echo $userip; ?>)</font></td>
  </tr>
  <tr>
    <td height="98" valign="top">
	<?php 
			echo $ourphp_rs['OP_Content']; 
			if($ourphp_rs['OP_Gocontent'] != ''){
			echo '<div style="clear:both; height:20px;"></div>';
			echo '<p>管理员回复：'.$ourphp_rs['OP_Gocontent'].'&nbsp;&nbsp;&nbsp;&nbsp;('.$ourphp_rs['OP_Gotime'].')</p>';
			}
	?>
	</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#eeeeee"></td>
  </tr>
<?php
$i = $i + 1;
}
$_page = new Page($ourphptotal['tiaoshu'],$listpage);
?>
  <tr>
    <td colspan="2"><?php echo $_page->showpage(); ?></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="?ourphp_cms=add">
<table width="100%" border="1" align="center" cellpadding="10" bordercolor="#EEEEEE" style="border-collapse:collapse;">
  <tr>
    <td><div align="right">评论</div></td>
<?php if($OP_Webocomment == 2){ ?>
    <td><textarea name="content" style="width:410px; height:110px; border:1px #cccccc solid;text-align:center; line-height:110px;" disabled="disabled" >评论被关闭:(</textarea></td>
<?php }elseif($OP_Webocomment == 3){ 
			if(isset($_SESSION['username'])){
?>
			<td><textarea name="content" style="width:410px; height:110px; border:1px #cccccc solid;" ></textarea></td>
			<?php }else{ ?>
			<td><textarea name="content" style="width:410px; height:110px; border:1px #cccccc solid;text-align:center; line-height:110px;" disabled="disabled" >请登录后在评论！</textarea></td>
			<?php } ?>
<?php }else{ ?>
	<td><textarea name="content" style="width:410px; height:110px; border:1px #cccccc solid;" ></textarea></td>
<?php 
	}
?>
  </tr>
  <tr>
    <td><div align="right">验证码</div></td>
    <td><input type="text" name="code" style="width:100px; height:23px; border:1px #cccccc solid; line-height:23px;" onfocus="document.getElementById('checkcode2').src+='?'" />&nbsp;&nbsp;<img title="点击刷新" id="checkcode2" src="<?php echo $ourphp_webpath ?>function/ourphp_code.php" align="absbottom" onclick="this.src='<?php echo $ourphp_webpath ?>function/ourphp_code.php?'+Math.random();" width="80" height="25"></img></td>
  </tr>
  <tr>
    <td>&nbsp;<input type="hidden" name="OP_Class" value="<?php echo $OP_Class ?>" /><input type="hidden" name="OP_Type" value="<?php echo $OP_Type ?>" /></td>
    <td><input type="submit" name="Submit" value="提交评论" style="width:100px; height:30px;background:#3399FF; color:#FFFFFF; border:0px;" /></td>
  </tr>
</table>
</form>
</body>
</html>