<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

function smarty_block_list($params, $content, &$smarty, &$repeat){
global $ourphp_access,$ourphp_webpath,$_page,$db,$Parameterse;
$form = isset($params['form'])?$params['form']:"article";
$id = isset($params['id'])?$params['id']:0;
$sql = isset($params['sql'])?$params['sql']:'';

	extract($params);  
	if (!isset ( $params['name'] )){
		$return = 'list';
	}else{
		$return = $params['name'];
	}

	if(!isset($params['type'])){
	$type = "OP_Sorting asc";
	}elseif($params['type'] == 'OP_Webmarket'){
	$type = $params['type'].' asc';
	}elseif($params['type'] == 'OP_Click'){
	$type = $params['type'].' desc';
	}
	
	if($form == 'article'){$listpage = $Parameterse['page'][0];}
	if($form == 'product'){$listpage = $Parameterse['page'][1];}
	if($form == 'photo'){$listpage = $Parameterse['page'][2];}
	if($form == 'video'){$listpage = $Parameterse['page'][3];}
	if($form == 'down'){$listpage = $Parameterse['page'][4];}
	if($form == 'job'){$listpage = $Parameterse['page'][5];}
	
	$query = $db-> sqllist("select `id` from `ourphp_column` where `OP_Uid` = ".$id);
	$uid = array();
	while($ourphp_rs=mysql_fetch_array($query)){
	$uid[] .= $ourphp_rs[0];
	}
	$uid = implode(',',$uid);
	if(empty($uid)){
	$uid = 00;
	}else{
	$uid = $uid;
	}
		
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	if($form!='product'){
		$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_".$form."` where (OP_Class = ".$id." || OP_Class in (".$uid.")) && `OP_Callback` = 0 ".$sql);
	}else{
		$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_".$form."` where (OP_Class = ".$id." || OP_Class in (".$uid.")) && `OP_Down` = 2 ".$sql);
	}
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	
    if(!isset($smarty->block_data))
	$smarty->block_data = array();	
		
	$dataindex = md5(__FUNCTION__ . md5(serialize($params)));  
    $dataindex = substr($dataindex,0,16);

    if (@!$smarty->block_data[$dataindex]){
	switch($form){
		case "article":
		$query = $db-> sqllist("select id,OP_Articletitle,OP_Articleauthor,OP_Articlesource,time,OP_Lang,OP_Url,OP_Description,OP_Click,OP_Class,OP_Minimg from `ourphp_".$form."` where (OP_Class = ".$id." || OP_Class in (".$uid.")) && `OP_Callback` = 0 ".$sql." order by OP_Sorting asc,id desc LIMIT ".$start.",".$listpage);
		if(!mysql_num_rows($query)){
			$rs="";
		}else{
			$rs=array();
			$i = 1;
			while($ourphp_rs=mysql_fetch_array($query)){
			if ($ourphp_rs[6] == ''){
			if($Parameterse['rewrite'] == 1){
			$url = $ourphp_webpath.$ourphp_rs[5].'/articleview/'.$ourphp_rs[9].'/'.$ourphp_rs[0].'/';
			}else{
			$url = $ourphp_webpath.'?'.$ourphp_rs[5].'-articleview-'.$ourphp_rs[9].'-'.$ourphp_rs[0].'.html';
			}
			$wapurl = $ourphp_webpath.'client/wap/?'.$ourphp_rs[5].'-articleview-'.$ourphp_rs[9].'-'.$ourphp_rs[0].'.html';
			}else{$url=$ourphp_rs[6];$wapurl = $ourphp_rs[6];}
			if(substr($ourphp_rs[10],0,7) == 'http://'){$minimg = $ourphp_rs[10];}elseif($ourphp_rs[10] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_rs[10];}
					$rs[]=array (
									"i" => $i,
									"id" => $ourphp_rs[0],
									"title" => $ourphp_rs[1],
									"author" => $ourphp_rs[2],
									"source" => $ourphp_rs[3],
									"time" => $ourphp_rs[4],
									"description" => $ourphp_rs[7],
									"url" => $url,
									"click" => $ourphp_rs[8],
									"minimg" => $minimg,
									"wapurl" => $wapurl,
									"column" => columncycle($ourphp_rs[9]),
								);
				$i+=1;
			}
		}
		break;
		case "product":
		$query = $db-> sqllist("select id,OP_Title,OP_Number,OP_Goodsno,OP_Brand,OP_Market,OP_Webmarket,OP_Stock,OP_Minimg,OP_Maximg,OP_Lang,OP_Url,OP_Description,OP_Click,time,OP_Class,OP_Integral,OP_Integralexchange from `ourphp_".$form."` where (OP_Class = ".$id." || OP_Class in (".$uid.")) && `OP_Down` = 2 ".$sql." order by $type,id desc LIMIT ".$start.",".$listpage);
		if(!mysql_num_rows($query)){
			$rs="";
		}else{
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
			}else{$url=$ourphp_rs[11];$wapurl = $ourphp_rs[10];}
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
									"column" => columncycle($ourphp_rs[15]),
									"integral" => $ourphp_rs[16],
									"integralexchange" => $ourphp_rs[17],
								);
				$i+=1;
			}
		}
		break;
		case "photo":
		$query = $db-> sqllist("select id,OP_Phototitle,time,OP_Photocminimg,OP_Lang,OP_Url,OP_Description,OP_Click,OP_Class from `ourphp_".$form."` where (OP_Class = ".$id." || OP_Class in (".$uid.")) && `OP_Callback` = 0 ".$sql." order by OP_Sorting asc,id desc LIMIT ".$start.",".$listpage);
		if(!mysql_num_rows($query)){
			$rs="";
		}else{
			$rs=array();
			$i = 1;
			while($ourphp_rs=mysql_fetch_array($query)){
			if(substr($ourphp_rs[3],0,7) == 'http://'){$minimg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[3];}
			if ($ourphp_rs[5] == ''){
			if($Parameterse['rewrite'] == 1){
			$url = $ourphp_webpath.$ourphp_rs[4].'/photoview/'.$ourphp_rs[8].'/'.$ourphp_rs[0].'/';
			}else{
			$url = $ourphp_webpath.'?'.$ourphp_rs[4].'-photoview-'.$ourphp_rs[8].'-'.$ourphp_rs[0].'.html';
			}
			$wapurl = $ourphp_webpath.'client/wap/?'.$ourphp_rs[4].'-photoview-'.$ourphp_rs[8].'-'.$ourphp_rs[0].'.html';
			}else{$url=$ourphp_rs[5];$wapurl = $ourphp_rs[5];}
					$rs[]=array (
									"i" => $i,
									"id" => $ourphp_rs[0],
									"title" => $ourphp_rs[1],
									"time" => $ourphp_rs[2],
									"minimg" => $minimg,
									"url" => $url,
									"description" => $ourphp_rs[6],
									"click" => $ourphp_rs[7],
									"wapurl" => $wapurl,
									"column" => columncycle($ourphp_rs[8]),
								);
				$i+=1;
			}
		}
		break;
		case "video":
		$query = $db-> sqllist("select id,OP_Videotitle,time,OP_Videoimg,OP_Lang,OP_Url,OP_Description,OP_Click,OP_Class from `ourphp_".$form."` where (OP_Class = ".$id." || OP_Class in (".$uid.")) && `OP_Callback` = 0 ".$sql." order by OP_Sorting asc,id desc LIMIT ".$start.",".$listpage);
		if(!mysql_num_rows($query)){
			$rs="";
		}else{
			$rs=array();
			$i = 1;
			while($ourphp_rs=mysql_fetch_array($query)){
			if(substr($ourphp_rs[3],0,7) == 'http://'){$minimg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[3];}
			if ($ourphp_rs[5] == ''){
			if($Parameterse['rewrite'] == 1){
			$url = $ourphp_webpath.$ourphp_rs[4].'/videoview/'.$ourphp_rs[8].'/'.$ourphp_rs[0].'/';
			}else{
			$url = $ourphp_webpath.'?'.$ourphp_rs[4].'-videoview-'.$ourphp_rs[8].'-'.$ourphp_rs[0].'.html';
			}
			$wapurl = $ourphp_webpath.'client/wap/?'.$ourphp_rs[4].'-videoview-'.$ourphp_rs[8].'-'.$ourphp_rs[0].'.html';
			}else{$url=$ourphp_rs[5];$wapurl = $ourphp_rs[5];}
					$rs[]=array (
									"i" => $i,
									"id" => $ourphp_rs[0],
									"title" => $ourphp_rs[1],
									"time" => $ourphp_rs[2],
									"minimg" => $minimg,
									"url" => $url,
									"description" => $ourphp_rs[6],
									"click" => $ourphp_rs[7],
									"wapurl" => $wapurl,
									"column" => columncycle($ourphp_rs[8]),
								);
				$i+=1;
			}
		}
		break;
		case "down":
		$query = $db-> sqllist("select id,OP_Downtitle,time,OP_Downimg,OP_Downdurl,OP_Downempower,OP_Downtype,OP_Downlang,OP_Downsize,OP_Downmake,OP_Lang,OP_Url,OP_Description,OP_Click,OP_Class from `ourphp_".$form."` where (OP_Class = ".$id." || OP_Class in (".$uid.")) && `OP_Callback` = 0 ".$sql." order by OP_Sorting asc,id desc LIMIT ".$start.",".$listpage);
		if(!mysql_num_rows($query)){
			$rs="";
		}else{
		$rs=array();
		$i = 1;
			while($ourphp_rs=mysql_fetch_array($query)){
			if(substr($ourphp_rs[3],0,7) == 'http://'){$minimg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[3];}
			if ($ourphp_rs[11] == ''){
			if($Parameterse['rewrite'] == 1){
			$url = $ourphp_webpath.$ourphp_rs[10].'/downview/'.$ourphp_rs[14].'/'.$ourphp_rs[0].'/';
			}else{
			$url = $ourphp_webpath.'?'.$ourphp_rs[10].'-downview-'.$ourphp_rs[14].'-'.$ourphp_rs[0].'.html';
			}
			$wapurl = $ourphp_webpath.'client/wap/?'.$ourphp_rs[10].'-downview-'.$ourphp_rs[14].'-'.$ourphp_rs[0].'.html';
			}else{$url=$ourphp_rs[11];$wapurl = $ourphp_rs[11];}
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
									"description" => $ourphp_rs[12],
									"click" => $ourphp_rs[13],
									"wapurl" => $wapurl,
									"column" => columncycle($ourphp_rs[14]),
								);
				$i+=1;
			}
		}
		break;
		case "job":
		$query = $db-> sqllist("select `id`, `OP_Jobtitle`, `time`, `OP_Jobwork`, `OP_Jobadd`, `OP_Jobnature`, `OP_Jobexperience`, `OP_Jobeducation`, `OP_Jobnumber`, `OP_Jobage`, `OP_Jobwelfare`, `OP_Jobwage`, `OP_Jobcontact`, `OP_Jobtel`, `OP_Jobcontent`, `OP_Class`, `OP_Lang`, `OP_Url`, `OP_Description`, `OP_Click` from `ourphp_".$form."` where (OP_Class = ".$id." || OP_Class in (".$uid.")) && `OP_Callback` = 0 ".$sql." order by OP_Sorting asc,id desc LIMIT ".$start.",".$listpage);
		if(!mysql_num_rows($query)){
			$rs="";
		}else{
			$rs=array();
			$i = 1;
			while($ourphp_rs=mysql_fetch_array($query)){
			if ($ourphp_rs[17] == ''){
			if($Parameterse['rewrite'] == 1){
			$url = $ourphp_webpath.$ourphp_rs[16].'/jobview/'.$ourphp_rs[15].'/'.$ourphp_rs[0].'/';
			}else{
			$url = '?'.$ourphp_rs[16].'-jobview-'.$ourphp_rs[15].'-'.$ourphp_rs[0].'.html';
			}
			$wapurl = $ourphp_webpath.'client/wap/?'.$ourphp_rs[16].'-jobview-'.$ourphp_rs[15].'-'.$ourphp_rs[0].'.html';
			}else{$url=$ourphp_rs[17];$wapurl = $ourphp_rs[17];}
					$rs[]=array (
									"i" => $i,
									"id" => $ourphp_rs[0],
									"title" => $ourphp_rs[1],
									"time" => $ourphp_rs[2],
									"work" => $ourphp_rs[3],
									"add" => $ourphp_rs[4],
									"nature" => $ourphp_rs[5],
									"experience" => $ourphp_rs[6],
									"education" => $ourphp_rs[7],
									"number" => $ourphp_rs[8],
									"age" => $ourphp_rs[9],
									"welfare" => $ourphp_rs[10],
									"wage" => $ourphp_rs[11],
									"contact" => $ourphp_rs[12],
									"tel" => $ourphp_rs[13],
									"content" => $ourphp_rs[14],
									"url" => $url,
									"description" => $ourphp_rs[18],
									"click" => $ourphp_rs[19],
									"wapurl" => $wapurl,
									"column" => columncycle($ourphp_rs[15]),
								);
				$i+=1;
			}
		}
		break;
		
	}

	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
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