<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

function smarty_block_banner($params, $content, &$smarty, &$repeat){
global $ourphp_access,$ourphp_webpath,$ourphp_cache;
$lang = isset($params['lang'])?$params['lang']:"cn";
$limit = isset($params['row'])?$params['row']:1;
$id = isset($params['id'])?$params['id']:0;
$type = isset($params['type'])?$params['type']:0;
$fsomd5 = md5($lang.$limit.$id.$type);

	extract($params);  
	if (! isset ( $params['name'] )){
		$return = 'banner';
	}else{
		$return = $params['name'];
	}
    if(!isset($smarty->block_data))
	$smarty->block_data = array();	
	$dataindex = md5(__FUNCTION__ . md5(serialize($params)));  
    $dataindex = substr($dataindex,0,16);

    if (@!$smarty->block_data[$dataindex]){
	if(!is_file(WEB_ROOT.'/'.$ourphp_cache.'banner_'.$fsomd5.'.txt')){
		global $db;
		if ($id == 0){
		$query = $db-> sqllist("select `id`,`OP_Bannerimg`,`OP_Bannertitle`,`OP_Bannerurl` from `ourphp_banner` where `OP_Bannerlang` = '".$lang."' && `OP_Bannerclass` = ".$type." LIMIT 0,".$limit);
		}else{
		$query = $db-> sqllist("select `id`,`OP_Bannerimg`,`OP_Bannertitle`,`OP_Bannerurl` from `ourphp_banner` where id in(".$id.") && `OP_Bannerclass` = ".$type);
		}
		$rs=array();
		$i = 1;
		while($ourphp_rs=mysql_fetch_array($query)){
		if(substr($ourphp_rs[1],0,7) == 'http://'){$minimg = $ourphp_rs[1];}elseif($ourphp_rs[1] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[1];}
				$rs[]=array (
								'i' => $i,
								'id' => $ourphp_rs[0],
								'img' => $minimg,
								'title' => $ourphp_rs[2],
								'url' => $ourphp_rs[3]
							);
			$i+=1;
		}
		if(!$rs){
			return str_replace($content,$ourphp_access,$content);
			$repeat = false;
		}
        $smarty->block_data[$dataindex]=$rs;
		ourphp_file($ourphp_cache.'banner_'.$fsomd5.'.txt',json_encode($rs),2);
		}else{
		$arraytojson = json_decode(file_get_contents(WEB_ROOT.'/'.$ourphp_cache.'banner_'.$fsomd5.'.txt'));
		$smarty->block_data[$dataindex]=object_array($arraytojson);
		}
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