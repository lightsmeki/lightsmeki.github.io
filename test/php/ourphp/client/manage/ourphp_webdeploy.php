<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php'; 

if (isset($_GET["ourphp_cms"]) == "edit"){

	if (!empty($_POST["OP_Webpage"])){
	$OP_Webpage = implode(',',$_POST["OP_Webpage"]);
	}else{
	$OP_Webpage = '20,20,20,20,20,20,20';
	}

	$sql="update `ourphp_webdeploy` set 
	`OP_Weboff` = '".admin_sql($_POST["OP_Weboff"])."',
	`OP_Webofftext` = '".admin_sql($_POST["OP_Webofftext"])."',
	`OP_Webpage` = '".$OP_Webpage."',
	`OP_Webfenci` = '".admin_sql($_POST["OP_Webfenci"])."',
	`OP_Webservice` = '".admin_sql($_POST["OP_Webservice"])."',
	`OP_Webpcomment` = '".admin_sql($_POST["OP_Webpcomment"])."',
	`OP_Webocomment` = '".admin_sql($_POST["OP_Webocomment"])."',
	`OP_Webweight` = '".admin_sql($_POST["OP_Webweight"])."',
	`OP_Webfile` = '".admin_sql($_POST["OP_Webfile"])."',
	`OP_Ucenter` = '".admin_sql($_POST["OP_Ucenter"])."',
	`OP_Searchtime` = '".admin_sql($_POST["OP_Searchtime"])."',
	`OP_Home` = '".$_POST["OP_Langone"]."|".$_POST["OP_Langtwo"]."|".$_POST["OP_Langthree"]."',
	`OP_Sensitive` = '".admin_sql($_POST["OP_Sensitive"])."'
	 where id = 1";
	$query=mysql_query($sql);
	$ourphp_font = 1;
	$ourphp_class = 'ourphp_webdeploy.php';
	require 'ourphp_remind.php';

}


function Langlist(){
	global $conn;
	$sql="select id,OP_Lang,OP_Font,OP_Default from `ourphp_lang` order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs[0],
						"lang" => $ourphp_rs[1],
						"font" => $ourphp_rs[2],
						"default" => $ourphp_rs[3]
					);
	}
	return $rows;
	mysql_free_result($query);
}


$sql="select * from `ourphp_webdeploy` where `id` = 1";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$rows = array(
				'OP_Weboff' => $ourphp_rs['OP_Weboff'],
				'OP_Webofftext' => $ourphp_rs['OP_Webofftext'],
				'OP_Webrewrite' => $ourphp_rs['OP_Webrewrite'],
				'OP_Webpage' => explode(",",$ourphp_rs['OP_Webpage']),
				'OP_Webfenci' => $ourphp_rs['OP_Webfenci'],
				'OP_Webservice' => $ourphp_rs['OP_Webservice'],
				'OP_Webpcomment' => $ourphp_rs['OP_Webpcomment'],
				'OP_Webocomment' => $ourphp_rs['OP_Webocomment'],
				'OP_Webweight' => $ourphp_rs['OP_Webweight'],
				'OP_Webfile' => $ourphp_rs['OP_Webfile'],
				'OP_Ucenter' => $ourphp_rs['OP_Ucenter'],
				'OP_Searchtime' => $ourphp_rs['OP_Searchtime'],
				'OP_Home' => explode('|',$ourphp_rs['OP_Home']),
				'OP_Sensitive' => $ourphp_rs['OP_Sensitive'],
);
$smarty->assign('ourphp_web',$rows);
mysql_free_result($query);


    function myscandir($path){
 
        $mydir=dir($path);
		
		$rows=array();
        while($file=$mydir->read()){
            $p=$file;
        
            if(($file!=".") AND ($file!="..")){
				$rows[] = array('url'=>mb_convert_encoding($p,"utf-8","gb2312"));
			}
        }  
		return $rows;
    }
	
$smarty->assign("Service",myscandir('../../function/plugs/Service'));
$smarty->assign("langlist",Langlist());
$smarty->display('ourphp_webdeploy.html');
?>