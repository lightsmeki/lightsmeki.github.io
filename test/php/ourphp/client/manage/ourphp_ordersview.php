<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';
include 'ourphp_page.class.php';
include '../../function/ourphp_navigation.class.php';

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){

		if($_POST["OP_Ordersexpress"] == 1){
		$OP_Ordersexpress = $_POST["OP_Ordersexpress2"];
		}else{
		$OP_Ordersexpress = $_POST["OP_Ordersexpress"];
		}

		if (strstr($OP_Adminpower,"34")){
			
			$sql="update `ourphp_orders` set 
			`OP_Ordersusermarket` = '".admin_sql($_POST["OP_Ordersusermarket"])."',
			`OP_Orderssend` = '".admin_sql($_POST["OP_Orderssend"])."',
			`OP_Ordersexpress` = '".admin_sql($OP_Ordersexpress)."',
			`OP_Ordersexpressnum` = '".admin_sql($_POST["OP_Ordersexpressnum"])."',
			`OP_Ordersfreight` = '".admin_sql($_POST["OP_Ordersfreight"])."',
			`OP_Ordersgotime` = '".date("Y-m-d H:i:s")."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			
			//短信提醒
			if(admin_sql($_POST["OP_Orderssend"]) == 2){
			$rs = $db-> ourphpsql("select `OP_Websitemin` from `ourphp_web` where `id` = 1"); 
			include '../../function/api/sms/index.php';
			$m = $_POST["OP_Ordersusertel"]; //接收手机号
			$c = "您的订单【".$_POST["OP_Ordersnumber"]."】我们已经发货啦，快递公司：".$OP_Ordersexpress."快递单号：".$_POST["OP_Ordersexpressnum"].$rs[0]; //短信内容
			$s = "";
			$class = "sendsms";
			$smskey->smsconfig($m,$c,$s,1,$class);
			}

			//邮件提醒			
			if(admin_sql($_POST["OP_Orderssend"]) == 2){
			$ourphp_mail = 'send';
			$OP_Ordersexpress = $OP_Ordersexpress;
			$OP_Ordersexpressnum = $_POST["OP_Ordersexpressnum"];
			$OP_Ordersnumber = $_POST["OP_Ordersnumber"];
			$OP_Useremail = admin_sql(htmlspecialchars($_POST["OP_Useremail"]));
			include '../../function/ourphp_mail.class.php';
			}
			
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_orders.php?id=ourphp';
			require 'ourphp_remind.php';
			
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_orders.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
			
}

$sql="select * from `ourphp_orders` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_orders',$ourphp_rs);
mysql_free_result($query);

$smarty->display('ourphp_ordersview.html');
?>