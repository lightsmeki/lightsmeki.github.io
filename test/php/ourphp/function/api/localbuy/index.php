<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
 *-------------------------------
 * OURPHP系统 会员处理接口
 *-------------------------------
*/

include '../../../config/ourphp_code.php';
include '../../../config/ourphp_config.php';
include '../../../config/ourphp_version.php';
include '../../../config/ourphp_Language.php';
include '../../ourphp_function.class.php';
include '../../ourphp_page.class.php';
include 'key.php';

$key = $_REQUEST['key'];
if($key != $apikey || $apikey == "ourphp"){
	echo "Parameter error!";
	exit(0);
}
?>
<table width="100%" border="1" align="center" cellpadding="5" bordercolor="#f4f4f4" style="border-collapse:collapse; font-size:12px">
  <tr>
    <td colspan="8" bgcolor="#f5f5f5">订单宝管理中心:</td>
  </tr>
  <tr>
    <td width="50"><div align="center">ID</div></td>
    <td><div align="center">商品</div></td>
    <td width="160"><div align="center">订单号</div></td>
    <td width="140"><div align="center">订单时间</div></td>
    <td width="70"><div align="center">付款?</div></td>
    <td width="70"><div align="center">发货?</div></td>
    <td width="140"><div align="center">发货时间</div></td>
    <td width="110"><div align="center">操作</div></td>
  </tr>
  <?php
	$listpage = 50;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_orders` where `OP_Orderspay` = 1 || `OP_Orderssend` = 1");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select `id`,`OP_Ordersname`,`time`,`OP_Ordersnumber`,`OP_Orderspay`,`OP_Orderssend`,`OP_Ordersgotime`,`OP_Integralok` from `ourphp_orders` where `OP_Orderspay` = 1 || `OP_Orderssend` = 1 order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	while($rs=mysql_fetch_array($query)){
  ?>
  <tr>
    <td><div align="center"><?php echo $rs[0]; ?></div></td>
    <td><?php echo $rs[1]; ?></td>
    <td><div align="center"><?php echo $rs[3]; ?></div></td>
    <td><div align="center"><?php echo $rs[2]; ?></div></td>
    <td><div align="center">
    <?php 
		if($rs[4] == 1){
		echo '<img src="../../../skin/weifukuan.gif" border="0" />';
			}else{
		echo '<img src="../../../skin/yifukuan.gif" border="0" />';
		} 
	?>
    </div></td>
    <td><div align="center">
    <?php 
		if($rs[5] == 1){
		echo '<img src="../../../skin/weifahuo.gif" border="0" />';
			}else{
		echo '<img src="../../../skin/yifahuo.gif" border="0" />';
		} 
	?>
    </div></td>
    <td><div align="center"><?php echo $rs[6]; ?></div></td>
    <td><div align="center"><a href="ordersview.php?id=<?php echo $rs[0]; ?>&key=<?php echo $key; ?>" target="_self"><img src="../../../skin/chulidingdan.gif" border="0" /></a></div></td>
  </tr>
  <?php
}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	mysql_free_result($query);

	// 最新订单提醒
	session_start();
	
	if (isset($_SESSION['tiaoshu']) < 1){
	echo '<embed src="ourphp.mp3" align="baseline" border="0" width="0" height="0" type="application/x-mplayer2" pluginspage="http://www.microsoft.com/isapi/redir.dll?prd=windows&sbp=mediaplayer&ar=media&sba=plugin&" name="MediaPlayer" autostart="1" defaultframe="datawindow">';
	$_SESSION['tiaoshu'] = $ourphptotal['tiaoshu'];
	}else{
	
		if($ourphptotal['tiaoshu'] > $_SESSION['tiaoshu']){
		
		echo '<embed src="ourphp.mp3" align="baseline" border="0" width="0" height="0" type="application/x-mplayer2" pluginspage="http://www.microsoft.com/isapi/redir.dll?prd=windows&sbp=mediaplayer&ar=media&sba=plugin&" name="MediaPlayer" autostart="1" defaultframe="datawindow">';
		$_SESSION['tiaoshu'] = $ourphptotal['tiaoshu'];
	
		}else{
		
		$_SESSION['tiaoshu'] = $ourphptotal['tiaoshu'];
		
		}
	}
  ?>
  <tr>
    <td colspan="6">
		<?php echo $_page->showpage(); ?>
	</td>
    <td width="140"><div align="right">未处理订单总量:</div></td>
    <td width="110"><div align="left">(<?php echo $_SESSION['tiaoshu']; ?>)</div></td>
  </tr>
</table>
<script> 
function stop(){ 
return false; 
} 
document.oncontextmenu=stop; 
</script> 