<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

function smarty_block_ourphp($params, $content, &$smarty, &$repeat){
global $ourphp_access,$ourphp_webpath,$db,$Parameterse;
$form = isset($params['form'])?$params['form']:"article";
$lang = isset($params['lang'])?$params['lang']:"cn";
$limit = isset($params['row'])?$params['row']:1;
$id = isset($params['id'])?$params['id']:0;
$type = isset($params['type'])?$params['type']:'op';
$sql = isset($params['sql'])?$params['sql']:'';
		
	extract($params);  
	if (! isset ( $params['name'] )){
		$return = 'ourphp';
	}else{
		$return = $params['name'];
	}

    if(!isset($smarty->block_data))
	$smarty->block_data = array();	
		
	$dataindex = md5(__FUNCTION__ . md5(serialize($params)));  
    $dataindex = substr($dataindex,0,16);

    if (@!$smarty->block_data[$dataindex]){
	global $db;
	if ($type == 'op'){
			$Attribute = "";
	}else{
			$Attribute = " and OP_Attribute like '%".$type."%' ";
	}
	if ($id == 0){
			$where = "`OP_Lang` = '".$lang."'".$Attribute.$sql;
				}else{
			$where = "`OP_Class` in (".$id.")".$Attribute.$sql;
	}
		
	switch($form){
		case "article":
		$query = $db-> sqllist("select id,OP_Articletitle,OP_Articleauthor,OP_Articlesource,time,OP_Url,OP_Description,OP_Click,OP_Class,OP_Minimg from `ourphp_".$form."` where ".$where." && `OP_Callback` = 0 order by id desc LIMIT 0,".$limit);
		$rs=array();
		$i = 1;
		while($ourphp_rs=mysql_fetch_array($query)){
		if ($ourphp_rs[5] == ''){
		if($Parameterse['rewrite'] == 1){
		$url = $ourphp_webpath.$lang.'/articleview/'.$ourphp_rs[8].'/'.$ourphp_rs[0].'/';
		}else{
		$url = $ourphp_webpath.'?'.$lang.'-articleview-'.$ourphp_rs[8].'-'.$ourphp_rs[0].'.html';
		}
		$wapurl = $ourphp_webpath.'client/wap/?'.$lang.'-articleview-'.$ourphp_rs[8].'-'.$ourphp_rs[0].'.html';
		}else{$url=$ourphp_rs[5];$wapurl = $ourphp_rs[5];}
		if(substr($ourphp_rs[9],0,7) == 'http://'){$minimg = $ourphp_rs[9];}elseif($ourphp_rs[9] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_rs[9];}
				$rs[]=array (
								"i" => $i,
								"id" => $ourphp_rs[0],
								"title" => $ourphp_rs[1],
								"author" => $ourphp_rs[2],
								"source" => $ourphp_rs[3],
								"time" => $ourphp_rs[4],
								"description" => $ourphp_rs[6],
								"url" => $url,
								"click" => $ourphp_rs[7],
								"minimg" => $minimg,
								"wapurl" => $wapurl,
								"column" => columncycle($ourphp_rs[8]),
							);
			$i+=1;
		}
		break;
		case "product":
		$query = $db-> sqllist("select id,OP_Title,OP_Number,OP_Goodsno,OP_Brand,OP_Market,OP_Webmarket,OP_Stock,OP_Minimg,OP_Maximg,OP_Url,OP_Description,OP_Click,time,OP_Class,OP_Integral,OP_Integralexchange from `ourphp_".$form."` where ".$where." && `OP_Down` = 2 order by id desc LIMIT 0,".$limit);
		$rs=array();
		$i = 1;
		while($ourphp_rs=mysql_fetch_array($query)){
		if ($ourphp_rs[10] == ''){
		if($Parameterse['rewrite'] == 1){
		$url = $ourphp_webpath.$lang.'/productview/'.$ourphp_rs[14].'/'.$ourphp_rs[0].'/';
		}else{
		$url = $ourphp_webpath.'?'.$lang.'-productview-'.$ourphp_rs[14].'-'.$ourphp_rs[0].'.html';
		}
		$wapurl = $ourphp_webpath.'client/wap/?'.$lang.'-productview-'.$ourphp_rs[14].'-'.$ourphp_rs[0].'.html';
		}else{$url=$ourphp_rs[10];$wapurl = $ourphp_rs[10];}
		if(substr($ourphp_rs[8],0,7) == 'http://'){$minimg = $ourphp_rs[8];}elseif($ourphp_rs[8] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[8];}
		if(substr($ourphp_rs[9],0,7) == 'http://'){$maximg = $ourphp_rs[9];}elseif($ourphp_rs[9] == ''){$maximg = $ourphp_webpath.'skin/noimage.png';}else{$maximg=$ourphp_webpath.$ourphp_rs[9];}
				$rs[]=array (
								"i" => $i,
								"id" => $ourphp_rs[0],
								"title" => $ourphp_rs[1],
								"number" => $ourphp_rs[2],
								"goodsno" => $ourphp_rs[3],
								"brand" => opcmsbrand($ourphp_rs[4]),
								"market" => $ourphp_rs[5],
								"webmarket" => $ourphp_rs[6],
								"stock" => $ourphp_rs[7],
								"minimg" => $minimg,
								"maximg" => $maximg,
								"url" => $url,
								"description" => $ourphp_rs[11],
								"click" => $ourphp_rs[12],
								"time" => $ourphp_rs[13],
								"wapurl" => $wapurl,
								"column" => columncycle($ourphp_rs[14]),
								"integral" => $ourphp_rs[15],
								"integralexchange" => $ourphp_rs[16],
							);
			$i+=1;
		}
		break;
		case "photo":
		$query = $db-> sqllist("select id,OP_Phototitle,time,OP_Photocminimg,OP_Url,OP_Description,OP_Click,OP_Class from `ourphp_".$form."` where ".$where." && `OP_Callback` = 0 order by id desc LIMIT 0,".$limit);
		$rs=array();
		$i = 1;
		while($ourphp_rs=mysql_fetch_array($query)){
		if ($ourphp_rs[4] == ''){
		if($Parameterse['rewrite'] == 1){
		$url = $ourphp_webpath.$lang.'/photoview/'.$ourphp_rs[7].'/'.$ourphp_rs[0].'/';
		}else{
		$url = $ourphp_webpath.'?'.$lang.'-photoview-'.$ourphp_rs[7].'-'.$ourphp_rs[0].'.html';
		}
		$wapurl = $ourphp_webpath.'client/wap/?'.$lang.'-photoview-'.$ourphp_rs[7].'-'.$ourphp_rs[0].'.html';
		}else{$url=$ourphp_rs[4];$wapurl = $ourphp_rs[4];}
		if(substr($ourphp_rs[3],0,7) == 'http://'){$minimg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[3];}
				$rs[]=array (
								"i" => $i,
								"id" => $ourphp_rs[0],
								"title" => $ourphp_rs[1],
								"time" => $ourphp_rs[2],
								"minimg" => $minimg,
								"url" => $url,
								"description" => $ourphp_rs[5],
								"click" => $ourphp_rs[6],
								"wapurl" => $wapurl,
								"column" => columncycle($ourphp_rs[7]),
							);
			$i+=1;
		}
		break;
		case "video":
		$query = $db-> sqllist("select id,OP_Videotitle,time,OP_Videoimg,OP_Url,OP_Description,OP_Click,OP_Class,OP_Videovurl from `ourphp_".$form."` where ".$where." && `OP_Callback` = 0 order by id desc LIMIT 0,".$limit);
		$rs=array();
		$i = 1;
		while($ourphp_rs=mysql_fetch_array($query)){
		if ($ourphp_rs[4] == ''){
		if($Parameterse['rewrite'] == 1){
		$url = $ourphp_webpath.$lang.'/videoview/'.$ourphp_rs[7].'/'.$ourphp_rs[0].'/';
		}else{
		$url = $ourphp_webpath.'?'.$lang.'-videoview-'.$ourphp_rs[7].'-'.$ourphp_rs[0].'.html';
		}
		$wapurl = $ourphp_webpath.'client/wap/?'.$lang.'-videoview-'.$ourphp_rs[7].'-'.$ourphp_rs[0].'.html';
		}else{$url=$ourphp_rs[4];$wapurl = $ourphp_rs[4];}
		if(substr($ourphp_rs[3],0,7) == 'http://'){$minimg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[3];}
				$rs[]=array (
								"i" => $i,
								"id" => $ourphp_rs[0],
								"title" => $ourphp_rs[1],
								"time" => $ourphp_rs[2],
								"minimg" => $minimg,
								"url" => $url,
								"description" => $ourphp_rs[5],
								"click" => $ourphp_rs[6],
								"wapurl" => $wapurl,
								"column" => columncycle($ourphp_rs[7]),
								'playurl' => $ourphp_rs[8],
							);
			$i+=1;
		}
		break;
		case "down":
		$query = $db-> sqllist("select id,OP_Downtitle,time,OP_Downimg,OP_Downdurl,OP_Downempower,OP_Downtype,OP_Downlang,OP_Downsize,OP_Downmake,OP_Url,OP_Description,OP_Click,OP_Class from `ourphp_".$form."` where ".$where." && `OP_Callback` = 0 order by id desc LIMIT 0,".$limit);
		$rs=array();
		$i = 1;
		while($ourphp_rs=mysql_fetch_array($query)){
		if ($ourphp_rs[10] == ''){
		if($Parameterse['rewrite'] == 1){
		$url = $ourphp_webpath.$lang.'/downview/'.$ourphp_rs[13].'/'.$ourphp_rs[0].'/';
		}else{
		$url = $ourphp_webpath.'?'.$lang.'-downview-'.$ourphp_rs[13].'-'.$ourphp_rs[0].'.html';
		}
		$wapurl = $ourphp_webpath.'client/wap/?'.$lang.'-downview-'.$ourphp_rs[13].'-'.$ourphp_rs[0].'.html';
		}else{$url=$ourphp_rs[10];$wapurl = $ourphp_rs[10];}
		if(substr($ourphp_rs[3],0,7) == 'http://'){$minimg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[3];}
				$rs[]=array (
								"i" => $i,
								"id" => $ourphp_rs[0],
								"title" => $ourphp_rs[1],
								"time" => $ourphp_rs[2],
								"minimg" => $minimg,
								"downurl" => $ourphp_rs[4],
								"empower" => $ourphp_rs[5],
								"type" => $ourphp_rs[6],
								"lang" => $ourphp_rs[7],
								"size" => $ourphp_rs[8],
								"make" => $ourphp_rs[9],
								"url" => $url,
								"description" => $ourphp_rs[11],
								"click" => $ourphp_rs[12],
								"wapurl" => $wapurl,
								"column" => columncycle($ourphp_rs[13]),
							);
			$i+=1;
		}
		break;
		case "job":
		$query = $db-> sqllist("select id,OP_Jobtitle,time,OP_Jobwork,OP_Jobadd,OP_Jobeducation,OP_Jobnumber,OP_Jobage,OP_Jobwage,OP_Url,OP_Description,OP_Click,OP_Class from `ourphp_".$form."` where ".$where." && `OP_Callback` = 0 order by id desc LIMIT 0,".$limit);
		$rs=array();
		$i = 1;
		while($ourphp_rs=mysql_fetch_array($query)){
		if ($ourphp_rs[9] == ''){
		if($Parameterse['rewrite'] == 1){
		$url = $ourphp_webpath.$lang.'/jobview/'.$ourphp_rs[12].'/'.$ourphp_rs[0].'/';
		}else{
		$url = $ourphp_webpath.'?'.$lang.'-jobview-'.$ourphp_rs[12].'-'.$ourphp_rs[0].'.html';
		}
		$wapurl = $ourphp_webpath.'client/wap/?'.$lang.'-jobview-'.$ourphp_rs[12].'-'.$ourphp_rs[0].'.html';
		}else{$url=$ourphp_rs[9];$wapurl = $ourphp_rs[9];}
				$rs[]=array (
								"i" => $i,
								"id" => $ourphp_rs[0],
								"title" => $ourphp_rs[1],
								"time" => $ourphp_rs[2],
								"work" => $ourphp_rs[3],
								"add" => $ourphp_rs[4],
								"education" => $ourphp_rs[5],
								"number" => $ourphp_rs[6],
								"age" => $ourphp_rs[7],
								"wage" => $ourphp_rs[8],
								"url" => $url,
								"description" => $ourphp_rs[10],
								"click" => $ourphp_rs[11],
								"wapurl" => $wapurl,
								"column" => columncycle($ourphp_rs[12]),
							);
			$i+=1;
		}
		break;
		
	}
		
		if($rs == ""){
			return str_replace($content,$ourphp_access,$content);
			$repeat = false;
		}
        $smarty->block_data[$dataindex]=$rs;
    }
    if(!$smarty->block_data[$dataindex]){
        $repeat = false;
        return '';  
    }
  
    if (list ($key,$item)=each($smarty->block_data[$dataindex] )) {
		$smarty->assign($return, $item);
        $repeat = true;
    }

    if (!$item) {
        $repeat = false;
        reset($smarty->block_data[$dataindex]);
    }
    return $content;
}
?>