<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

function columnlist($model) { 
    global $conn; 
	if ($model == ''){
    $sql = "select id,OP_Uid,OP_Lang,OP_Columntitle,OP_Columntitleto,OP_Model,OP_Templist,OP_Tempview,OP_Hide,OP_Sorting,OP_Weight,OP_Url from `ourphp_column` order by OP_Sorting asc,id asc"; 
	}else{
    $sql = "select id,OP_Uid,OP_Lang,OP_Columntitle,OP_Columntitleto,OP_Model,OP_Templist,OP_Tempview,OP_Hide,OP_Sorting,OP_Weight,OP_Url from `ourphp_column` where OP_Model = '".$model."' order by OP_Sorting asc,id asc"; 
	}
    $query=mysql_query($sql);
	$rows=array();
	$i = 0;
	if (mysql_num_rows($query) >= 1){
        while($ourphp_rs = mysql_fetch_array($query)){
            $rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"uid" => $ourphp_rs[1],
						"lang" => $ourphp_rs[2],
						"title" => $ourphp_rs[3],
						"titleto" => $ourphp_rs[4],
						"model" => $ourphp_rs[5],
						"templist" => $ourphp_rs[6],
						"tempview" => $ourphp_rs[7],
						"hide" => $ourphp_rs[8],
						"sorting" => $ourphp_rs[9],
						"weight" => $ourphp_rs[10],
						"weburl" => $ourphp_rs[11],
						); 
						$i+=1;
		}
	}else{
			$rows[] = array(
						"i" => $i,
						"id" => '0',
						"uid" => '0',
						"lang" => '0',
						"title" => '暂无栏目',
						"titleto" => '暂无栏目',
						"model" => 'ourphp',
						"templist" => '0',
						"tempview" => '0',
						"hide" => '0',
						"sorting" => '0',
						"weight" => '0',
						"weburl" => '0',
						);
						$i+=1;
	}
    return $rows;
	mysql_free_result($query);
}
/* echo print_r(columnlist("photo"));
exit; */
?>