<?php  
header("Content-Type:text/html; varcharset=UTF-8"); 
header("Cache-Control:no-cache");
date_default_timezone_set('Asia/Shanghai');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; varcharset=utf-8" />
<title>OURPHP - 安装程序</title>
<style type="text/css">
	*{ margin: 0 auto; padding:0px; font-size:12px; font-family:Arial, Helvetica, sans-serif;}
	body { background:#f4f4f4;}
	#ourphp_install { width:720px; height: auto; overflow:hidden; border:1px #CCCCCC solid; padding:30px 20px 30px 20px; margin-top:80px; background:#FFFFFF;}
	#ourphp_logo { width:720px; height:40px; margin-bottom:20px;}
	#ourphp_font { width:678px; height:350px; border:1px #CCCCCC solid; background:#FFFFFF;}
	.btnGray { width:120px; height:30px; background: #CCCCCC; border:0px; color:#333333;}
	.btn { width:120px; height:30px; background:#1382b3; border:0px; color:#FFFFFF;}
	#ourhp_er h1 { width:100%; height:35px; line-height:35px; font-size:16px; color:#999999; border-bottom:1px #CCCCCC solid; margin-bottom:10px; font-weight:400;}
	h1 { width:100%; height:35px; line-height:35px; font-size:16px; color:#999999; border-bottom:1px #CCCCCC solid; margin-bottom:10px; font-weight:400;}
	#ourhp_er p { height:25px; line-height:25px; font-size:14px; color: #666666;}
	#ourphp_table td { height:35px; line-height:35px; font-size:14px; color:#666666;}
	#ourphp_table #input { width:300px; height:23px; line-height:25px; border:1px #999999 solid;}
</style>
<script language="javascript">
function agree()
{
  if (document.getElementById('btn_license').checked)
	{
    document.getElementById('submit').disabled=false;
    document.getElementById('submit').className='btn';  
	}
  else
	{
    document.getElementById('submit').disabled='disabled';  
    document.getElementById('submit').className='btnGray';  
	}
}  
</script>
</head>

<body>
<div id="ourphp_install">
	<div id="ourphp_logo"><img src="images/logo.jpg" border="0" /></div>
<?php
if(version_compare(PHP_VERSION,'5.0.0','<'))  die('错误！您的PHP版本不能低于 5.0.0 !');
if (file_exists("ourphp.lock")) {

	echo "<p align='center'><img src='../../skin/no.png' border='0'></p>";
	echo "<p align='center'>请先删除ourphp.lock文件在安装系统！</p>";
	exit();
}else {
	echo "";
}
if (intval(isset($_GET['ourphp'])) == 0) {
?>
<form action="" method="post">
<table width='100%' border='0' cellpadding="0" cellspacing="10">
  <tr>
    <td><textarea name="request" readonly="readonly" id="ourphp_font" style="padding:10px;">OURPHP网站管理系统最终用户授权许可协议

感谢您选择OURPHP傲派建站系统（以下简称OURPHP），OURPHP提供一个企业级+电商网站解决方案，基于 PHP + MySQL 的技术开发，源码开源。
OURPHP 的官方网址是： www.ourphp.net   交流论坛：www.ourphp.net/club

为了使您正确并合法的使用本软件，请您在使用前务必阅读清楚下面的协议条款： 
一、本授权协议适用于 OURPHP 所有版本，OURPHP官方对本授权协议拥有最终解释权。

二、协议许可的权利
1.您可以在完全遵守本最终用户授权协议的基础上(即必须保留页面版权的情况下)，将本软件应用于商业用途，而不必支付软件版权授权费用。
2.您可以在协议规定的约束和限制范围内修改 OURPHP 源代码或界面风格以适应您的网站要求。
3.您拥有使用本软件构建的网站全部内容所有权，并独立承担与这些内容的相关法律义务。
4.获得商业授权之后，您可以去除OURPHP的版权信息，同时依据所购买的授权类型中确定的技术支持内容，自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。

三、协议规定的约束和限制
1.未获商业授权之前，不得删除网站底部或网站标题及相应的官方版权信息和链接。OURPHP著作权已在中华人民共和国国家版权局注册(中国国家版权局著作权登记号 2015SR078193)，著作权受到法律和国际公约保护 。购买商业授权请登陆www.ourphp.net了解最新说明。
2.未经官方许可，不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。
3.不管您的网站是否整体使用 OURPHP ，还是部份栏目使用 OURPHP，在您网站页面页脚处的 Powered by OURPHP 名称和 http://www.ourphp.net 的链接都必须保留且不能修改。
4.未经官方许可，禁止在 OURPHP 的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。
5.如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。

四、有限担保和免责声明
1.本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。
2.用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺对免费用户提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。
3.电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始确认本协议并安装OURPHP，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
4.如果本软件带有其它软件的整合API示范例子包，这些文件版权不属于本软件官方，并且这些文件是没经过授权发布的，请参考相关软件的使用许可合法的使用。

版权所有 ©2014-2015 www.ourphp.net 保留所有权利。

协议发布时间：2015年1月1日

</textarea></td>
  </tr>
  <tr>
    <td style="font-size:14px; color:#999999; font-weight:bold;"><input name="confirm" type="checkbox" onclick="agree();" align="absMiddle" id="btn_license"/>&nbsp;<label for="btn_license">我认真阅读并接受以上协议。</label></td>
  </tr>
  <tr>
    <td><input type="button" class="btnGray" name="submit" value="开始安装" disabled="disabled" id="submit" onclick="location.href='index.php?ourphp=1'"/></td>
  </tr>
</table>
</form>
<?php
}elseif (intval($_GET['ourphp']) == 1) {

	function check_writeable($file)
	{
		if (file_exists($file))
		{ 
			if (is_dir($file))
			{
				$dir = $file;
				if ($fp = @fopen("$dir/test.txt", 'w'))
				{
					@fclose($fp);
					@unlink("$dir/test.txt");
					$writeable = 1;
				}
				else
				{
					$writeable = 0;
				}
			}
			else
			{
				if ($fp = @fopen($file, 'a+'))
				{
					@fclose($fp);
					$writeable = 1;
				}
				else
				{
					$writeable = 0;
				}
			}
		}
		else
		{
			$writeable = 2;
		}
	
		return $writeable;
	}

$sys_info['mysql_ver']     = extension_loaded('mysql') ? 'OK' : 'NO';
$sys_info['zlib']          = function_exists('gzclose') ? 'OK' : 'NO';
$sys_info['gd']            = extension_loaded("gd") ? 'OK' : 'NO';
$sys_info['socket']        = function_exists('fsockopen') ? 'OK' : 'NO';
$sys_info['curl_init']        = function_exists('curl_init') ? 'OK' : 'NO';

echo "<form id='form1' name='form1' method='post' action='index.php?ourphp=2'>";
echo '<div id="ourhp_er">';
echo '<h1>系统环境</h1>';
echo '<p>服务器操作系统:&nbsp;....................................................................&nbsp;'.PHP_OS.'</p>';
echo '<p>Web 服务器:&nbsp;....................................................&nbsp;'.$_SERVER['SERVER_SOFTWARE'].'</p>';
echo '<p>PHP 版本:&nbsp;....................................................................&nbsp;'.PHP_VERSION.'</p>';
echo '<p>MySQL 版本:&nbsp;....................................................................&nbsp;'.$sys_info['mysql_ver'].'</p>';
echo '<p>Zlib 支持:&nbsp;....................................................................&nbsp;'.$sys_info['zlib'].'</p>';
echo '<p>GD2 支持:&nbsp;....................................................................&nbsp;'.$sys_info['gd'].'</p>';
echo '<p>Socket 支持:&nbsp;....................................................................&nbsp;'.$sys_info['socket'].'</p>';
echo '<p>curl 支持:&nbsp;....................................................................&nbsp;'.$sys_info['curl_init'].'</p>';
echo '<h1>目录权限</h1>';

	/* 检查目录 */
	$check_dirs = array (
		'../../config',
		'../../function',
		'../../function/_compile',
		'../../function/_cache',
		'../../function/uploadfile',
		'../../function/backup'
	);
	
	$i = 0;
	foreach ($check_dirs AS $dir){
		$full_dir = $dir;
		$check_writeable = check_writeable($full_dir);
		if ($check_writeable == '1')
		{
			echo "<p>".$check_dirs[$i]."&nbsp;...................................................................&nbsp;<font color='#00CC33'>可写</font></p>";
		}
		elseif ($check_writeable == '0')
		{
			echo "<p>".$check_dirs[$i]."&nbsp;...................................................................&nbsp;<font color='#ff0000'>不可写</font></p>";
			$no_write = true;
		}
		elseif ($check_writeable == '2')
		{
			echo "<p>".$check_dirs[$i]."&nbsp;...................................................................&nbsp;<b>不存在</b></p>";
			$no_write = true;
		}
	$i = $i + 1;
	}
	echo "<h1></h1>";
	if($sys_info['gd'] == 'NO' || $sys_info['curl_init'] == 'NO'){
		exit('上面的主要组件不支持，无法安装使用！');
	}else{
		if ($check_writeable == '0' || $check_writeable == '2'){
			echo '<input type="button" class="btnGray" name="submit" value="下一步" disabled="disabled" id="submit"/>';
		}else{
			echo '<input type="submit" class="btn" name="Submit" value="下一步" />';
		}
	}
echo '</div>';
echo '</form>';
exit;
	
}elseif (intval($_GET['ourphp']) == 2) {

	echo "<form id='form1' name='form1' method='post' action='index.php?ourphp=3'>";
	echo "<table width='100%' border='0' align='center' cellpadding='10' id='ourphp_table'>";
	echo "<tr>";
	echo "<td colspan='2'><h1></h1></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>数据库连接地址：</div></td>";
	echo "<td><input name='ourphp_dburl' type='text' id='input' /> *</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>数据库登录名：</div></td>";
	echo "<td><input name='ourphp_dbname' type='text' id='input' /> *</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>数据库登录密码：</div></td>";
	echo "<td><input name='ourphp_dbpass' type='password' id='input' /> *</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>创建数据库名称：</div></td>";
	echo "<td><input name='ourphp_mydb' type='text' id='input' /> *</td> ";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>没有则创建？：</div></td>";
	echo "<td><input name='mysqladd' type='radio' value='0' checked='checked' />否 <input name='mysqladd' type='radio' value='1' />是</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td></td>";
	echo "<td><input type='submit' class='btn' name='Submit' value='下一步' /></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";
	
}elseif (intval($_GET['ourphp']) == 3) {

if ($_POST["ourphp_dburl"] == ""){
	exit('数据库连接地址不能为空:::<a href="index.php?ourphp=2">重新来过</a>');
}elseif ($_POST["ourphp_dbname"] == ""){
	exit('数据库数据库登录名:::<a href="index.php?ourphp=2">重新来过</a>');
}elseif ($_POST["ourphp_mydb"] == ""){
	exit('请先创建数据库名称:::<a href="index.php?ourphp=2">重新来过</a>');
}
	$ourphp_mydb = $_POST["ourphp_mydb"];
	$ourphp_dburl = $_POST["ourphp_dburl"];
	$ourphp_dbname = $_POST["ourphp_dbname"];
	$ourphp_dbpass = $_POST["ourphp_dbpass"];
	
//输入连接地址、账号、密码，创建一个库
$con = mysql_connect($ourphp_dburl,$ourphp_dbname,$ourphp_dbpass);
if (!$con)
  {
	die('数据库链接出错，请检查账号密码及地址是否正确: ' . mysql_error());
	exit;
  } 

if ($_POST['mysqladd'] == 0){
mysql_select_db($ourphp_mydb, $con) or die ('链接不上数据库:::<a href="index.php?ourphp=2">重新来过</a>' . mysql_error());
}else{
mysql_query("CREATE DATABASE $ourphp_mydb",$con);
}
		//echo "数据库创建成功！";
		$str_tmp="<?php\r\n"; //得到php的起始符。$str_tmp将累加
		$str_end="?>"; //php结束符
		$str_tmp.="//网站路径\r\n";
		$str_tmp.="$"."ourphp_webpath=\"/\"; \r\n";
		$str_tmp.="//登录口令\r\n";
		$str_tmp.="$"."ourphp_validation=\"12345\"; \r\n";
		$str_tmp.="//管理员默认目录 \r\n";
		$str_tmp.="$"."ourphp_adminpath=\"client/manage\"; \r\n";
		$str_tmp.="//数据库连接地址\r\n";
		$str_tmp.="$"."ourphp_mysqlurl=\"$ourphp_dburl\"; \r\n";
		$str_tmp.="//数据库连接账号\r\n";
		$str_tmp.="$"."ourphp_mysqlname=\"$ourphp_dbname\"; \r\n"; 
		$str_tmp.="//数据库连接密码\r\n";
		$str_tmp.="$"."ourphp_mysqlpass=\"$ourphp_dbpass\"; \r\n";
		$str_tmp.="//数据库名称\r\n";
		$str_tmp.="$"."ourphp_mysqldb=\"$ourphp_mydb\"; \r\n";
		$str_tmp.="//附件上传大小\r\n";
		$str_tmp.="$"."ourphp_filesize=\"1000000\"; \r\n";		
		$str_tmp.="\r\n";
		$str_tmp.="define('OURPHPNO', true);\r\n";
		$str_tmp.="define('WEB_ROOT',substr(dirname(__FILE__), 0, -7));\r\n";
		$str_tmp.="$"."conn = mysql_connect("."$"."ourphp_mysqlurl,"."$"."ourphp_mysqlname,"."$"."ourphp_mysqlpass);\r\n";
		$str_tmp.="mysql_query('set names utf8',"."$"."conn);\r\n";
		$str_tmp.="mysql_select_db("."$"."ourphp_mysqldb,"." $"."conn) or die(mysql_error());\r\n";
		$str_tmp.="if (!"."$"."conn)\r\n";
		$str_tmp.="{\r\n";
		$str_tmp.="die('Could not connect: ' . mysql_error());\r\n";
		$str_tmp.="exit;\r\n";
		$str_tmp.="}\r\n";
		$str_tmp.=$str_end; //加入结束符
		//保存文件
		$sf="../../config/ourphp_config.php"; //文件名
		$fp=fopen($sf,"w"); //写方式打开文件
		fwrite($fp,$str_tmp); //存入内容
		fclose($fp); //关闭文件

	//创建表
	mysql_select_db($ourphp_mydb, $con);
	mysql_query("set names 'utf8'",$con);
	//导入数据库
	$sql=file_get_contents("install.sql");
	$a=explode(";",$sql);
	foreach($a as $b){
	$c=$b.";";
	mysql_query($c);
	}
	mysql_close($con);
	echo "<script>location.href='index.php?ourphp=4';</script>"; 
	exit;
	
}elseif (intval($_GET['ourphp']) == 4) {

	echo "<form id='form1' name='form1' method='post' action='index.php?ourphp=5'>";
	echo "<table width='100%' border='0' align='center' cellpadding='10' id='ourphp_table'>";
	echo "<tr>";
	echo "<td colspan='2'><h1></h1></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>网站标题：</div></td>";
	echo "<td><input name='ourphp_website' type='text' id='input' /> *</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>网站地址：</div></td>";
	echo "<td><input name='ourphp_weburl' type='text' id='input' /> *&nbsp;(不要以http://开头，也不要以 / 结尾)</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>管理员登录账号：</div></td>";
	echo "<td><input name='ourphp_adminname' type='text' id='input' /> *</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>管理员登录密码：</div></td>";
	echo "<td><input name='ourphp_adminpass' type='text' id='input' /> *</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>口令码：</div></td>";
	echo "<td>12345&nbsp;&nbsp;&nbsp;(安装成功后，打开/config/ourphp_config.php&nbsp;修改口令码！)</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan='2'><h1></h1></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td></td>";
	echo "<td><input type='submit' class='btn' name='Submit' value='下一步' /></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";

}elseif (intval($_GET['ourphp']) == 5) {

if ($_POST["ourphp_website"] == ""){
	exit('网站标题为必填项:::<a href="index.php?ourphp=4">重新来过</a>');
}elseif ($_POST["ourphp_weburl"] == ""){
	exit('网站地址为必填项:::<a href="index.php?ourphp=4">重新来过</a>');
}elseif ($_POST["ourphp_adminname"] == ""){
	exit('管理员登录账号为必填项:::<a href="index.php?ourphp=4">重新来过</a>');
}elseif ($_POST["ourphp_adminpass"] == ""){
	exit('管理员登录密码为必填项:::<a href="index.php?ourphp=4">重新来过</a>');
}

	include '../../config/ourphp_config.php';
	
	$ourphp_website = $_POST["ourphp_website"];
	$ourphp_weburl = $_POST["ourphp_weburl"];
	$ourphp_adminname = $_POST["ourphp_adminname"];
	$ourphp_adminpass = substr(md5(md5($_POST["ourphp_adminpass"])),0,16);
	$ourphp_date = date("Y-m-d");

	$sqlweb = mysql_query("INSERT INTO ourphp_web (OP_Website,OP_Weburl,OP_Webtime,OP_Webstatistics,OP_Webourphpcode,OP_Webourphpu,OP_Webourphpp) values ('$ourphp_website','$ourphp_weburl','$ourphp_date','','','','')");

	$sqladmin = "insert into ourphp_admin (OP_Adminname,OP_Adminpass,OP_Adminpower,OP_Admin) values ('$ourphp_adminname','$ourphp_adminpass','01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60','1')";
	$result = mysql_query($sqladmin);
	
	$sqltemp = "insert into ourphp_temp (OP_Temppath,OP_Tempauthor) values ('default','ourphp!')";
	$result = mysql_query($sqltemp);
	
	$file = fopen("ourphp.lock",'w');
	fwrite($file,"ourphp!只有删除这个文件，才可以重新安装系统。如果不需要重新安装系统，千万不要删除此文件！");
	fclose($file);
	
	echo "<p align='center'><img src='../../skin/ok.png' border='0'></p>";
	echo "<p align='center'>恭喜您，网站安装成功！</p>";
	echo "<p align='center'>[<a href='../../'>登录前台</a>]&nbsp;&nbsp;&nbsp;&nbsp;[<a href='../../admin.php'>进入后台</a>]</p>";
	
	//导入内容
	$sqldata=file_get_contents("data.sql");
	$aa=explode(";",$sqldata);
	foreach($aa as $bb){
	$cc=$bb.";";
	mysql_query($cc);
	}
	
	exit;
}
?>
</div>
</body>
</html>