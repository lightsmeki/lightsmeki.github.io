<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

function smarty_function_service($params, &$smarty){

		global $db,$ourphp_access,$ourphp_webpath,$ourphp_cache;
		extract($params);
		$type = isset($params['type'])?$params['type']:0;
		$fsomd5 = md5($type);
		
		$ourphp_rs = $db-> ourphpsql("select `OP_Webservice` from `ourphp_webdeploy` where id = 1"); 
		$kefuurl = $ourphp_rs[0];
		
		if($kefuurl != 'close'){
		
		if(!is_file(WEB_ROOT.'/'.$ourphp_cache.'service_'.$fsomd5.'.txt')){
		if($type == 0){
		$where = '';
		}else{
		$where = "where `OP_QQclass` = '".$type."'";
		}
		
		$query = $db-> sqllist("select id,OP_QQname,OP_QQnumber,OP_QQclass,OP_QQother from `ourphp_qq` ".$where." order by OP_QQsorting asc,id desc");
		$rs=array();
		$i = 1;
		while($ourphp_rsrs=mysql_fetch_array($query)){
				$rs[]=array (
								"i" => $i,
								"id" => $ourphp_rsrs[0],
								"name" => $ourphp_rsrs[1],
								"number" => $ourphp_rsrs[2],
								"class" => $ourphp_rsrs[3],
								"other" => $ourphp_rsrs[4],
							);
			$i+=1;
		}
		ourphp_file($ourphp_cache.'service_'.$fsomd5.'.txt',json_encode($rs),2);
		}else{
		$arraytojson = json_decode(file_get_contents(WEB_ROOT.'/'.$ourphp_cache.'service_'.$fsomd5.'.txt'));
		$rs=object_array($arraytojson);
		}
		$smarty->assign('service',$rs);
		$smarty->assign('plugsurl',$ourphp_webpath.'function/plugs/Service/'.$kefuurl.'/');
		$smarty->display(WEB_ROOT.'/function/plugs/Service/'.$kefuurl.'/index.html');
		return ;
}else{
return ;
}
mysql_free_result($query);

}
?>