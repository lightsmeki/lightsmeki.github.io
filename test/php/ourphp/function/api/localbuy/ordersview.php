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

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){

		if($_POST["OP_Ordersexpress"] == 1){
		$OP_Ordersexpress = $_POST["OP_Ordersexpress2"];
		}else{
		$OP_Ordersexpress = $_POST["OP_Ordersexpress"];
		}
			
			$sql="update `ourphp_orders` set 
			`OP_Ordersusermarket` = '".admin_sql($_POST["OP_Ordersusermarket"])."',
			`OP_Orderssend` = '".admin_sql($_POST["OP_Orderssend"])."',
			`OP_Ordersexpress` = '".admin_sql($OP_Ordersexpress)."',
			`OP_Ordersexpressnum` = '".admin_sql($_POST["OP_Ordersexpressnum"])."',
			`OP_Ordersfreight` = '".admin_sql($_POST["OP_Ordersfreight"])."',
			`OP_Ordersgotime` = '".date("Y-m-d H:i:s")."'
			 where id = ".intval($_GET['id']);
			$query=mysql_query($sql);

			//注册成功，邮件提醒			
			if(admin_sql($_POST["OP_Orderssend"]) == 2){
			$ourphp_mail = 'send';
			$OP_Ordersexpress = $OP_Ordersexpress;
			$OP_Ordersexpressnum = $_POST["OP_Ordersexpressnum"];
			$OP_Ordersnumber = $_POST["OP_Ordersnumber"];
			$OP_Useremail = admin_sql(htmlspecialchars($_POST["OP_Useremail"]));
			include '../../ourphp_mail.class.php';
			}
			
			header("location: index.php?key=".$key);
			exit(0);	
}

$sql="select * from `ourphp_orders` where `id` = ".intval($_GET['id']);
$query=mysql_query($sql);
$rs=mysql_fetch_array($query);
?>

<form id="form1" name="form1" method="post" action="ordersview.php?ourphp_cms=edit&id=<?php echo $rs['id']; ?>&key=<?php echo $key; ?>">
<table width="100%" border="1" align="center" cellpadding="5" bordercolor="#f4f4f4" style="border-collapse:collapse; font-size:12px">
  <tr>
    <td colspan="2" bgcolor="#f5f5f5">订单宝 - 订单处理:&nbsp;&nbsp;<a href="javascript:history.go(-1);">向上一页</a></td>
  </tr>
  <tr>
    <td width="12%"><div align="right">订单号：</div></td>
    <td width="88%"><?php echo $rs['OP_Ordersnumber']; ?>
					  <input type="hidden" name="OP_Ordersnumber" value="<?php echo $rs['OP_Ordersnumber']; ?>" /></td>
  </tr>
  <tr>
    <td><div align="right">订单时间：</div></td>
    <td><?php echo $rs['time']; ?></td>
  </tr>
  <tr>
    <td><div align="right">订购商品：</div></td>
    <td><?php echo $rs['OP_Ordersname']; ?></td>
  </tr>
  <tr>
    <td><div align="right">用户要求：</div></td>
    <td><?php echo $rs['OP_Ordersproductatt']; ?></td>
  </tr>
  <tr>
    <td><div align="right">备注：</div></td>
    <td><?php echo $rs['OP_Ordersusetext']; ?></td>
  </tr>
  <tr>
    <td><div align="right">网站价格：</div></td>
    <td><?php echo $rs['OP_Orderswebmarket']; ?>&nbsp;&nbsp;元</td>
  </tr>
  <tr>
    <td><div align="right">TA的价格(成交价)：</div></td>
    <td><input type="text" name="OP_Ordersusermarket" class="win3" value="<?php echo $rs['OP_Orderswebmarket']; ?>" />&nbsp;&nbsp;元</td>
  </tr>
  <tr>
    <td><div align="right">购买数量：</div></td>
    <td><?php echo $rs['OP_Ordersnum']; ?></td>
  </tr>
  <tr>
    <td><div align="right">商品重量：</div></td>
    <td><?php echo $rs['OP_Ordersweight']; ?></td>
  </tr>
  <tr>
    <td><div align="right">快递运费：</div></td>
    <td><input type="text" name="OP_Ordersfreight" class="win3" value="<?php echo $rs['OP_Ordersfreight']; ?>" />&nbsp;&nbsp;元</td>
  </tr>
  <tr>
    <td><div align="right">购买人账号：</div></td>
    <td><?php echo $rs['OP_Ordersemail']; ?>
				      <input type="hidden" name="OP_Useremail" value="<?php echo $rs['OP_Ordersemail']; ?>" /></td>
  </tr>
  <tr>
    <td><div align="right">购买人姓名：</div></td>
    <td><?php echo $rs['OP_Ordersusername']; ?></td>
  </tr>
  <tr>
    <td><div align="right">购买人电话：</div></td>
    <td><?php echo $rs['OP_Ordersusertel']; ?></td>
  </tr>
  <tr>
    <td><div align="right">发货地址：</div></td>
    <td><?php echo $rs['OP_Ordersuseradd']; ?></td>
  </tr>
  <tr>
    <td><div align="right">是否付款?：</div></td>
    <td>
	
     <?php 
	  
	if($rs['OP_Integralok'] == 0){
		if($rs['OP_Orderspay'] == 1){
		echo '<img src="../../../skin/weifukuan.gif" border="0" />';
		}else{
		echo '<img src="../../../skin/yifukuan.gif" border="0" />';
		} 
	}else{
	echo '<img src="../../../skin/jfdh.gif" border="0" />';
	}
	
	?>
	
	</td>
  </tr>
  <tr>
    <td><div align="right">是否发货?：</div></td>
    <td>

						<input name="OP_Orderssend" type="radio" value="1" <?php if ($rs['OP_Orderssend'] == 1) { ?>checked="checked"<?php }?> />
                        不发货 
                        <input type="radio" name="OP_Orderssend" value="2" <?php if ($rs['OP_Orderssend'] == 2) { ?>checked="checked"<?php }?> />
                        发货
	
	</td>
  </tr>
  <tr>
    <td><div align="right">快递名称：</div></td>
    <td>
	
					  <div style="float:left;">
					    <select name="OP_Ordersexpress" onchange = "showandhide(this.value)">
						  <option value="ems" <?php if ($rs['OP_Ordersexpress'] == 'ems') { ?>selected="selected"<?php }?> >EMS</option>
						  <option value="guotongkuaidi"  <?php if ($rs['OP_Ordersexpress'] == 'guotongkuaidi') { ?>selected="selected"<?php }?> >国通快递</option>
						  <option value="huitongkuaidi"  <?php if ($rs['OP_Ordersexpress'] == 'huitongkuaidi') { ?>selected="selected"<?php }?> >汇通快运</option>
						  <option value="lianb"  <?php if ($rs['OP_Ordersexpress'] == 'lianb') { ?>selected="selected"<?php }?> >联邦快递（国内）</option>
						  <option value="quanfengkuaidi"  <?php if ($rs['OP_Ordersexpress'] == 'quanfengkuaidi') { ?>selected="selected"<?php }?> >全峰快递</option>
						  <option value="shentong"   <?php if ($rs['OP_Ordersexpress'] == 'shentong') { ?>selected="selected"<?php }?> >申通</option>
						  <option value="shunfeng"   <?php if ($rs['OP_Ordersexpress'] == 'shunfeng') { ?>selected="selected"<?php }?> >顺丰</option>
						   <option value="tiantian"   <?php if ($rs['OP_Ordersexpress'] == 'tiantian') { ?>selected="selected"<?php }?> >天天快递</option>
						    <option value="yuantong"  <?php if ($rs['OP_Ordersexpress'] == 'yuantong') { ?>selected="selected"<?php }?> >圆通速递</option>
							 <option value="yunda"  <?php if ($rs['OP_Ordersexpress'] == 'yunda') { ?>selected="selected"<?php }?> >韵达快运</option>
							  <option value="zhaijisong"  <?php if ($rs['OP_Ordersexpress'] == 'zhaijisong') { ?>selected="selected"<?php }?> >宅急送</option>
							   <option value="zhongtiekuaiyun"  <?php if ($rs['OP_Ordersexpress'] == 'zhongtiekuaiyun') { ?>selected="selected"<?php }?> >中铁快运</option>
							    <option value="zhongtong"  <?php if ($rs['OP_Ordersexpress'] == 'zhongtong') { ?>selected="selected"<?php }?> >中通速递</option>
								<option value="1"   <?php if ($rs['OP_Ordersexpress'] == 'l') { ?>selected="selected"<?php }?> >===其它===</option>
				        </select>
						</div>
						<div id="1" style="float:left;display:none;">
						&nbsp;&nbsp;其它快递代码：
					  <input name="OP_Ordersexpress2" type="text" class="win3" value="<?php echo $rs['OP_Ordersexpress']; ?>"  />
					  (目前采用的接口不支持中文，如果是发顺发快递，请输入 shunfeng &nbsp;&nbsp;&nbsp;<a href="http://ourphp.net/kuaidiapi.html" target="_blank"><font color="#0099FF">查看快递参考代码</font></a>)
					  </div>
					  <div id="2" style="float:left;display:none;"></div>
	</td>
  </tr>
  <tr>
    <td><div align="right">快递单号：</div></td>
    <td><input name="OP_Ordersexpressnum" type="text" class="win" value="<?php echo $rs['OP_Ordersexpressnum']; ?>"  /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="处理订单" />&nbsp;&nbsp;<a href="javascript:history.go(-1);">向上一页</a></td>
  </tr>
</table>
</form>
<?php
mysql_free_result($query);
?>
<script>
 function showandhide(v){
  //alert(v);
  for(i=1;i<3;i++){
   document.getElementById(i).style.display = 'none';
   if(i==v){
    document.getElementById(v).style.display = 'block';
   }
  }
 }

function stop(){ 
return false; 
} 
document.oncontextmenu=stop; 
</script> 