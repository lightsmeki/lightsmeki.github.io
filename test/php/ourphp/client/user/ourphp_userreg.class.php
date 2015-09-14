<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

$regconfig = array(
					'introducer' => @$_GET['introducer'],
					);
					
function regsms() {
		global $db,$smarty;
		$op = $db->plugsclass("手机短信API接口","regsms");
		if($op == "-1"){
			return "";
		}else{
			$a = '<tr>'
				.'<td><div align="right">手机验证码：</div></td>'
				.'<td><input type="text" name="mobilecode" class="input3" datatype="*" />&nbsp;<input type="button" id="btn" value="免费获取验证码" />'
				.'&nbsp;&nbsp;<span id="mobilesn"></span>'
				.'</td>'
				.'</tr>';	
			return $a;
		}
}

$smarty->assign('regconfig',$regconfig);
$smarty->assign('regsms',regsms());
?>