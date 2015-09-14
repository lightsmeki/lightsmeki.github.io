<?php
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';

if(isset($_GET["ourphp_cms"]) == ""){
	$rows = array();
}elseif ($_GET["ourphp_cms"] == "search"){

$content = admin_sql($_POST['content']);
$sid = admin_sql($_POST['sid']);
$lang = admin_sql($_POST['lang']);
$inputno = $ourphp_adminfont['inputno'];

if($content == '' || $sid == '' || $lang == ''){
exit("<script language=javascript> alert('".$inputno."');location.replace('".$ourphp_webpath."');</script>");
}

if($sid == 'article'){

				$top = '`OP_Articletitle`,`OP_Articlecontent`';
				$where = "(`OP_Articletitle` LIKE '%$content%' || `OP_Articlecontent` LIKE '%$content%')";
/* 				$where = $where.'(';
				foreach($content as $op) {
				$where = $where ."`OP_Articletitle` LIKE '%$op%' || `OP_Articlecontent` LIKE '%$op%' ||";
				}
				$where = $where.')';
				$where = str_replace('||)',')',$where); */

}elseif($sid == 'product'){

				$top = '`OP_Title`,`OP_Content`';
				$where = "(`OP_Title` LIKE '%$content%' || `OP_Content` LIKE '%$content%')";
				
}elseif($sid == 'photo'){

				$top = '`OP_Phototitle`,`OP_Photocontent`';
				$where = "(`OP_Phototitle` LIKE '%$content%' || `OP_Photocontent` LIKE '%$content%')";
				
}elseif($sid == 'video'){

				$top = '`OP_Videotitle`,`OP_Videocontent`';
				$where = "(`OP_Videotitle` LIKE '%$content%' || `OP_Videocontent` LIKE '%$content%')";
				
}elseif($sid == 'down'){

				$top = '`OP_Downtitle`,`OP_Downcontent`';
				$where = "(`OP_Downtitle` LIKE '%$content%' || `OP_Downcontent` LIKE '%$content%')";
				
}elseif($sid == 'job'){

				$top = '`OP_Jobtitle`,`OP_Jobcontent`';
				$where = "(`OP_Jobtitle` LIKE '%$content%' || `OP_Jobcontent` LIKE '%$content%')";
				
}elseif($sid == 'user'){

				$top = '`OP_Useremail`,`OP_Username`';
				$where = "(`OP_Useremail` LIKE '%$content%' || `OP_Username` LIKE '%$content%')";
				
}elseif($sid == 'orders'){

				$top = '`OP_Ordersnumber`,`OP_Ordersusername`';
				$where = "(`OP_Ordersnumber` LIKE '%$content%' || `OP_Ordersusername` LIKE '%$content%')";
				
}else{
				$top = '`OP_Articletitle`,`OP_Articlecontent`';
				$where = "(`OP_Articletitle` LIKE '%$content%' || `OP_Articlecontent` LIKE '%$content%')";
}

$sql="select `id`,".$top." from `ourphp_".$sid."` where ".$where." order by id desc";
$query=mysql_query($sql);
$rows = array();
$i=1;
while($ourphp_rs = mysql_fetch_array($query)){
		$title = str_replace($content,'<font color=red><b>'.$content.'</b></font>',$ourphp_rs[1]);
		$scontent = str_replace($content,'<font color=red><b>'.$content.'</b></font>',$ourphp_rs[2]);
		
		if($sid == 'article'){
		$url = 'ourphp_articleview.php?id='.$ourphp_rs[0];
		}elseif($sid == 'product'){
		$url = 'ourphp_productedit.php?id='.$ourphp_rs[0];
		}elseif($sid == 'photo'){
		$url = 'ourphp_photoedit.php?id='.$ourphp_rs[0];
		}elseif($sid == 'video'){
		$url = 'ourphp_videoview.php?id='.$ourphp_rs[0];
		}elseif($sid == 'down'){
		$url = 'ourphp_downview.php?id='.$ourphp_rs[0];
		}elseif($sid == 'job'){
		$url = 'ourphp_jobview.php?id='.$ourphp_rs[0];
		}elseif($sid == 'user'){
		$url = 'ourphp_userview.php?id='.$ourphp_rs[0];
		}elseif($sid == 'orders'){
		$url = 'ourphp_ordersview.php?id='.$ourphp_rs[0];
		}
		
		$rows[] = array(
						'i' => $i,
						'title' => $title,
						'content' => $scontent,
						'url' => $url,
		);
		$i+=1;
}
}
$smarty->assign('search',$rows);
$smarty->display('ourphp_adminsearch.html');
?>