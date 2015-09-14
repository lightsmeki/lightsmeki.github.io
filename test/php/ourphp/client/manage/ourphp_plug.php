<?php
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include './ourphp_admin.php';
include './ourphp_checkadmin.php'; 
include './ourphp_page.class.php';

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){


			if (strstr($OP_Adminpower,"35")){
			$sql="select `OP_Plugid`,`OP_Plugclass`,`OP_Plugmysql` from `ourphp_plus` where id = ".intval($_GET['id']);
			$ourphp_rs=mysql_fetch_array(mysql_query($sql));
			$file = '../../function/data/'.$ourphp_rs[1].'.'.$ourphp_rs[0].'.php';
			$result = unlink($file);
			
			$sqlb = "DROP TABLE ourphp_p_".$ourphp_rs[2];
			$retval = mysql_query($sqlb);
			
			$sql="delete from ourphp_plus where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_plug.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_plug.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}


}

function Pluslist(){
	global $_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_plus` order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select id,OP_Name,OP_Version,OP_Versiondate,OP_Author,OP_Fraction,OP_About,OP_Pluspath,OP_Time,OP_Off from `ourphp_plus` order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1],
						"version" => $ourphp_rs[2],
						"versiondate" => $ourphp_rs[3],
						"author" => $ourphp_rs[4],
						"fraction" => $ourphp_rs[5],
						"about" => $ourphp_rs[6],
						"pluspath" => $ourphp_rs[7],
						"time" => $ourphp_rs[8],
						"off" => $ourphp_rs[9],
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}


function myscandir($path){
	$mydir=dir($path);		
	$rows=array();
	while($file=$mydir->read()){
		$p=$path.'/'.$file;
		if(($file!=".") AND ($file!="..")){
			if($p != '../plus/ourphp_plus.php' AND $p != '../plus/Model.txt' AND $p != '../plus/ourphp_plus_admin.php' AND $p != '../plus/style.css'){
			if(file_exists($p.'/Author.tpl')){
				$author = $p.'/Author.tpl';
					}else{
				$author = '无名称，无介绍';
			}
			$rows[] = array('url'=>mb_convert_encoding($p,"utf-8","gb2312"),'name'=>$file,'author'=>file_get_contents($author),);
			}
		}
	}  
	return $rows;
}
	
$smarty->assign("Pluslist",Pluslist());
$smarty->assign("Addpluslist",myscandir('../plus'));
$smarty->display('ourphp_pluslist.html');
?>