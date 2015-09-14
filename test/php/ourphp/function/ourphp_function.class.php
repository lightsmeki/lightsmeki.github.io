<?php
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
if(!defined('OURPHPNO')){exit('no!');}

function dowith_sql($ourphpstr){
   $ourphpstr = addslashes($ourphpstr);
   $ourphpstr = str_ireplace("and","　and",$ourphpstr);
   $ourphpstr = str_ireplace("or","　or",$ourphpstr);
   $ourphpstr = str_ireplace("execute","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("update","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("count","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("chr","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("mid","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("master","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("truncate","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("char","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("declare","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("select","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("create","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("delete","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("insert","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("&&","",$ourphpstr);
   $ourphpstr = str_ireplace("||","",$ourphpstr);
   $ourphpstr = str_ireplace("%","\%",$ourphpstr);
   $ourphpstr = str_ireplace("_","\_",$ourphpstr);
   $ourphpstr = str_ireplace("alert","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("md5","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("script","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("iframe","ourphp",$ourphpstr);
   return $ourphpstr;
}

function admin_sql($ourphpstr){
   $ourphpstr = str_ireplace("execute","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("update","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("count","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("chr","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("mid","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("master","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("truncate","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("char","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("declare","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("create","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("delete","ourphpourphp",$ourphpstr);
   $ourphpstr = str_ireplace("insert","",$ourphpstr);
   $ourphpstr = str_ireplace("&&","",$ourphpstr);
   $ourphpstr = str_ireplace("||","",$ourphpstr);
   $ourphpstr = str_ireplace("script","ourphp",$ourphpstr);
   $ourphpstr = str_ireplace("iframe","ourphp",$ourphpstr);
   return $ourphpstr;
}
/*
* 过虑URL中的ID ?ch-list-article-$id.html
* $str=substr($str,7);//去除前面
*/
function ourphp_Cut($ourphpstr){
	$n=strpos($ourphpstr,'.');
	if ($n) $ourphpstr=substr($ourphpstr,0,$n);
	return $ourphpstr;
}

/*
 * @param string $str 被截取的字符串 
 * @param integer $start 起始位置 
 * @param integer $length 截取长度(每个汉字为3字节) 
 */  
 
function utf8_strcut($str, $start, $length=null) {  
	 preg_match_all('/./us', $str, $match);  
	 $chars = is_null($length)? array_slice($match[0], $start ) : array_slice($match[0], $start, $length);  
	 unset($str);
	 return implode('', $chars);  
}  

/*
 * 随机生成一组32位字符，可用于验证
 * 调用方式randomkeys(18)
 */  
function randomkeys($length)
{
 $key = "";
 $pattern='1234567890abcdefghijklmnopqrstuvwxyz';
 for($i=0;$i<$length;$i++){
   $key .= $pattern{mt_rand(0,35)};
 }
 return $key.date("YmdHis");
}

/*
 * 压缩html : 清除换行符,清除制表符,去掉注释标记  
 * @param $string  
 * @return  压缩后的$string 
 */
function compress_html($string) {  
    $string = str_replace("\r\n", '', $string); //清除换行符  
    $string = str_replace("\n", '', $string); //清除换行符  
    $string = str_replace("\t", '', $string); //清除制表符  
    $pattern = array (  
                    "/> *([^ ]*) *</", //去掉注释标记  
                    "/[\s]+/",  
                    "/<!--[^!]*-->/",  
                    "/\" /",  
                    "/ \"/",  
                    "'/\*[^*]*\*/'"  
                    );  
    $replace = array (  
                    ">\\1<",  
                    " ",  
                    "",  
                    "\"",  
                    "\"",  
                    ""  
                    );  
    return preg_replace($pattern, $replace, $string);  
}

/*
 * 替换中间字符为 ***   
 */
function half_replace($str){
    $len = strlen($str)/2;
    return substr_replace($str,str_repeat('*',$len),ceil(($len)/2),$len);
}

function footby(){
	global $ourphp_empower;
	if ($ourphp_empower == 1){
	return;
	}else{
	return 'Powered by <a href="http://www.ourphp.net" target="_blank">www.Ourphp.net</a>';
	}
}

/*
 * 判断手机或电脑   
 */
function isMobile(){  
	$useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';  
	$useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';  	  
	function CheckSubstrs($substrs,$text){  
		foreach($substrs as $substr)  
			if(false!==strpos($text,$substr)){  
				return true;  
			}  
			return false;  
	}
	$mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
	$mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');  
		  
	$found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||  
			  CheckSubstrs($mobile_token_list,$useragent);  
		  
	if ($found_mobile){  
		return true;  
	}else{  
		return false;  
	}  
}

/*
 * 处理缓存文件 
 */

function ourphp_file($file,$content,$class){
	global $ourphp_webpath;
	$of = fopen(WEB_ROOT.'/'.$file,'w');
	if($of){
		if($class=1){
		$con = fwrite($of,$content);
		}elseif($class==2){
		$con = fwrite($op,$content);
		}
	}
	return $con;
	fclose($of);
}

/*
 * 处理json传递的数组 
 */
function object_array($array){
   if(is_object($array)){
    $array = (array)$array;
   }
   if(is_array($array)){
    foreach($array as $key=>$value){
     $array[$key] = object_array($value);
    }
   }
   return $array;
}

/*
 * 简单的数据处理类 
 */
class db{

		function ourphpsql($sql=''){
			global $conn; 
			$query = mysql_query($sql)or die(mysql_error());
			$ourphp_rs = mysql_fetch_array($query);
			return $ourphp_rs;
			mysql_free_result($query);
		} 
		
		function sqllist($sql){
			global $conn; 
			$query = mysql_query($sql)or die(mysql_error());
			return $query;
			mysql_free_result($query);
		} 
		
		public function plugsclass($name='',$class='') {
			global $conn; 
			$query = mysql_query("select `OP_Key` from `ourphp_api` where `OP_Key` like '%$name%'");
			$ourphp_rs = mysql_fetch_array($query);
			$api = explode('|',$ourphp_rs[0]);
			mysql_free_result($query);
			if ($api[1] == 1){
				if(strstr($ourphp_rs[0],$class)){
					return "200";
				}else{
					return "-1";
				}
			}else{
				return "-1";
			}
		}
		
}
$db=new db;

/*
 * 处理敏感字 
 */
function ourphp_sensitive($content=''){
	global $db;
	$sensitive = $db-> ourphpsql("select `OP_Sensitive` from `ourphp_webdeploy` where `id` = 1");
	$var=explode("|",$sensitive[0]);
	$vartwo = array_combine($var,array_fill(0,count($var),'*'));
return strtr($content, $vartwo);
}

$homelang = $db-> ourphpsql("select `OP_Home` from `ourphp_webdeploy` where `id` = 1");
$homelang = explode('|',$homelang[0]);
?>