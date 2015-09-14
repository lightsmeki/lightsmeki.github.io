<?php
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/


//模板全局定义
session_start();
date_default_timezone_set('Asia/Shanghai'); //设置时区
$ourphp_weburl = explode('-',$_SERVER["QUERY_STRING"]);
if (empty($ourphp_weburl[0])){$ourphp_Language = $homelang[2];}else{$ourphp_Language = dowith_sql($ourphp_weburl[0]);}
if (empty($ourphp_weburl[1])){$temptype = 'cn';}else{$temptype = dowith_sql($ourphp_weburl[1]);}
if (empty($ourphp_weburl[2])){$listid = 0;}else{$listid = ourphp_Cut(intval($ourphp_weburl[2]));}
if (empty($ourphp_weburl[3])){$viewid = 0;}else{$viewid = ourphp_Cut(intval($ourphp_weburl[3]));}

function ourphp_parameters(){ 
global $db;
$ourphp_rs = $db-> ourphpsql("select `OP_Weboff`,`OP_Webofftext`,`OP_Webrewrite`,`OP_Webpage`,`OP_Webkeywords`,`OP_Webkeywordsto`,`OP_Webdescriptions`,`OP_Webweight` ,`OP_Searchtime` from `ourphp_webdeploy` where `id` = 1"); 
$rows = array(
					'weboff' => $ourphp_rs[0],
					'webofftext' => $ourphp_rs[1],
					'rewrite' => $ourphp_rs[2],
					'page' => explode(",",$ourphp_rs[3]),
					'keywordsk' => $ourphp_rs[4],
					'keywords' => $ourphp_rs[5],
					'descriptions' => $ourphp_rs[6],
					'weight' => $ourphp_rs[7],
					'searchtime' => $ourphp_rs[8],
			);
return $rows;
}
$Parameterse = ourphp_parameters();

if ($Parameterse['weboff'] == 2){
	echo $Parameterse['webofftext'];
	exit;
}


$ourphp_templates = "../../templates/wap";
$ourphp_templates_c = "../../function/_compile/";
$ourphp_cache = "function/_cache/";
$ourphp_Othercache = "../../function/_cache/";
$smarty = new Smarty;
$smarty->caching = false; 
$smarty->setTemplateDir($ourphp_templates);
$smarty->setCompileDir($ourphp_templates_c);
$smarty->setCacheDir($ourphp_Othercache);
$smarty->addPluginsDir(array(
							'../../function/class',
							'../../function/data',
));
$smarty->assign('ourphp','<h1>hello,ourphp!</h1>');
$smarty->assign('ourphp_access',$ourphp_access);
$smarty->assign('version',$ourphp_version);
$smarty->assign('webpath',$ourphp_webpath);
$smarty->assign('adminpath',$ourphp_adminpath);
$smarty->assign('templatepath',$ourphp_webpath.str_replace('../../','',$ourphp_templates)."/");
$smarty->assign('listid',$listid);


//通用类
function ourphp_wap(){ 
global $ourphp_webpath,$db,$ourphp_Language,$temptype,$listid,$viewid,$Parameterse;
$ourphp_rs = $db-> ourphpsql("select * from `ourphp_wap` where `id` = 1"); 
$rows = array(
					$ourphp_rs["OP_Website"],
					$ourphp_rs["OP_Weburl"],
					$ourphp_webpath.$ourphp_rs["OP_Weblogo"],
					$ourphp_rs["OP_Webkeywords"],
					$ourphp_rs["OP_Webdescriptions"],
					$ourphp_rs["OP_Weburl"],
);
return $rows;
}

function ourphp_web(){ 
global $ourphp_webpath,$db,$ourphp_Language,$temptype,$listid,$viewid,$Parameterse;
$ourphp_wap = ourphp_wap();
$ourphp_rs = $db-> ourphpsql("select * from `ourphp_web` where `id` = 1"); 
$rows = array(
					'website' => $ourphp_wap[0],
					'gourl' => $ourphp_wap[1],
					'weblogo' => $ourphp_wap[2],
					'webname' => $ourphp_rs["OP_Webname"],
					'webadd' => $ourphp_rs["OP_Webadd"],
					'webtel' => $ourphp_rs["OP_Webtel"],
					'webmobi' => $ourphp_rs["OP_Webmobi"],
					'webfax' => $ourphp_rs["OP_Webfax"],
					'webemail' => $ourphp_rs["OP_Webemail"],
					'webzip' => $ourphp_rs["OP_Webzip"],
					'webqq' => $ourphp_rs["OP_Webqq"],
					'weblinkman' => $ourphp_rs["OP_Weblinkman"],
					'webicp' => $ourphp_rs["OP_Webicp"],
					'webtime' => $ourphp_rs["OP_Webtime"],
					'webkeywords' => $ourphp_wap[3],
					'webdescriptions' => $ourphp_wap[4],
					'webstatistics' => $ourphp_rs["OP_Webstatistics"],
					'by' => footby(),
					'waptopc' => $ourphp_wap[5],
);
return $rows;
}

function indexcolumn() { 
    global $db,$ourphp_Language,$ourphp_webpath,$Parameterse; 
	$query = $db-> sqllist("select id,OP_Uid,OP_Lang,OP_Columntitle,OP_Columntitleto,OP_Model,OP_Url,OP_Briefing,OP_Img from `ourphp_column` where OP_Hide = 0 and OP_Lang = '".$ourphp_Language."' order by OP_Sorting asc,id desc");
	$rows=array();
	$i=1;
        while($ourphp_rs = mysql_fetch_array($query)){
			if($ourphp_rs[5] == 'weburl'){
				$weburl = "$ourphp_rs[6]";
				$wapurl = "$ourphp_rs[6]";
			}else{
				if($Parameterse['rewrite'] == 1){
				$weburl = $ourphp_webpath.$ourphp_rs[2].'/'.$ourphp_rs[5].'/'.$ourphp_rs[0].'/';
				}else{
				$weburl = $ourphp_webpath.'?'.$ourphp_rs[2].'-'.$ourphp_rs[5].'-'.$ourphp_rs[0].'.html';
				}
				$wapurl = $ourphp_webpath.'client/wap/?'.$ourphp_rs[2].'-'.$ourphp_rs[5].'-'.$ourphp_rs[0].'.html';
			}
			if(substr($ourphp_rs[8],0,7) == 'http://'){$minimg = $ourphp_rs[8];}elseif($ourphp_rs[8] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[8];}
            $rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"uid" => $ourphp_rs[1],
						"title" => $ourphp_rs[3],
						"titleto" => $ourphp_rs[4],
						"url" => $weburl,
						"briefing" => $ourphp_rs[7],
						"img" => $minimg,
						"wapurl" => $wapurl,
						); 
		$i+=1;
		}
	include '../../function/ourphp_Tree.class.php';
	$op= new Tree($rows);
	$arr=$op->leaf();
    return $arr;
	mysql_free_result($query);
}

//获取IP等常用参数
function getIP(){
	global $ourphp_Language,$temptype,$listid,$viewid;
	if (@$_SERVER["HTTP_X_FORWARDED_FOR"]){
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
			}elseif (@$_SERVER["HTTP_CLIENT_IP"]){
		$ip = $_SERVER["HTTP_CLIENT_IP"]; 
			}elseif (@$_SERVER["REMOTE_ADDR"]){
		$ip = $_SERVER["REMOTE_ADDR"]; 
			}elseif (@getenv("HTTP_X_FORWARDED_FOR")){
		$ip = getenv("HTTP_X_FORWARDED_FOR"); 
			}elseif (@getenv("HTTP_CLIENT_IP")){
		$ip = getenv("HTTP_CLIENT_IP"); 
			}elseif (@getenv("REMOTE_ADDR")){
		$ip = getenv("REMOTE_ADDR"); 
			}else{
		$ip = "Unknown"; 
		}
		$rows = array(
						'ip' => $ip,
						'lang' => $ourphp_Language,
						'type' => $temptype,
						'listid' => $listid,
						'viewid' => $viewid,
					);
	return $rows; 
}

function columncycle($id=1){
	global $conn,$db,$ourphp_webpath,$Parameterse;
	$ourphp_rs = $db-> ourphpsql("select `id`,`OP_Lang`,`OP_Columntitle`,`OP_Model` from `ourphp_column` where id = $id"); 
	if($Parameterse['rewrite'] == 1){
		$url = $ourphp_webpath.$ourphp_rs[1].'/'.$ourphp_rs[3].'/'.$ourphp_rs[0].'/';
		}else{
		$url = $ourphp_webpath.'?'.$ourphp_rs[1].'-'.$ourphp_rs[3].'-'.$ourphp_rs[0].'.html';
	}
	$rows = array(
						'title' => $ourphp_rs[2],
						'url' => $url,
					);
	return $rows; 
}

function ourphp_adoverall($type,$temptype){
	global $ourphp_webpath,$db,$ourphp_cache;
	if($temptype == 'article' || $temptype == 'articleview'){
	$adclass = '文章';
	}elseif($temptype == 'product' || $temptype == 'productview'){
	$adclass = '商品';
	}elseif($temptype == 'photo' || $temptype == 'photoview'){
	$adclass = '图集';
	}elseif($temptype == 'video' || $temptype == 'videoview'){
	$adclass = '视频';
	}elseif($temptype == 'down' || $temptype == 'downview'){
	$adclass = '下载';
	}elseif($temptype == 'job' || $temptype == 'jobview'){
	$adclass = '招聘';
	}elseif($temptype == 'about'){
	$adclass = '单页面';
	}else{
	$adclass = '首页';
	}
	$fsomd5 = md5($type.$adclass);

	if(!is_file(WEB_ROOT.'/'.$ourphp_cache.'ad_'.$fsomd5.'.txt')){
	switch($type){
	case "head":
		$ourphp_rs = $db-> ourphpsql("select OP_Adcontent,OP_Adclass from `ourphp_ad` where `id` = 1");
		if(strpos(', '.$ourphp_rs[1],$adclass) > 0){
			$content = $ourphp_rs[0];
		}else{
			$content = '';
		}
		ourphp_file($ourphp_cache.'ad_'.$fsomd5.'.txt',$content,1);
	break;
	
	case "foot":
		$ourphp_rs = $db-> ourphpsql("select OP_Adcontent,OP_Adclass from `ourphp_ad` where `id` = 2");
		if(strpos(', '.$ourphp_rs[1],$adclass) > 0){
			$content = $ourphp_rs[0];
		}else{
			$content = '';
		}
		ourphp_file($ourphp_cache.'ad_'.$fsomd5.'.txt',$content,1);
	break;

	case "list":
		$ourphp_rs = $db-> ourphpsql("select OP_Adcontent,OP_Adclass from `ourphp_ad` where `id` = 3");
		if(strpos(', '.$ourphp_rs[1],$adclass) > 0){
			$content = $ourphp_rs[0];
		}else{
			$content = '';
		}
		ourphp_file($ourphp_cache.'ad_'.$fsomd5.'.txt',$content,1);
	break;
	
	case "view":
		$ourphp_rs = $db-> ourphpsql("select OP_Adcontent,OP_Adclass from `ourphp_ad` where `id` = 4");
		if(strpos(', '.$ourphp_rs[1],$adclass) > 0){
			$content = $ourphp_rs[0];
		}else{
			$content = '';
		}
		ourphp_file($ourphp_cache.'ad_'.$fsomd5.'.txt',$content,1);
	break;
	}
	
	}else{
		$content = file_get_contents(WEB_ROOT.'/'.$ourphp_cache.'ad_'.$fsomd5.'.txt');
	}
	return $content;
}

function ourphp_ad($type){
	global $ourphp_webpath,$db,$ourphp_cache;
	$fsomd5 = md5($type);
	if(!is_file(WEB_ROOT.'/'.$ourphp_cache.'ad_'.$fsomd5.'.txt')){
	switch($type){
	case "Float":
			$ourphp_rs = $db-> ourphpsql("select OP_Adpiaofui,OP_Adpiaofuu,OP_Adstateo from `ourphp_ad` where `id` = 5");
			if($ourphp_rs[2] == 1){
			if(substr($ourphp_rs[0],0,7) == 'http://'){$minimg = $ourphp_rs[0];}elseif($ourphp_rs[0] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[0];}
			$ad = '<script src="'.$ourphp_webpath.'function/plugs/ad/piaofu.js" language="JavaScript"></script>'
				 .'<div id="piaofu" style="z-index:99999;">'
				 .'<a href="'.$ourphp_rs[1].'" target="_blank"><img src="'.$minimg.'" border="0"></a>'
				 .'</div>'
				 .'<script>'
				 .'var piaofurun=new AdMove("piaofu");'
				 .'piaofurun.Run();'
				 .'</script>';
			}else{
			$ad = '';
			}
			ourphp_file($ourphp_cache.'ad_'.$fsomd5.'.txt',$ad,1);
	break;
	
	case "Right":
			$ourphp_rs = $db-> ourphpsql("select OP_Adyouxiat,OP_Adyouxiaf,OP_Adstatet from `ourphp_ad` where `id` = 5");
			if($ourphp_rs[2] == 1){
			$ad = '<div id="msg_win" style="display:block;top:490px;visibility:visible;opacity:1;">'
				 .'<div class="icos"><a id="msg_min" title="最小化" href="javascript:void 0"></a>'
				 .'<a id="msg_close" title="关闭" href="javascript:void 0">×</a></div>'
				 .'<div id="msg_title">'.$ourphp_rs[0].'</div>'
				 .'<div id="msg_content">'.$ourphp_rs[1].'</div>'
				 .'</div>'
				 .'<script src="'.$ourphp_webpath.'function/plugs/ad/tc.js" language="JavaScript"></script>'
				 .'<LINK href="'.$ourphp_webpath.'function/plugs/ad/tc.css" type=text/css rel=stylesheet>';
			}else{
			$ad = '';
			}
			ourphp_file($ourphp_cache.'ad_'.$fsomd5.'.txt',$ad,1);
	break;
	
	case "Double":
			$ourphp_rs = $db-> ourphpsql("select OP_Adduilianli,OP_Adduilianlu,OP_Adduilianri,OP_Adduilianru,OP_Adstates  from `ourphp_ad` where `id` = 5");
			if($ourphp_rs[4] == 1){
			if(substr($ourphp_rs[0],0,7) == 'http://'){$minimg = $ourphp_rs[0];}elseif($ourphp_rs[0] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[0];}
			if(substr($ourphp_rs[2],0,7) == 'http://'){$maximg = $ourphp_rs[2];}elseif($ourphp_rs[2] == ''){$maximg = $ourphp_webpath.'skin/noimage.png';}else{$maximg=$ourphp_webpath.$ourphp_rs[2];}
			$ad = '<DIV id="lovexin12" style="left:22px;POSITION:absolute;TOP:69px;z-index:99999;">'
				 .'<a href="'.$ourphp_rs[1].'" target="_blank"><img src="'.$minimg.'" border="0"></a>'
				 .'<br><a href=JavaScript:; onclick="document.getElementById("lovexin12").style.display="none";"><img border="0" src="'.$ourphp_webpath.'function/plugs/ad/close.gif"></a>'
				 .'</DIV>'
				 .'<DIV id="lovexin14" style="right:22px;POSITION:absolute;TOP:69px;z-index:99999;">'
				 .'<a href="'.$ourphp_rs[3].'" target="_blank"><img src="'.$maximg.'" border="0"></a>'
				 .'<br><a href=JavaScript:; onclick="document.getElementById("lovexin14").style.display="none";"><img border="0" src="'.$ourphp_webpath.'function/plugs/ad/close.gif"></a>'
				 .'</DIV>'
				 .'<script src="'.$ourphp_webpath.'function/plugs/ad/duilian.js" language="JavaScript"></script>'
				 .'<script>window.setInterval("heartBeat()",1);</script>';
			}else{
			$ad = '';
			}
			ourphp_file($ourphp_cache.'ad_'.$fsomd5.'.txt',$ad,1);
	break;
	}
	
	}else{
		$ad = file_get_contents(WEB_ROOT.'/'.$ourphp_cache.'ad_'.$fsomd5.'.txt');
	}
	return $ad;
}

function ourphp_brand(){
	global $ourphp_webpath,$db,$ourphp_Language;
	$query = $db-> sqllist("select id,OP_Brand,OP_Class,OP_Img,time from `ourphp_productcp` where OP_Class = 2 order by id desc");
	$rows=array();
	$i=1;
        while($ourphp_rs = mysql_fetch_array($query)){
		if(substr($ourphp_rs[3],0,7) == 'http://'){$maximg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$maximg = $ourphp_webpath.'skin/noimage.png';}else{$maximg=$ourphp_webpath.$ourphp_rs[3];}
            $rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"title" => $ourphp_rs[1],
						"class" => $ourphp_rs[2],
						"minimg" => $maximg,
						"time" => $ourphp_rs[4],
						"url" => $ourphp_webpath.'?'.$ourphp_Language.'-brand-'.$ourphp_rs[0].'.html',
						"wapurl" => $ourphp_webpath.'client/wap/?'.$ourphp_Language.'-brand-'.$ourphp_rs[0].'.html',
						); 
		$i+=1;
		}
    return $rows;
	mysql_free_result($query);
}


function opcmsbrand($id=0) { 
global $db,$ourphp_webpath;
	if($id == 0){
	return ;
	}else{
		$ourphp_rs = $db-> ourphpsql("select OP_Brand,OP_Img from `ourphp_productcp` where `id` = ".$id); 
		if(substr($ourphp_rs[1],0,7) == 'http://'){$minimg = $ourphp_rs[1];}elseif($ourphp_rs[1] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[1];}
		$rows = array(
							'title' => $ourphp_rs[0],
							'minimg' => $minimg,
		);
	return $rows;
	}
}

$smarty->assign('mobile',isMobile());
$smarty->registerFilter('pre','smartyt');
$smarty->assign('ourphp_web',ourphp_web());
$smarty->assign('column',indexcolumn());
$smarty->assign('ip',getIP());
$smarty->assign('ad',array('head'=>ourphp_adoverall('head',$temptype),'foot'=>ourphp_adoverall('foot',$temptype),'list'=>ourphp_adoverall('list',$temptype),'view'=>ourphp_adoverall('view',$temptype)));
$smarty->assign('advert',array('float'=>ourphp_ad('Float'),'right'=>ourphp_ad('Right'),'double'=>ourphp_ad('Double')));
$smarty->assign('brandclass',ourphp_brand());
?>