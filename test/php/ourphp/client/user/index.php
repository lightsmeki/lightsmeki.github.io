<?php
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/

if(version_compare(PHP_VERSION,'5.0.0','<'))  die('错误！您的PHP版本不能低于 5.0.0 !');

include '../../config/ourphp_code.php';
include '../../config/ourphp_config.php';
include '../../config/ourphp_version.php';
include '../../config/ourphp_Language.php';
include '../../function/ourphp_function.class.php';
include '../../function/ourphp/Smarty.class.php';

//模板全局定义
session_start();
date_default_timezone_set('Asia/Shanghai'); //设置时区
$ourphp_weburl = explode('-',$_SERVER["QUERY_STRING"]);
if (empty($ourphp_weburl[0])){$ourphp_Language = $homelang[1];}else{$ourphp_Language = dowith_sql($ourphp_weburl[0]);}
if (empty($ourphp_weburl[1])){$temptype = 'cn';}else{$temptype = dowith_sql($ourphp_weburl[1]);}
if (empty($ourphp_weburl[2])){$listid = 0;}else{$listid = ourphp_Cut(intval($ourphp_weburl[2]));}
if (empty($ourphp_weburl[3])){$viewid = 0;}else{$viewid = ourphp_Cut(intval($ourphp_weburl[3]));}

$ourphp_templates = "../../templates/user";
$ourphp_templates_c = "../../function/_compile/";
$ourphp_cache = "../../function/_cache/";
$smarty = new Smarty;
$smarty->caching = false; 
$smarty->setTemplateDir($ourphp_templates);
$smarty->setCompileDir($ourphp_templates_c);
$smarty->setCacheDir($ourphp_cache);
$smarty->addPluginsDir(array(
							'../../function/class',
							'../../function/data',
));
$smarty->assign('ourphp','<h1>hello,ourphp!</h1>');
$smarty->assign('ourphp_access',$ourphp_access);
$smarty->assign('version',$ourphp_version);
$smarty->assign('webpath',$ourphp_webpath);
$smarty->assign('adminpath',$ourphp_adminpath);
$smarty->assign('tempurl','user');
$smarty->assign('templatepath',$ourphp_webpath.str_replace('../../','',$ourphp_templates)."/");
$smarty->assign('listid',$listid);


//通用类
function ourphp_web(){ 
global $ourphp_webpath,$db,$ourphp_Language,$temptype,$listid,$viewid,$Parameterse;
$ourphp_rs = $db-> ourphpsql("select * from `ourphp_web` where `id` = 1"); 
$rows = array(
					'website' => $ourphp_rs["OP_Website"],
					'weburl' => $ourphp_rs["OP_Weburl"],
					'weblogo' => $ourphp_webpath.$ourphp_rs["OP_Weblogo"],
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
					'webkeywords' => $Parameterse["keywords"],
					'webdescriptions' => $Parameterse["descriptions"],
					'webstatistics' => $ourphp_rs["OP_Webstatistics"],

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
			}else{
				if($Parameterse['rewrite'] == 1){
				$weburl = $ourphp_webpath.$ourphp_rs[2].'/'.$ourphp_rs[5].'/'.$ourphp_rs[0].'/';
				}else{
				$weburl = $ourphp_webpath.'?'.$ourphp_rs[2].'-'.$ourphp_rs[5].'-'.$ourphp_rs[0].'.html';
				}
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

function shoppingnum(){
	global $db;
	if(empty($_SESSION['username'])){
	return;
	}else{
	$ourphp_rs = $db-> sqllist("select count(id) as tiaoshu from `ourphp_shoppingcart` where `OP_Shopusername` = '".$_SESSION['username']."'"); 
	return mysql_fetch_assoc($ourphp_rs);
	}
}

function shoppingorder(){
	global $db;
	if(empty($_SESSION['username'])){
	return;
	}else{
	$ourphp_rs = $db-> sqllist("select count(id) as tiaoshu from `ourphp_orders` where `OP_Ordersemail` = '".$_SESSION['username']."' && `OP_Orderspay` = 1"); 
	return mysql_fetch_assoc($ourphp_rs);
	}
}

$smarty->assign('ourphp_web',ourphp_web());
$smarty->registerFilter('pre','smartyt');
$smarty->assign('column',indexcolumn());
$smarty->assign('ip',getIP());
$smarty->assign('shoppingcart',shoppingnum());
$smarty->assign('shoppingorder',shoppingorder());

include 'ourphp_user.class.php';
include 'ourphp_page.class.php';
include 'ourphp_template.class.php';
?>