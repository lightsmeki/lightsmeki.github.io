<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
 *-------------------------------
 * 模板操作类(2014-10-15)
 *-------------------------------
*/
if(!defined('OURPHPNO')){exit('no!');}

$ourphp_web = ourphp_web();
function ourphp_usercontrol(){ 
global $db,$ourphp_web;
$ourphp_rs = $db-> ourphpsql("select `OP_Userreg`,`OP_Userlogin`,`OP_Userprotocol`,`OP_Usergroup`,`OP_Usermoney`,`OP_Useripoff` from `ourphp_usercontrol` where `id` = 1"); 
$rows = array(
				'regoff' => $ourphp_rs[0],
				'loginoff' => $ourphp_rs[1],
				'protocol' => str_replace('[.$ourphp_web.website.]',$ourphp_web['website'],$ourphp_rs[2]),
				'group' => $ourphp_rs[3],
				'money' => explode("|",$ourphp_rs[4]),
				'ipoff' => $ourphp_rs[5],
			);
return $rows;
}

$ourphp_usercontrol = ourphp_usercontrol();
function ourphp_userproblem(){ 
global $db,$ourphp_webpath; 
$query = $db-> sqllist("select `OP_Userproblem` from `ourphp_userproblem` order by id desc"); 
$rows=array();
$i=1;
while($ourphp_rs = mysql_fetch_array($query)){
		$rows[] = array(
							'i' => $i,
							'title' => $ourphp_rs[0],
		);
		$i+=1;
}
return $rows;
}


function userclass($id){ 
global $db,$ourphp_webpath; 
$ourphp_rs = $db-> ourphpsql("select `OP_Userlevename` from `ourphp_userleve` where id = ".$id);
return $ourphp_rs[0];
}


$smarty->assign('usercontrol',$ourphp_usercontrol);
$smarty->assign('problem',ourphp_userproblem());
?>