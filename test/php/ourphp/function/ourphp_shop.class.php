<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
 *-------------------------------
 * 商城设置(2014-10-15)
 *-------------------------------
*/

function shopset() { 
global $db;
$ourphp_rs = $db-> ourphpsql("select OP_Pattern,OP_Scheme,OP_Stock,OP_buy,OP_Sendout,time,OP_Delivery from `ourphp_productset` where `id` = 1"); 
$rows = array(
		'pattern' => $ourphp_rs[0], //模式
		'scheme' => $ourphp_rs[1], //方案
		'stock' => $ourphp_rs[2],
		'buy' => $ourphp_rs[3], //订单
		'sendout' => $ourphp_rs[4], //发货
		'time' => $ourphp_rs[5],
		'delivery' => $ourphp_rs[6],
);
return $rows;
}

//处理属性
function Attribute($arr='') {
			if ($arr != ''){
			$pattribute = explode("|",$arr);
			foreach($pattribute as $op){
					$oparr = explode(":",$op);
					$opoparr[] = array(
										'name'=>$oparr[0],
										'key'=>$oparr[1],
									);
			}
			return $opoparr;
			}
}

function usermoneyleve($webmarket,$usermoney){
	global $db;
	$query = $db-> sqllist("select `id`,`OP_Userlevename` from `ourphp_userleve` order by id desc");
	$opcms = '';
	$Useremail = explode("|",$usermoney);
	while($ourphp_rs = mysql_fetch_array($query)){
		foreach($Useremail as $op){
					$Useremailto = explode(":",$op);
						if($ourphp_rs[0] == $Useremailto[0]){
						$opcms .= $ourphp_rs[1].'：'.($webmarket - $Useremailto[1]).'元　　　　　\n';
						}
		
		}
	}
	return $opcms;
}

//处理规格
$shopsetgg = shopset();
function Specifications($params, $smarty){
			global $db,$ourphp_webpath,$shopsetgg;
			
			include 'api/taobaoip/index.php';
			$ourphp_rs = $db-> ourphpsql("select `OP_Freighttext` from `ourphp_freight` where id = ".$params['freight']);
			$freightop = explode('|',$ourphp_rs[0]); //首重
			$city = explode('|','北京市|天津市|上海市|重庆市|国外|河北省|河南省|云南省|辽宁省|黑龙江省|湖南省|安徽省|山东省|新疆|江苏省|浙江省|江西省|湖北省|广西|甘肃省|山西省|内蒙古|陕西省|吉林省|福建省|贵州省|广东省|青海省|西藏|四川省|宁夏|海南省|台湾省|香港|澳门');

			$i=0;
			foreach($city as $op){
				if(strstr($taobaoip,$op)){
					$ok = $i;
					break;
				}else{
					$ok = 4;
				}
				$i += 1;
			}
			
			
	if ($params['id'] != ''){
	$query = $db-> sqllist("select id,OP_Title,OP_Value from `ourphp_productspecifications` where id in (".$params['id'].")");
	$gg = '';
	$gg = $gg . '<LINK href="'.$ourphp_webpath.'function/plugs/product/base.css" rel=stylesheet>';
	$gg = $gg . '<script>';
	$gg = $gg . '$(document).ready(function(){';
	$gg = $gg . '$("#add").click(function(){';
	$gg = $gg . '  var n=$("#num").val();';
	$gg = $gg . '  var num=parseInt(n)+1;';
	$gg = $gg . ' if(num==0){alert("cc");}';
	$gg = $gg . '  $("#num").val(num);';
	$gg = $gg . '});';
	$gg = $gg . '$("#jian").click(function(){';
	$gg = $gg . '  var n=$("#num").val();';
	$gg = $gg . '  var num=parseInt(n)-1;';
	$gg = $gg . ' if(num==0){alert("不能为0!"); return}';
	$gg = $gg . '  $("#num").val(num);';
	$gg = $gg . '  });';
	$gg = $gg . '});';
	$gg = $gg . '</script>';
	$gg = $gg . '	<div class="sys_item_spec">';
	$gg = $gg . '		<dl class="clearfix iteminfo_parameter lh32">';
	$gg = $gg . '			<dt>'.$params['numberfont'].$params['symbol'].'</dt>';
	$gg = $gg . '			<dd><span class="sys_item_goodsno">'.$params['number'].'</span></dd>';
	$gg = $gg . '		</dl>';
	$gg = $gg . '		<dl class="clearfix iteminfo_parameter iteminfo_parameter_default lh32">';
	$gg = $gg . '			<dt>'.$params['mktpricefont'].$params['symbol'].'</dt>';
	$gg = $gg . '			<dd><span class="iteminfo_mktprice">$<b class="sys_item_mktprice">'.$params['mktprice'].'</b></span></dd>';
	$gg = $gg . '		</dl>';
	$gg = $gg . '		<dl class="clearfix iteminfo_parameter lh32">';
	$gg = $gg . '			<dt>'.$params['pricefont'].$params['symbol'].'</dt>';
	$gg = $gg . '			<dd><span class="iteminfo_price">$ <b class="sys_item_price">'.$params['price'].'</b></span></dd>';
	$gg = $gg . '		</dl>';
	
	if($shopsetgg['scheme'] == 2){
	$gg = $gg . '		<dl class="clearfix iteminfo_parameter lh32">';
	$gg = $gg . '			<dt></dt>';
	$gg = $gg . '			<dd><span class="iteminfo_price"><a href="#a" onclick="alert(\''.usermoneyleve($params['price'],$params['usermoney']).'\')" name="a"><font style="font-size:12px">'.$params['vipfont'].'</font></a></span></dd>';
	$gg = $gg . '		</dl>';
	}
	
	$i=1;
	while($ourphp_rs = mysql_fetch_array($query)){
	$OP_Value = explode("|",$ourphp_rs[2]);
	$gg = $gg . '		<dl class="clearfix iteminfo_parameter sys_item_specpara" data-sid="'.$i.'">';
	$gg = $gg . '			<dt>'.$ourphp_rs[1].$params['symbol'].'</dt>';
	$gg = $gg . '			<dd>';
	$gg = $gg . '				<ul class="sys_spec_text">';
	foreach($OP_Value as $op){
	$gg = $gg . '					<li data-aid="'.$op.'"><a href="javascript:;" title="'.$op.'">'.$op.'</a><i></i></li>';
	}
	$gg = $gg . '				</ul>';
	$gg = $gg . '				<div style="clear:both;"></div>';
	$gg = $gg . '			</dd>';
	$gg = $gg . '		</dl>';
	$i+=1;
	}
	$gg = $gg . '		<dl class="clearfix iteminfo_parameter lh32">';
	$gg = $gg . '			<dt>'.$params['stock'].$params['symbol'].'</dt>';
	$gg = $gg . '			<dd><span class="sys_item_stock">'.$params['stocks'].'</span></dd>';
	$gg = $gg . '		</dl>';
	$gg = $gg . '		<div style="clear:both;"></div>';
	$gg = $gg . '		<dl class="clearfix iteminfo_parameter lh32">';
	$gg = $gg . '			<dt>'.$params['amount'].$params['symbol'].'</dt>';
	$gg = $gg . '			<dd><input type="button" id="add" value="+" /><input type="text" id="num" name="sl" value="1" /><input type="button" id="jian" value="-" /></dd>';
	$gg = $gg . '		</dl>';
	$gg = $gg . '		<div style="clear:both;"></div>';
	$gg = $gg . '		<dl class="clearfix iteminfo_parameter lh32">';
	$gg = $gg . '			<dt>'.$params['freightfont'].$params['symbol'].'</dt>';
	$gg = $gg . '			<dd>'.$freightop[$ok].'.00</dd>';
	$gg = $gg . '		</dl>';
	$gg = $gg . '		<dl class="clearfix iteminfo_parameter lh32">';
	$gg = $gg . '			<input type="hidden" name="ourphp_kc" id="kc"　/>';
	$gg = $gg . '			<input type="hidden" name="ourphp_hh" id="hh"　/>';
	$gg = $gg . '			<input type="hidden" name="ourphp_sx" id="sx"　/>';
	$gg = $gg . '		</dl>';
	$gg = $gg . '	</div>';
	$ggsl = count(explode(",",$params['id']));
	
	$Specifications = explode("|",$params['arr']);
	$oparr = '';
	$oparrtop = '{';
	foreach($Specifications as $op){
			$opop = explode(",",$op);
			if($ggsl == 1){
			$oparr = $oparr.'"'.$opop[1].'":{"goodsno":"'.$opop[0].'","price":"'.$opop[3].'","mktprice":"'.$opop[2].'","stock":"'.$opop[4].'","opval":"'.$opop[1].'"},';
			}elseif($ggsl == 2){
			$oparr = $oparr.'"'.$opop[1].'_'.$opop[2].'":{"goodsno":"'.$opop[0].'","price":"'.$opop[4].'","mktprice":"'.$opop[3].'","stock":"'.$opop[5].'","opval":"'.$opop[1].'、'.$opop[2].'"},';
			}elseif($ggsl == 3){
			$oparr = $oparr.'"'.$opop[1].'_'.$opop[2].'_'.$opop[3].'":{"goodsno":"'.$opop[0].'","price":"'.$opop[5].'","mktprice":"'.$opop[4].'","stock":"'.$opop[6].'","opval":"'.$opop[1].'、'.$opop[2].'、'.$opop[3].'"},';
			}elseif($ggsl == 4){
			$oparr = $oparr.'"'.$opop[1].'_'.$opop[2].'_'.$opop[3].'_'.$opop[4].'":{"goodsno":"'.$opop[0].'","price":"'.$opop[6].'","mktprice":"'.$opop[5].'","stock":"'.$opop[7].'","opval":"'.$opop[1].'、'.$opop[2].'、'.$opop[3].'、'.$opop[4].'"},';
			}else{
			$oparr = '';
			}
	}
	$oparrfoot = '}';
	
	$gg = $gg . '<script>'."\n";
	$gg = $gg . 'var sys_item={'."\n";
	$gg = $gg . '	"mktprice":"'.$params['mktprice'].'",'."\n";
	$gg = $gg . '	"price":"'.$params['price'].'",'."\n";
	$gg = $gg . '	"sys_attrprice":'.$oparrtop.substr($oparr,0,-1).$oparrfoot.'};'."\n";
	$gg = $gg . '$(function(){'."\n";
	$gg = $gg . '	$(".sys_item_spec .sys_item_specpara").each(function(){'."\n";
	$gg = $gg . '		var i=$(this);'."\n";
	$gg = $gg . '		var p=i.find("ul>li");'."\n";
	$gg = $gg . '		p.click(function(){'."\n";
	$gg = $gg . '			if(!!$(this).hasClass("selected")){'."\n";
	$gg = $gg . '				$(this).removeClass("selected");'."\n";
	$gg = $gg . '				i.removeAttr("data-attrval");'."\n";
	$gg = $gg . '			}else{'."\n";
	$gg = $gg . '				$(this).addClass("selected").siblings("li").removeClass("selected");'."\n";
	$gg = $gg . '				i.attr("data-attrval",$(this).attr("data-aid"))'."\n";
	$gg = $gg . '			}'."\n";
	$gg = $gg . '			getattrprice()'."\n";
	$gg = $gg . '		})'."\n";
	$gg = $gg . '	})'."\n";
	$gg = $gg . '	function getattrprice(){'."\n";
	$gg = $gg . '		var defaultstats=true;'."\n";
	$gg = $gg . '		var _val="";'."\n";
	$gg = $gg . '		var _resp={'."\n";
	$gg = $gg . '			mktprice:".sys_item_mktprice",'."\n";
	$gg = $gg . '			price:".sys_item_price",'."\n";
	$gg = $gg . '			stock:".sys_item_stock",'."\n";
	$gg = $gg . '			goodsno:".sys_item_goodsno",'."\n";
	$gg = $gg . '			opval:".sys_item_opval"'."\n";
	$gg = $gg . '		}'."\n";
	$gg = $gg . '		$(".sys_item_spec .sys_item_specpara").each(function(){'."\n";
	$gg = $gg . '			var i=$(this);'."\n";
	$gg = $gg . '			var v=i.attr("data-attrval");'."\n";
	$gg = $gg . '			if(!v){'."\n";
	$gg = $gg . '				defaultstats=false;'."\n";
	$gg = $gg . '			}else{'."\n";
	$gg = $gg . '				_val+=_val!=""?"_":"";'."\n";
	$gg = $gg . '				_val+=v;'."\n";
	$gg = $gg . '			}'."\n";
	$gg = $gg . '		})'."\n";
	$gg = $gg . '		if(!!defaultstats){'."\n";
	$gg = $gg . '			_mktprice=sys_item["sys_attrprice"][_val]["mktprice"];'."\n";
	$gg = $gg . '			_price=sys_item["sys_attrprice"][_val]["price"];'."\n";
	$gg = $gg . '			_stock=sys_item["sys_attrprice"][_val]["stock"];'."\n";
	$gg = $gg . '			_goodsno=sys_item["sys_attrprice"][_val]["goodsno"];'."\n";
	$gg = $gg . '			_opval=sys_item["sys_attrprice"][_val]["opval"];'."\n";
	$gg = $gg . '		}else{'."\n";
	$gg = $gg . '			_mktprice=sys_item["mktprice"];'."\n";
	$gg = $gg . '			_price=sys_item["price"];'."\n";
	$gg = $gg . '			_stock=sys_item["stock"];'."\n";
	$gg = $gg . '			_goodsno=sys_item["goodsno"];'."\n";
	$gg = $gg . '			_opval=sys_item["_opval"];'."\n";
	$gg = $gg . '		}'."\n";
	$gg = $gg . '		$(_resp.mktprice).text(_mktprice);'."\n";
	if($shopsetgg['scheme'] == 1){
	$gg = $gg . '		$(_resp.price).text("'.$params['price'].'");'."\n";
	}elseif($shopsetgg['scheme'] == 2){
	$gg = $gg . '		$(_resp.price).text(_price);'."\n";
	}
	$gg = $gg . '		$(_resp.stock).text(_stock);'."\n";
	$gg = $gg . '		$(_resp.goodsno).text(_goodsno);'."\n";
	$gg = $gg . '		$(_resp.opval).text(_opval);'."\n";
	//赋值
	$gg = $gg . '		$("#kc").val(_stock);'."\n";
	$gg = $gg . '		$("#hh").val(_goodsno);'."\n";
	$gg = $gg . '		$("#sx").val(_opval);'."\n";
	$gg = $gg . '	}'."\n";
	$gg = $gg . '})'."\n";
	$gg = $gg . '</script>';
		
			return $gg;
	}else{
	$gg = '';
	$gg = $gg . '<LINK href="'.$ourphp_webpath.'function/plugs/product/base.css" rel=stylesheet>';
	$gg = $gg . '<script>';
	$gg = $gg . '$(document).ready(function(){';
	$gg = $gg . '$("#add").click(function(){';
	$gg = $gg . '  var n=$("#num").val();';
	$gg = $gg . '  var num=parseInt(n)+1;';
	$gg = $gg . ' if(num==0){alert("cc");}';
	$gg = $gg . '  $("#num").val(num);';
	$gg = $gg . '});';
	$gg = $gg . '$("#jian").click(function(){';
	$gg = $gg . '  var n=$("#num").val();';
	$gg = $gg . '  var num=parseInt(n)-1;';
	$gg = $gg . ' if(num==0){alert("不能为0!"); return}';
	$gg = $gg . '  $("#num").val(num);';
	$gg = $gg . '  });';
	$gg = $gg . '});';
	$gg = $gg . '</script>';
	$gg = $gg . '<li>'.$params['numberfont'].$params['symbol'].$params['number'].'</li>';
	$gg = $gg . '<li>'.$params['mktpricefont'].$params['symbol'].$params['mktprice'].'</li>';
	$gg = $gg . '<li>'.$params['pricefont'].$params['symbol'].$params['price'].'</li>';
	$gg = $gg . '<li>'.$params['stock'].$params['symbol'].$params['stocks'].'</li>';
	$gg = $gg . '<li><span style="float:left;">'.$params['amount'].$params['symbol'].'</span><span style="float:left;"><input type="button" id="add" value="+" /><input type="text" id="num" name="sl" value="1" /><input type="button" id="jian" value="-" /></span></li><div style="clear:both;"></div>';
	$gg = $gg . '<li>'.$params['freightfont'].$params['symbol'].$freightop[$ok].'.00</li>';
	$gg = $gg . '<li><input type="hidden" name="ourphp_kc" value="'.$params['stocks'].'"　/></li>';
	$gg = $gg . '<li><input type="hidden" name="ourphp_hh" value="'.$params['number'].'"　/></li>';
			return $gg;
	}
}
			
$smarty->assign('shopset',shopset());
$smarty->registerPlugin("function","ourphp_gg","Specifications");
?>