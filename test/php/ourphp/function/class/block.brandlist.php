<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

function smarty_block_brandlist($params, $content, &$smarty, &$repeat){
global $ourphp_access,$ourphp_webpath,$_page,$db,$Parameterse;
$id = isset($params['id'])?$params['id']:0;
			
	extract($params);  
	if (! isset ( $params['name'] )){
		$return = 'brand';
	}else{
		$return = $params['name'];
	}
	
	$listpage = $Parameterse['page'][1];
		
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_product` where OP_Brand = '".$id."' && `OP_Down` = 2");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	
    if(!isset($smarty->block_data))
	$smarty->block_data = array();	

	$dataindex = md5(__FUNCTION__ . md5(serialize($params)));  
    $dataindex = substr($dataindex,0,16);

    if (@!$smarty->block_data[$dataindex]){
		$query = $db-> sqllist("select id,OP_Title,OP_Number,OP_Goodsno,OP_Brand,OP_Market,OP_Webmarket,OP_Stock,OP_Minimg,OP_Maximg,OP_Lang,OP_Url,OP_Description,OP_Click,time,OP_Class from `ourphp_product` where OP_Brand = '".$id."' && `OP_Down` = 2 order by OP_Sorting asc,id desc LIMIT ".$start.",".$listpage);
		$rs=array();
		$i = 1;
		while($ourphp_rs=mysql_fetch_array($query)){
		if(substr($ourphp_rs[8],0,7) == 'http://'){$minimg = $ourphp_rs[8];}elseif($ourphp_rs[8] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[8];}
		if(substr($ourphp_rs[9],0,7) == 'http://'){$maximg = $ourphp_rs[9];}elseif($ourphp_rs[9] == ''){$maximg = $ourphp_webpath.'skin/noimage.png';}else{$maximg=$ourphp_webpath.$ourphp_rs[9];}
		if ($ourphp_rs[11] == ''){
		if($Parameterse['rewrite'] == 1){
		$url = $ourphp_webpath.$ourphp_rs[10].'/productview/'.$ourphp_rs[15].'/'.$ourphp_rs[0].'/';
		}else{
		$url = $ourphp_webpath.'?'.$ourphp_rs[10].'-productview-'.$ourphp_rs[15].'-'.$ourphp_rs[0].'.html';
		}
		$wapurl = $ourphp_webpath.'client/wap/?'.$ourphp_rs[10].'-productview-'.$ourphp_rs[15].'-'.$ourphp_rs[0].'.html';
		}else{$url=$ourphp_rs[11];$wapurl=$ourphp_rs[11];}
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
								"description" => $ourphp_rs[12],
								"click" => $ourphp_rs[13],
								"time" => $ourphp_rs[14],
								"wapurl" => $wapurl,
							);
			$i+=1;
		}
		
		$_page = new Page($ourphptotal['tiaoshu'],$listpage);
		$smarty->assign('ourphppage',$_page->showpage());	
		if(!$rs){
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