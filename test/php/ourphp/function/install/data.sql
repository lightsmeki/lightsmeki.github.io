UPDATE `ourphp_web` set 
 `OP_Weblogo` = 'function/uploadfile/ourphp888/logo.png',
 `OP_Webname` = '哈尔滨伟成科技有限公司', 
 `OP_Webadd` = '黑龙江省哈尔滨市双城区文昌大街', 
 `OP_Webtel` = '4006260451', 
 `OP_Webmobi` = '13199509559', 
 `OP_Webfax` = '045183209995', 
 `OP_Webemail` = '77701950@qq.com', 
 `OP_Webzip` = '150100', 
 `OP_Webqq` = '77701950', 
 `OP_Weblinkman` = '唐晓伟', 
 `OP_Webicp` = '--', 
 `OP_Webstatistics` = '',
 `OP_Websitemin` = '【OURPHP】'
  where id = 1;

INSERT INTO `ourphp_column` (`id`, `OP_Uid`, `OP_Lang`, `OP_Columntitle`, `OP_Columntitleto`, `OP_Model`, `OP_Templist`, `OP_Tempview`, `OP_Url`, `OP_About`, `OP_Hide`, `OP_Sorting`, `OP_Briefing`, `OP_Img`, `OP_Userright`, `OP_Weight`) VALUES

(2, 0, 'cn', '企业商城', '', 'weburl', '', '', '?cn-shop.html', '', 0, 2, '', '', '0', '0'),
(3, 0, 'cn', '公司新闻', '', 'article', 'cn_article.html', 'cn_articleview.html', '', '', 0, 3, '', '', '0', '0'),
(4, 0, 'cn', '公司产品', '', 'product', 'cn_product.html', 'cn_productview.html', '', '', 0, 4, '', '', '0', '0'),
(5, 0, 'cn', '公司案例', '', 'photo', 'cn_photo.html', 'cn_photoview.html', '', '', 0, 5, '', '', '0', '0'),
(6, 0, 'cn', '视频展示', '', 'video', 'cn_video.html', 'cn_videoview.html', '', '', 0, 6, '', '', '0', '0'),
(7, 0, 'cn', '资料下载', '', 'down', 'cn_down.html', 'cn_downview.html', '', '', 0, 7, '', '', '0', '0'),
(8, 0, 'cn', '在线招聘', '', 'job', 'cn_job.html', 'cn_jobview.html', '', '', 0, 8, '', '', '0', '0'),
(9, 0, 'cn', '关于我们', '', 'about', '', 'cn_about.html', '', '<p>5分钟<br>即可开启企业网购官网，树立品牌形象！<br>1秒钟<br>让您的企业网站变成大企业范儿！<br>没错，这就是OURPHP！<br>什么是OURPHP?<br>OURPHP是一款快速、安全、结合电商功能的企业网站建站系统，傲派、OP、OPCMS都是它的名子。<br>OURPHP的优势是什么?<br>它：安全，快速。<br>它：有强大的技术后盾<br>它：不仅仅是一个企业建站平台，更是一个电商平台<br>它：理论上可以创建世界上任何国家语言的网站<br>它：等待你更多的发现。<br>OURPHP能做什么?<br>简单的说，ourphp可以快速、安全的开启一个大气、功能强大的企业网站，它不但可以帮助您的企业<br>树立形象，还可以实现在您自已的官方网站上展开电子商务。ourphp理论上支持创建世界上所有国家语<br>言的网站，是您做外贸的一个好帮手。它还可以像淘宝、小米那样开展电子商城，它还支持文章、商品<br>、图集、下载、招聘、视频等所有满足您建站功能的需求。<br>ourphp实现在搭建企业网站的同时，可以让企业在自已的平台上展开电子商务。ourphp就是这么任性！<br>OURPHP的使命是什么?<br>帮助中国企业搭建官网平台，并在自已的平台上实现电商之路！<br>', 0, 9, '', '', '0', '0'),
(10, 0, 'cn', '在线留言', '', 'weburl', '', '', '?cn-club.html', '', 0, 10, '', '', '0', '0'),
(11, 2, 'cn', '积分兑换', '系统栏目', 'product', 'cn_integral.html', 'cn_integralview.html', '', '', 1, 0, '', '', '0', '0'),
(12, 2, 'cn', '手机数码', '', 'product', 'cn_shoplist.html', 'cn_shopview.html', '', '', 0, 1, '', '', '0', '0'),
(13, 2, 'cn', '男装女装', '', 'product', 'cn_shoplist.html', 'cn_shopview.html', '', '', 0, 2, '', '', '0', '0'),
(14, 2, 'cn', '鞋靴箱包', '', 'product', 'cn_shoplist.html', 'cn_shopview.html', '', '', 0, 3, '', '', '0', '0'),
(15, 2, 'cn', '护外运动', '', 'product', 'cn_shoplist.html', 'cn_shopview.html', '', '', 0, 4, '', '', '0', '0'),
(16, 2, 'cn', '珠宝配饰', '', 'product', 'cn_shoplist.html', 'cn_shopview.html', '', '', 0, 5, '', '', '0', '0'),
(17, 2, 'cn', '护肤彩妆', '', 'product', 'cn_shoplist.html', 'cn_shopview.html', '', '', 0, 6, '', '', '0', '0');

INSERT INTO `ourphp_banner` (`id`, `OP_Bannerimg`, `OP_Bannertitle`, `OP_Bannerurl`, `OP_Bannerlang`, `time`) VALUES
(1, 'function/uploadfile/ourphp888/1.png', 'banner1', '#', 'cn', '2014-12-06 17:27:56'),
(2, 'function/uploadfile/ourphp888/2.png', 'banner2', '#', 'cn', '2014-12-06 18:01:55');

INSERT INTO `ourphp_link` (`id`, `OP_Linkname`, `OP_Linkurl`, `OP_Linkclass`, `OP_Linkimg`, `OP_Linksorting`, `OP_Linkstate`, `time`) VALUES
(1, 'Ourphp', 'http://www.ourphp.net', 'font', 'http://', '99', 1, '2014-12-07 17:49:10'),
(2, 'YidaCMS', 'http://yidacms.com', 'font', 'http://', '99', 1, '2014-12-07 17:49:10');

INSERT INTO `ourphp_article` (`id`, `OP_Articletitle`, `OP_Articleauthor`, `OP_Articlesource`, `time`, `OP_Articlecontent`, `OP_Class`, `OP_Lang`, `OP_Tag`, `OP_Sorting`, `OP_Attribute`, `OP_Url`, `OP_Description`, `OP_Click`, `OP_Minimg`, `OP_Callback`) VALUES
(1, '世界，你好！', '', '', '2014-12-07 15:59:33', '世界，你好！', '3', 'cn', '', 99, '', '', '世界，你好！', 0, 'skin/noimage.png', 0),
(2, '世界，你好！', '', '', '2014-12-07 15:59:43', '世界，你好！', '3', 'cn', '', 99, '', '', '世界，你好！', 0, 'skin/noimage.png', 0),
(3, '世界，你好！', '', '', '2014-12-07 16:02:04', '世界，你好！', '3', 'cn', '', 99, '', '', '世界，你好！', 0, 'skin/noimage.png', 0);

INSERT INTO `ourphp_product` (`id`, `OP_Class`, `OP_Lang`, `OP_Title`, `OP_Number`, `OP_Goodsno`, `OP_Brand`, `OP_Market`, `OP_Webmarket`, `OP_Stock`, `OP_Usermoney`, `OP_Specificationsid`,`OP_Specificationstitle`, `OP_Specifications`, `OP_Pattribute`, `OP_Minimg`, `OP_Maximg`, `OP_Img`, `OP_Content`, `OP_Down`, `OP_Tag`, `OP_Sorting`, `OP_Attribute`, `OP_Url`, `OP_Description`, `OP_Click`, `time`) VALUES
(1, 12, 'cn', '测试01', 'OP20141209155321', 'OP20141209155321', '', '0.00', '0.00', 100, '1:0.00|2:0.00|3:0.00|4:0.00|5:0.00', '', '','', '', 'function/uploadfile/ourphp888/pr1.jpg', 'function/uploadfile/ourphp888/ph1.jpg', '', '', 2, '', 99, '', '', '', 0, '2014-12-09 15:54:05'),
(2, 12, 'cn', '测试02', 'OP20141209155321', 'OP20141209155321', '', '0.00', '0.00', 100, '1:0.00|2:0.00|3:0.00|4:0.00|5:0.00', '', '','', '', 'function/uploadfile/ourphp888/pr1.jpg', 'function/uploadfile/ourphp888/ph1.jpg', '', '', 2, '', 99, '', '', '', 0, '2014-12-09 15:54:05'),
(3, 12, 'cn', '测试03', 'OP20141209155321', 'OP20141209155321', '', '0.00', '0.00', 100, '1:0.00|2:0.00|3:0.00|4:0.00|5:0.00', '', '','', '', 'function/uploadfile/ourphp888/pr1.jpg', 'function/uploadfile/ourphp888/ph1.jpg', '', '', 2, '', 99, '', '', '', 0, '2014-12-09 15:54:05'),
(4, 12, 'cn', '测试04', 'OP20141209155321', 'OP20141209155321', '', '0.00', '0.00', 100, '1:0.00|2:0.00|3:0.00|4:0.00|5:0.00', '', '','', '', 'function/uploadfile/ourphp888/pr1.jpg', 'function/uploadfile/ourphp888/ph1.jpg', '', '', 2, '', 99, '', '', '', 0, '2014-12-09 15:54:05'),
(5, 12, 'cn', '测试05', 'OP20141209155321', 'OP20141209155321', '', '0.00', '0.00', 100, '1:0.00|2:0.00|3:0.00|4:0.00|5:0.00', '', '','', '', 'function/uploadfile/ourphp888/pr1.jpg', 'function/uploadfile/ourphp888/ph1.jpg', '', '', 2, '', 99, '', '', '', 0, '2014-12-09 15:54:05'),
(6, 12, 'cn', '测试06', 'OP20141209155321', 'OP20141209155321', '', '0.00', '0.00', 100, '1:0.00|2:0.00|3:0.00|4:0.00|5:0.00', '', '','', '', 'function/uploadfile/ourphp888/pr1.jpg', 'function/uploadfile/ourphp888/ph1.jpg', '', '', 2, '', 99, '', '', '', 0, '2014-12-09 15:54:05'),
(7, 12, 'cn', '测试07', 'OP20141209155321', 'OP20141209155321', '', '0.00', '0.00', 100, '1:0.00|2:0.00|3:0.00|4:0.00|5:0.00', '', '','', '', 'function/uploadfile/ourphp888/pr1.jpg', 'function/uploadfile/ourphp888/ph1.jpg', '', '', 2, '', 99, '', '', '', 0, '2014-12-09 15:54:05'),
(8, 12, 'cn', '测试08', 'OP20141209155321', 'OP20141209155321', '', '0.00', '0.00', 100, '1:0.00|2:0.00|3:0.00|4:0.00|5:0.00', '', '','', '', 'function/uploadfile/ourphp888/pr1.jpg', 'function/uploadfile/ourphp888/ph1.jpg', '', '', 2, '', 99, '', '', '', 0, '2014-12-09 15:54:05');


INSERT INTO `ourphp_photo` (`id`, `OP_Phototitle`, `time`, `OP_Photocminimg`, `OP_Photoimg`, `OP_Photocontent`, `OP_Class`, `OP_Lang`, `OP_Tag`, `OP_Sorting`, `OP_Attribute`, `OP_Url`, `OP_Description`, `OP_Click`, `OP_Callback`) VALUES
(1, '测试01', '2014-12-09 16:25:29', 'function/uploadfile/ourphp888/ph1.jpg', '', '测试02', '5', 'cn', '', 99, '', '', '测试02', 0, 0),
(2, '测试02', '2014-12-09 16:25:29', 'function/uploadfile/ourphp888/ph1.jpg', '', '测试02', '5', 'cn', '', 99, '', '', '测试02', 0, 0),
(3, '测试03', '2014-12-09 16:25:29', 'function/uploadfile/ourphp888/ph1.jpg', '', '测试02', '5', 'cn', '', 99, '', '', '测试02', 0, 0),
(4, '测试04', '2014-12-09 16:25:29', 'function/uploadfile/ourphp888/ph1.jpg', '', '测试02', '5', 'cn', '', 99, '', '', '测试02', 0, 0),
(5, '测试05', '2014-12-09 16:25:29', 'function/uploadfile/ourphp888/ph1.jpg', '', '测试02', '5', 'cn', '', 99, '', '', '测试02', 0, 0);

INSERT INTO `ourphp_api` (`id`, `OP_Key`) VALUES(1, '快递100接口|2|key值');
INSERT INTO `ourphp_api` (`id`, `OP_Key`) VALUES(2, 'CNZZ网站流量统计|1|0|0');
INSERT INTO `ourphp_api` (`id`, `OP_Key`) VALUES(3, '支付宝[即时到账]接口|1|0|0|0');
INSERT INTO `ourphp_api` (`id`, `OP_Key`) VALUES(4, '支付宝[网银充值]接口|2|0|0|0');
INSERT INTO `ourphp_api` (`id`, `OP_Key`) VALUES(5, '微信登录API接口|2|0|0');
INSERT INTO `ourphp_api` (`id`, `OP_Key`) VALUES(6, '手机短信API接口|2|0|0|sendsms|regsms');
INSERT INTO `ourphp_api` (`id`, `OP_Key`) VALUES(7, 'QQ登录API接口|2|0|0');

/*
北京市|天津市|上海市|重庆市|国外|河北省|河南省|云南省|辽宁省|黑龙江省|湖南省|安徽省|山东省|新疆|江苏省|浙江省|江西省|湖北省|广西|甘肃省|山西省|内蒙古|陕西省|吉林省|福建省|贵州省|广东省|青海省|西藏|四川省|宁夏|海南省|台湾省|香港|澳门
*/
INSERT INTO `ourphp_freight` (`id`, `OP_Freightname`, `OP_Freighttext`, `OP_Freightdefault`, `OP_Freightweight`) VALUES(1, '包邮模板(官方默认)','0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0','1','0');
