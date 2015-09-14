<?php
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php'; 

//这里是OURPHP的应用商店
//在这里,您可以浏览OURPHP最新,最酷的应用功能
//进入应用商店我们只读取了域名,和OURPHP版本信息
//不会对你的网站造成任何威胁,如果不想使用应用商店功能
//可以把$app = 1 ;改成 $app = 2 ; 就关闭了
//谢谢合作




$app = 1 ; //1开启 2关闭




if($app == 1){
$rs = $db-> ourphpsql("select `OP_Weburl` from `ourphp_web` where id = 1"); 
$appurl = "http://www.ourphp.net/app/key.php?url=".$rs[0]."&p=".$ourphp_empower."&v=".$ourphp_versiondate;
header("location: ".$appurl);
}else{
echo '未开启应用商店!';
}
?>