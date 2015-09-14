<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
 *-------------------------------
 * 内容操作类(2014-10-15)
 *-------------------------------
*/
if(!defined('OURPHPNO')){exit('no!');}

switch($temptype){

case "articleview":
	$query = $db-> sqllist("update `ourphp_article` set OP_Click = OP_Click + 1 where `id` = ".$viewid);
	$ourphp_rs = $db-> ourphpsql("select id,OP_Articletitle,OP_Articleauthor,OP_Articlesource,`time`,OP_Articlecontent,OP_Class,OP_Tag,OP_Url,OP_Click,OP_Description,OP_Minimg from `ourphp_article` where `id` = ".$viewid); 
	if(substr($ourphp_rs[11],0,7) == 'http://'){$minimg = $ourphp_rs[11];}elseif($ourphp_rs[11] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_rs[11];}
	$rows = array(
				'id' => $ourphp_rs[0],
				'title' => $ourphp_rs[1],
				'author' => $ourphp_rs[2],
				'source' => $ourphp_rs[3],
				'time' => $ourphp_rs[4],
				'content' => $ourphp_rs[5],
				'class' => $ourphp_rs[6],
				'tag' => keywords_tag($ourphp_rs[7]),
				'url' => $ourphp_rs[8],
				'click' => $ourphp_rs[9],
				'description' => $ourphp_rs[10],
				"minimg" => $minimg,

	);
	
	if ($rows['url'] == ''){}else{header("location: ".$rows['url']);}
break;

case "productview":
	$query = $db-> sqllist("update `ourphp_product` set OP_Click = OP_Click + 1 where `id` = ".$viewid);
	$ourphp_rs = $db-> ourphpsql("select id,OP_Title,OP_Number,OP_Goodsno,OP_Brand,OP_Market,OP_Webmarket,OP_Stock,OP_Specificationsid ,OP_Specifications,OP_Pattribute,OP_Minimg,OP_Maximg,OP_Content,OP_Img,OP_Url,OP_Description,OP_Click,time,OP_Class,OP_Tag,OP_Usermoney,OP_Freight,OP_Integral,OP_Integralexchange from `ourphp_product` where `id` = ".$viewid); 
	if(substr($ourphp_rs[11],0,7) == 'http://'){$minimg = $ourphp_rs[11];}elseif($ourphp_rs[11] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[11];}
	if(substr($ourphp_rs[12],0,7) == 'http://'){$maximg = $ourphp_rs[12];}elseif($ourphp_rs[12] == ''){$maximg = $ourphp_webpath.'skin/noimage.png';}else{$maximg=$ourphp_webpath.$ourphp_rs[12];}
	$rows = array(
				'id' => $ourphp_rs[0],
				'title' => $ourphp_rs[1],
				'number' => $ourphp_rs[2],
				'goodsno' => $ourphp_rs[3],
				'brand' => opcmsbrand($ourphp_rs[4]),
				'market' => $ourphp_rs[5],
				'webmarket' => $ourphp_rs[6],
				'stock' => $ourphp_rs[7],
				'specificationsid' => $ourphp_rs[8],
				'specifications' => $ourphp_rs[9],
				'attribute' => Attribute($ourphp_rs[10]),
				'minimg' => $minimg,
				'maximg' => $maximg,
				'content' => $ourphp_rs[13],
				'img' => imgimg($ourphp_rs[14]),
				'url' => $ourphp_rs[15],
				'description' => $ourphp_rs[16],
				'click' => $ourphp_rs[17],
				'time' => $ourphp_rs[18],
				'class' => $ourphp_rs[19],
				'tag' => keywords_tag($ourphp_rs[20]),
				'usermoney' => $ourphp_rs[21],
				'freight' => $ourphp_rs[22],
				'integral' => $ourphp_rs[23],
				'integralexchange' => $ourphp_rs[24],

	);
	//echo print_r($rows['brand']);
	if ($rows['url'] == ''){}else{header("location: ".$rows['url']);}
break;

case "photoview":
	$query = $db-> sqllist("update `ourphp_photo` set OP_Click = OP_Click + 1 where `id` = ".$viewid);
	$ourphp_rs = $db-> ourphpsql("select id,OP_Phototitle,time,OP_Photocminimg,OP_Photoimg,OP_Photocontent,OP_Class,OP_Tag,OP_Url,OP_Description,OP_Click from `ourphp_photo` where `id` = ".$viewid); 
	if(substr($ourphp_rs[3],0,7) == 'http://'){$minimg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[3];}
	$rows = array(
				'id' => $ourphp_rs[0],
				'title' => $ourphp_rs[1],
				'time' => $ourphp_rs[2],
				'minimg' => $minimg,
				'img' => imgimg($ourphp_rs[4]),
				'content' => $ourphp_rs[5],
				'class' => $ourphp_rs[6],
				'tag' => keywords_tag($ourphp_rs[7]),
				'url' => $ourphp_rs[8],
				'description' => $ourphp_rs[9],
				'click' => $ourphp_rs[10],

	);
	
	if ($rows['url'] == ''){}else{header("location: ".$rows['url']);}
break;

case "videoview":
	$query = $db-> sqllist("update `ourphp_video` set OP_Click = OP_Click + 1 where `id` = ".$viewid);
	$ourphp_rs = $db-> ourphpsql("select id,OP_Videotitle,time,OP_Videoimg,OP_Videovurl,OP_Videoformat,OP_Videowidth,OP_Videoheight,OP_Videocontent,OP_Class,OP_Tag,OP_Url,OP_Description,OP_Click from `ourphp_video` where `id` = ".$viewid); 
	if(substr($ourphp_rs[3],0,7) == 'http://'){$minimg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[3];}
	$rows = array(
				'id' => $ourphp_rs[0],
				'title' => $ourphp_rs[1],
				'time' => $ourphp_rs[2],
				'minimg' => $minimg,
				'playurl' => $ourphp_rs[4],
				'format' => $ourphp_rs[5],
				'width' => $ourphp_rs[6],
				'height' => $ourphp_rs[7],
				'content' => $ourphp_rs[8],
				'class' => $ourphp_rs[9],
				'tag' => keywords_tag($ourphp_rs[10]),
				'url' => $ourphp_rs[11],
				'description' => $ourphp_rs[12],
				'click' => $ourphp_rs[13],
				'player' => videoplay($ourphp_rs[4],$ourphp_rs[6],$ourphp_rs[7],$ourphp_rs[5]),

	);
	
	if ($rows['url'] == ''){}else{header("location: ".$rows['url']);}
break;

case "about":
	if(!is_file(WEB_ROOT.'/'.$ourphp_cache.'aboutview_'.md5($listid).'.txt')){
	$ourphp_rs = $db-> ourphpsql("select id,OP_Columntitle,OP_Url,OP_About,OP_Userright from `ourphp_column` where `id` = ".$listid); 
	$rows = array(
				'id' => $ourphp_rs[0],
				'title' => $ourphp_rs[1],
				'url' => $ourphp_rs[2],
				'content' => $ourphp_rs[3],

	);
	ourphp_file($ourphp_cache.'aboutview_'.md5($listid).'.txt',json_encode($rows),2);
	}else{
	$arraytojson = json_decode(file_get_contents(WEB_ROOT.'/'.$ourphp_cache.'aboutview_'.md5($listid).'.txt'));
	$rows=object_array($arraytojson);
	}
break;

case "clubview":
	$listpage = $Parameterse['page'][6];
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_book` where `OP_Bookclass` = ".$listid);
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	
	$query = $db-> sqllist("select id,OP_Bookcontent,OP_Bookname,OP_Booktel,OP_Bookip,OP_Bookreply,time from `ourphp_book` where `OP_Bookclass` = ".$listid." order by id desc LIMIT ".$start.",".$listpage); 
	$rows=array();
	$i=1;
	while($ourphp_rs = mysql_fetch_array($query)){
				$ip = explode('.',$ourphp_rs[4]);
				$rows[] = array(
								'id' => $ourphp_rs[0],
								'content' => $ourphp_rs[1],
								'name' => $ourphp_rs[2],
								'tel' => $ourphp_rs[3],
								'ip' => $ip[0].'.'.$ip[1].'.'.$ip[2].'.**',
								'reply' => $ourphp_rs[5],
								'time' => $ourphp_rs[6],
				);
	$i+=1;
	}
	
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
break;

case "downview":
	$query = $db-> sqllist("update `ourphp_down` set OP_Click = OP_Click + 1 where `id` = ".$viewid);
	$ourphp_rs = $db-> ourphpsql("select id,OP_Downtitle,time,OP_Downimg,OP_Downdurl,OP_Downcontent,OP_Downempower,OP_Downtype,OP_Downlang,OP_Downsize,OP_Downmake,OP_Lang,OP_Url,OP_Description,OP_Click,OP_Class,OP_Downsetup,OP_Random,OP_Tag from `ourphp_down` where `id` = ".$viewid); 
	if(substr($ourphp_rs[3],0,7) == 'http://'){$minimg = $ourphp_rs[3];}elseif($ourphp_rs[3] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[3];}
	$rows = array(
				"id" => $ourphp_rs[0],
				"title" => $ourphp_rs[1],
				"time" => $ourphp_rs[2],
				"minimg" => $minimg,
				"downurl" => $ourphp_webpath.'function/ourphp_play.class.php?ourphp_down='.$ourphp_rs[0].'&code='.$ourphp_rs[17],
				"content" => $ourphp_rs[5],
				"empower" => $ourphp_rs[6],
				"type" => $ourphp_rs[7],
				"lang" => $ourphp_rs[8],
				"size" => $ourphp_rs[9],
				"make" => $ourphp_rs[10],
				"url" => $ourphp_rs[12],
				"description" => $ourphp_rs[13],
				"click" => $ourphp_rs[14],
				"class" => $ourphp_rs[15],
				"setup" => $ourphp_rs[16],
				"tag" => keywords_tag($ourphp_rs[17]),

	);
	
	if ($rows['url'] == ''){}else{header("location: ".$rows['url']);}
break;

case "jobview":
	$query = $db-> sqllist("update `ourphp_job` set OP_Click = OP_Click + 1 where `id` = ".$viewid);
	$ourphp_rs = $db-> ourphpsql("select `id`, `OP_Jobtitle`, `time`, `OP_Jobwork`, `OP_Jobadd`, `OP_Jobnature`, `OP_Jobexperience`, `OP_Jobeducation`, `OP_Jobnumber`, `OP_Jobage`, `OP_Jobwelfare`, `OP_Jobwage`, `OP_Jobcontact`, `OP_Jobtel`, `OP_Jobcontent`, `OP_Class`, `OP_Lang`, `OP_Url`, `OP_Description`, `OP_Click`,`OP_Tag` from `ourphp_job` where `id` = ".$viewid); 
	$rows = array(
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
				"class" => $ourphp_rs[15],
				"url" => $ourphp_rs[17],
				"description" => $ourphp_rs[18],
				"click" => $ourphp_rs[19],
				"tag" => keywords_tag($ourphp_rs[20]),

	);
	
	if ($rows['url'] == ''){}else{header("location: ".$rows['url']);}
break;


}

$smarty->assign('opcms',$rows);
$smarty->assign('bookform',$ourphp_webpath.'function/ourphp_play.class.php?ourphp_cms=add');
?>