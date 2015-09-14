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
$OP_Type = isset($_GET['type'])?$_GET['type']:"productview";
$OP_Row = isset($_GET['row'])?$_GET['row']:"10";
$userlogin = '游客';

if($OP_Type == 'productview'){
$select = "OP_Title";
$from = "product";
}

//判断数据是否正确
$query = $db-> sqllist("select `id` from `ourphp_".$from."` where `id` = ".intval($OP_Class));
if(!mysql_num_rows($query)){
	exit(0);
}

$query=mysql_query("select a.OP_Webocomment ,a.OP_Webpcomment ,b.".$select." from `ourphp_webdeploy` a ,`ourphp_".$from."` b where a.id=1 and b.id=".intval($OP_Class));
$ourphp_rs=mysql_fetch_array($query);
$OP_Webocomment = $ourphp_rs[0];
$OP_Webpcomment = $ourphp_rs[1];
$OP_Articletitle = $ourphp_rs[2];
mysql_free_result($query);

if($OP_Webpcomment == 4){
		if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		}else{
		$username = '0';
		}
		$query = mysql_query("select `id` from `ourphp_orders` where OP_Ordersid = ".intval($OP_Class)." && OP_Ordersemail = '".$username."'");
		$num=mysql_num_rows($query);
		if ($num == 0){
		$userbuy=2;
		}else{
		$userbuy=1;
		}
}else{
		$userbuy=2;
}

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "add"){

			//验证
			if($OP_Webpcomment == 2){
			exit("评论被关闭:(");
			}elseif($OP_Webpcomment == 3){
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

			if (!empty($_POST["dafen"])){
			$OP_Scoring = implode('|',$_POST["dafen"]);
			}else{
			$OP_Scoring = '0';
			}
			
			if (!empty($_POST["OP_Vote"])){
			$OP_Vote = $_POST["OP_Vote"];
			}else{
			$OP_Vote = 0;
			}
			
			
			if($OP_Webpcomment == 4){
				$query = mysql_query("select `id` from `ourphp_comment` where OP_Class = ".intval($_POST["OP_Class"])." && OP_Name = '".$OP_Name."'");
				$num=mysql_num_rows($query);
				if ($num != 0){
				exit("<script language=javascript> alert('您已经评论过了，不可以重复评论！');history.go(-1);</script>");
				}
			}
			
			
			$sql="insert into `ourphp_comment` set 
			`OP_Content` = '".dowith_sql(ourphp_sensitive($_POST["content"]))."',
			`OP_Class` = '".dowith_sql($_POST["OP_Class"])."',
			`OP_Type` = '".dowith_sql($_POST["OP_Type"])."',
			`OP_Name` = '".$OP_Name."',
			`OP_Ip` = '".$OP_Ip."',
			`OP_Vote` = '".$OP_Vote."',
			`OP_Scoring` = '".$OP_Scoring."',
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

$sql="select * from `ourphp_comment` where OP_Class = ".intval($OP_Class)." && OP_Type = '".dowith_sql($OP_Type)."' order by time desc LIMIT 0,".dowith_sql($OP_Row);
$query=mysql_query($sql);
$i = 1;
while($ourphp_rs=mysql_fetch_array($query)){

$userip = preg_replace('/((?:\d{1,3}\.){3})\d{1,3}/','$1*',$ourphp_rs['OP_Ip']);
if($ourphp_rs['OP_Name'] == $userlogin){
$username = $ourphp_rs['OP_Name'];
}else{
$username = half_replace($ourphp_rs['OP_Name']);
}
$scoring = explode('|',$ourphp_rs['OP_Scoring']);

?>
  <tr>
   <td width="25%" rowspan="2" valign="top"><div align="center"><img src="../../../skin/userhead_s.jpg" border="0" /></div>
 <?php if($OP_Webpcomment == 4){ ?>
     <table width="100%" border="0" cellpadding="6" style="margin-top:20px;">
	 <?php if($ourphp_rs['OP_Vote'] != 0){ ?>
       <tr>
         <td colspan="2"><div align="center"><?php if($ourphp_rs['OP_Vote'] == 1){ ?><img src="../../../skin/1.gif" border="0" />好评<?php }elseif($ourphp_rs['OP_Vote'] == 2){ ?><img src="../../../skin/2.gif" border="0" />中评<?php }elseif($ourphp_rs['OP_Vote'] == 3){ ?><img src="../../../skin/3.gif" border="0" />差评<?php } ?></div></td>
         </tr>
	 <?php } ?>
	 <?php if($scoring[0] != 0){ ?>
       <tr>
         <td><div align="right">宝贝与描述相符度</div></td>
         <td><img src="lib/img/<?php echo $scoring[0] ?>.png" border="0" /></td>
       </tr>
       <tr>
         <td><div align="right">卖家的服务态度</div></td>
         <td><img src="lib/img/<?php echo $scoring[1] ?>.png" border="0" /></td>
       </tr>
       <tr>
         <td><div align="right">卖家的发货速度</div></td>
         <td><img src="lib/img/<?php echo $scoring[2] ?>.png" border="0" /></td>
       </tr>
	 <?php } ?>
     </table> 
<?php } ?> 
   </td>
    <td width="75%" height="20"><span style="float:right;"><?php echo $ourphp_rs['time']; ?></span><?php echo $username; ?> <font color="#CCCCCC" size="2">(<?php echo $userip; ?>)</font></td>
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
<?php if($OP_Webpcomment == 4){ ?>
  <tr>
    <td></td>
    <td><input type="radio" name="OP_Vote" value="1" /><img src="../../../skin/1.gif" border="0" />好评&nbsp;&nbsp;<input name="OP_Vote" type="radio" value="2" checked="checked" /><img src="../../../skin/2.gif" border="0" />中评&nbsp;&nbsp;<input type="radio" name="OP_Vote" value="3" /><img src="../../../skin/3.gif" border="0" />差评</td>
  </tr>
  <tr>
    <td><div align="right">打分</div>
	<input type="hidden" name="dafen[]" value="3" id="baobei" />
	<input type="hidden" name="dafen[]" value="3" id="taidu" />
	<input type="hidden" name="dafen[]" value="3" id="fahuo" />
	</td>
    <td>
	<script type="text/javascript" src="lib/jquery.min.js"></script>
	<script type="text/javascript" src="lib/jquery.raty.min.js"></script>
	<style type="text/css">
	.dafen { width:500px;}
	.font { width:100px; float:left; text-align:right; height:25px; line-height:25px; padding-right:15px;}
	.target-demo { width:300px; float:left; height:25px; line-height:25px; padding:0px; margin:0px;}
	.hint { width:100px; float:left; height:25px; line-height:25px;}
	</style>
        <div class="dafen">
		  	<div class="font">宝贝与描述相符度</div>
            <div id="targetKeep-baobei" class="target-demo"></div>
            <div id="targetKeep-hintbaobei" class="hint"></div>
          </div>
			<div style=" clear:both"></div>
          <div class="dafen">
		  	<div class="font">卖家的服务太度</div>
            <div id="targetKeep-fuwu" class="target-demo"></div>
            <div id="targetKeep-hintfuwu" class="hint"></div>
          </div>
			<div style=" clear:both"></div>
          <div class="dafen">
		  	<div class="font">卖家的发货速度</div>
            <div id="targetKeep-fahuo" class="target-demo"></div>
            <div id="targetKeep-hintfahuo" class="hint"></div>
          </div>
	
	  <script type="text/javascript">
		$(function() {
		  $.fn.raty.defaults.path = 'lib/img';
		  $('#targetKeep-baobei').raty({
			cancel    : false,
			target    : '#targetKeep-hintbaobei',
			targetKeep: true,
			score: 3,
					click: function(score) {
						$("#baobei").val(score);
					  }
		  });
		  
		  $('#targetKeep-fuwu').raty({
			cancel    : false,
			target    : '#targetKeep-hintfuwu',
			targetKeep: true,
			score: 3,
					click: function(score) {
						$("#taidu").val(score);
					  }
		  });
		  
		  $('#targetKeep-fahuo').raty({
			cancel    : false,
			target    : '#targetKeep-hintfahuo',
			targetKeep: true,
			score: 3,
					click: function(score) {
						$("#fahuo").val(score);
					  }
		  });
		});
	  </script>	
	</td>
  </tr>
<?php } ?>
  <tr>
    <td><div align="right">评论</div></td>
<?php if($OP_Webpcomment == 2){ ?>
    <td><textarea name="content" style="width:410px; height:110px; border:1px #cccccc solid;text-align:center; line-height:110px;" disabled="disabled" >评论被关闭:(</textarea></td>
<?php }elseif($OP_Webpcomment == 3){ 
			if(isset($_SESSION['username'])){
?>
			<td><textarea name="content" style="width:410px; height:110px; border:1px #cccccc solid;" ></textarea></td>
			<?php }else{ ?>
			<td><textarea name="content" style="width:410px; height:110px; border:1px #cccccc solid;text-align:center; line-height:110px;" disabled="disabled" >请登录后在评论！</textarea></td>
			<?php } ?>
			
<?php }elseif($OP_Webpcomment == 4){ 
			if($userbuy == 2){
			?>
			<td><textarea name="content" style="width:410px; height:110px; border:1px #cccccc solid;text-align:center; line-height:110px;" disabled="disabled" >您未购买过该商品，无权评价:(</textarea></td>
			<?php
			}elseif($userbuy == 1){
			?>
			<td><textarea name="content" style="width:410px; height:110px; border:1px #cccccc solid;" ></textarea></td>
			<?php
			}
?>

<?php }else{ ?>
	<td><textarea name="content" style="width:410px; height:110px; border:1px #cccccc solid;" ></textarea></td>
<?php } ?>
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