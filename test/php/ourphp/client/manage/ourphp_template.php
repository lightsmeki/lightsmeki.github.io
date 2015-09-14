<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){

			$sql="update `ourphp_temp` set 
			`OP_Temppath` = '".admin_sql($_GET["temp"])."'
			 where id = 1";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_template.php?id=ourphp';
			require 'ourphp_remind.php';
}

    function myscandir($path){
 
        $mydir=dir($path);
		
		$rows=array();
        while($file=$mydir->read()){
            $p=$path.'/'.$file;
			$f=mb_convert_encoding($p,"utf-8","gb2312");
			if(file_exists($f.'/Author.tpl')){
			$tempfile = $f.'/Author.tpl';
			}else{
			$tempfile = '../../skin/Author.tpl';
			}
            if(($file!=".") AND ($file!="..")){
				$rows[] = array('url'=>$f,'img'=>$f.'/index.jpg','author'=>$tempfile);
			}
        }  
		return $rows;
    }
	
	
Admin_click('模板安装使用','ourphp_template.php?id=ourphp');

$sql="select * from `ourphp_temp` where `id` = 1";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_temp',$ourphp_rs);
mysql_free_result($query);

$smarty->assign("myscandir",myscandir('../../templates'));
$smarty->display('ourphp_template.html');
?>