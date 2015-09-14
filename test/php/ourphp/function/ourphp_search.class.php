<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

//计算搜索间隔
if (isset($_SESSION['searchtime']) == ""){
	$_SESSION['searchtime'] = date("YmdHis");
}else{
	$ourphptime = date("YmdHis");
	$ourphptime_two = $ourphptime - $_SESSION['searchtime'];
	
	if($ourphptime_two == 0){
		$_SESSION['searchtime'] = date("YmdHis");
	}elseif($ourphptime_two < $Parameterse['searchtime']){
		echo "<script language=javascript> alert('搜索间隔为:".$Parameterse['searchtime']."秒,请稍后在试!');history.go(-1);</script>";
		exit;
	}else{
		$_SESSION['searchtime'] = date("YmdHis");
	}
}

//$content = explode(' ',dowith_sql($_POST['content']));
$content = dowith_sql($_REQUEST['content']);
$sid = dowith_sql($_REQUEST['sid']);
$lang = dowith_sql($_REQUEST['lang']);
$inputno = $ourphp_adminfont['inputno'];
$strlength = $ourphp_adminfont['strlength'];
@$type = dowith_sql($_REQUEST['type']);
if(empty($type)){
	$type = 'pc';
}else{
	$type = $type;
}

if($content == '' || $sid == '' || $lang == ''){
exit("<script language=javascript> alert('".$inputno."');location.replace('".$ourphp_webpath."');</script>");
}
if(strlen($content)>40){
exit("<script language=javascript> alert('".$strlength."');location.replace('".$ourphp_webpath."');</script>");
}
if(@dowith_sql($_GET['temp'])=='search'){
header("location: search.php?".$lang."-&content=".$content."&lang=".$lang."&sid=".$sid."&type=".$type);
}

if($sid == 'article'){

				$top = '`OP_Articletitle`,`OP_Articlecontent`,`OP_Minimg`';
				$where = "(`OP_Articletitle` LIKE '%$content%' || `OP_Articlecontent` LIKE '%$content%')";
/* 				$where = $where.'(';
				foreach($content as $op) {
				$where = $where ."`OP_Articletitle` LIKE '%$op%' || `OP_Articlecontent` LIKE '%$op%' ||";
				}
				$where = $where.')';
				$where = str_replace('||)',')',$where); */

}elseif($sid == 'product'){

				$top = '`OP_Title`,`OP_Content`,`OP_Minimg`';
				$where = "(`OP_Title` LIKE '%$content%' || `OP_Content` LIKE '%$content%')";
				
}elseif($sid == 'photo'){

				$top = '`OP_Phototitle`,`OP_Photocontent`,`OP_Photocminimg`';
				$where = "(`OP_Phototitle` LIKE '%$content%' || `OP_Photocontent` LIKE '%$content%')";
				
}elseif($sid == 'video'){

				$top = '`OP_Videotitle`,`OP_Videocontent`,`OP_Videoimg`';
				$where = "(`OP_Videotitle` LIKE '%$content%' || `OP_Videocontent` LIKE '%$content%')";
				
}elseif($sid == 'down'){

				$top = '`OP_Downtitle`,`OP_Downcontent`,`OP_Downimg`';
				$where = "(`OP_Downtitle` LIKE '%$content%' || `OP_Downcontent` LIKE '%$content%')";
				
}elseif($sid == 'job'){

				$top = '`OP_Jobtitle`,`OP_Jobcontent`,`OP_Jobwork`';
				$where = "(`OP_Jobtitle` LIKE '%$content%' || `OP_Jobcontent` LIKE '%$content%')";
				
}else{
				exit($ourphp_adminfont['accessno']);
}
$listpage = 25;
if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
$start=($listpagesum-1)*$listpage;
$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_".$sid."` where ".$where." && `OP_Lang` = '".$lang."'");
$ourphptotal=mysql_fetch_assoc($ourphptotal);

$query = $db-> sqllist("select `id`,".$top.",`OP_Class` from `ourphp_".$sid."` where ".$where." && `OP_Lang` = '".$lang."' order by OP_Sorting asc,id desc LIMIT ".$start.",".$listpage); 
$rows = array();
$i=1;
while($ourphp_rs = mysql_fetch_array($query)){
		$title = str_replace($content,'<font color=red><b>'.$content.'</b></font>',$ourphp_rs[1]);
		$scontent = str_replace($content,'<font color=red><b>'.$content.'</b></font>',$ourphp_rs[2]);
		if($sid == 'job'){$minimg = $ourphp_webpath.'skin/noimage.png';}else{
		if(substr($ourphp_rs[3],0,7) == 'http://'){$minimg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[3];}
		}
		$rows[] = array(
						'i' => $i,
						'title' => $title,
						'content' => strip_tags($scontent),
						'url' => $ourphp_webpath.'?'.$lang.'-'.$sid.'view-'.$ourphp_rs[4].'-'.$ourphp_rs[0].'.html',
						'minimg' => $minimg,
						'wapurl' => $ourphp_webpath.'client/wap/?'.$lang.'-'.$sid.'view-'.$ourphp_rs[4].'-'.$ourphp_rs[0].'.html',
		);
		$i+=1;
}

$query = $db-> sqllist("select `id` from `ourphp_search` where `OP_Searchtext` = '".$content."'");
$num=mysql_num_rows($query);
if ($num != 0){
	$query = $db-> sqllist("update `ourphp_search` set `OP_Searchclick` = `OP_Searchclick` + 1 where `OP_Searchtext` = '".$content."'");
}else{
	$query = $db-> sqllist("insert into `ourphp_search` set 
							`OP_Searchtext` = '".dowith_sql($content)."',
							`OP_Searchclick` = 0,
							`time` = '".date("Y-m-d H:i:s")."'
							");
}

$_page = new Page($ourphptotal['tiaoshu'],$listpage);
$smarty->assign('ourphppage',$_page->showpage());
$smarty->assign('search',$rows);
?>