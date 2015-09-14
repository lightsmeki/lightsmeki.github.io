DROP TABLE IF EXISTS ourphp_web;
CREATE TABLE `ourphp_web` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Website` varchar(255) NOT NULL default '',
`OP_Weburl` varchar(255) NOT NULL default '',
`OP_Weblogo` varchar(255) NOT NULL default '',
`OP_Webname` varchar(255) NOT NULL default '',
`OP_Webadd` varchar(255) NOT NULL default '',
`OP_Webtel` varchar(255) NOT NULL default '',
`OP_Webmobi` varchar(255) NOT NULL default '',
`OP_Webfax` varchar(255) NOT NULL default '',
`OP_Webemail` varchar(255) NOT NULL default '',
`OP_Webzip` varchar(255) NOT NULL default '',
`OP_Webqq` varchar(255) NOT NULL default '',
`OP_Weblinkman` varchar(255) NOT NULL default '',
`OP_Webicp` varchar(255) NOT NULL default '',
`OP_Webstatistics` text NOT NULL,
`OP_Webtime` varchar(255) NOT NULL default '',
`OP_Webourphpurl` varchar(255) NOT NULL default '',
`OP_Webourphpcode` text NOT NULL,
`OP_Webourphpu` text NOT NULL,
`OP_Webourphpp` text NOT NULL,
`OP_Websitemin` varchar(255) NOT NULL default '',
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_wap;
CREATE TABLE `ourphp_wap` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Website` varchar(255) NOT NULL default '',
`OP_Weblogo` varchar(255) NOT NULL default '',
`OP_Webkeywords` text NOT NULL,
`OP_Webdescriptions` text NOT NULL,
`OP_Weburl` text NOT NULL,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_wap VALUES('1','我的手机网站','function/uploadfile/ourphp888/logo.png','','','');


DROP TABLE IF EXISTS ourphp_admin;
CREATE TABLE `ourphp_admin` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Adminname` varchar(255) NOT NULL default '',
`OP_Adminpass` varchar(255) NOT NULL default '',
`OP_Adminpower` text NOT NULL,
`OP_Admin` int(11) NOT NULL default '0', /*管理员主权限*/
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_article;
CREATE TABLE `ourphp_article` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Articletitle` varchar(255) NOT NULL default '',
`OP_Articleauthor` varchar(255) NOT NULL default '',
`OP_Articlesource` varchar(255) NOT NULL default '',
`time` datetime,
`OP_Articlecontent` text NOT NULL,
`OP_Class` varchar(255) NOT NULL default '',
`OP_Lang` varchar(255) NOT NULL default '',
`OP_Tag` varchar(255) NOT NULL default '',
`OP_Sorting` int(11) NOT NULL default '0', /*排序*/
`OP_Attribute` varchar(255) NOT NULL default '', /*属性*/
`OP_Url` varchar(255) NOT NULL default '',
`OP_Description` text NOT NULL, /*描述*/
`OP_Click` int(11) NOT NULL default '0', /*点击量*/
`OP_Minimg` text NOT NULL, /*缩略图*/
`OP_Callback` int(11) NOT NULL default '0', /*回收站 0=NO  1=YES*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_photo;
CREATE TABLE `ourphp_photo` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Phototitle` varchar(255) NOT NULL default '',
`time` datetime,
`OP_Photocminimg` varchar(255) NOT NULL default '',
`OP_Photoimg` text NOT NULL,
`OP_Photocontent` text NOT NULL,
`OP_Class` varchar(255) NOT NULL default '',
`OP_Lang` varchar(255) NOT NULL default '',
`OP_Tag` varchar(255) NOT NULL default '',
`OP_Sorting` int(11) NOT NULL default '0', /*排序*/
`OP_Attribute` varchar(255) NOT NULL default '', /*属性*/
`OP_Url` varchar(255) NOT NULL default '',
`OP_Description` text NOT NULL, /*描述*/
`OP_Click` int(11) NOT NULL default '0', /*点击量*/
`OP_Callback` int(11) NOT NULL default '0', /*回收站 0=NO  1=YES*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_video;
CREATE TABLE `ourphp_video` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Videotitle` varchar(255) NOT NULL default '',
`time` datetime,
`OP_Videoimg` text NOT NULL,
`OP_Videovurl` text NOT NULL,
`OP_Videoformat` varchar(255) NOT NULL default '',
`OP_Videowidth` int(11) NOT NULL default '0',
`OP_Videoheight` int(11) NOT NULL default '0',
`OP_Videocontent` text NOT NULL,
`OP_Class` varchar(255) NOT NULL default '',
`OP_Lang` varchar(255) NOT NULL default '',
`OP_Tag` varchar(255) NOT NULL default '',
`OP_Sorting` int(11) NOT NULL default '0', /*排序*/
`OP_Attribute` varchar(255) NOT NULL default '', /*属性*/
`OP_Url` varchar(255) NOT NULL default '',
`OP_Description` text NOT NULL, /*描述*/
`OP_Click` int(11) NOT NULL default '0', /*点击量*/
`OP_Callback` int(11) NOT NULL default '0', /*回收站 0=NO  1=YES*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_down;
CREATE TABLE `ourphp_down` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Downtitle` varchar(255) NOT NULL default '',
`time` datetime,
`OP_Downimg` text NOT NULL,
`OP_Downdurl` text NOT NULL,
`OP_Downcontent` text NOT NULL,
`OP_Downempower` varchar(255) NOT NULL default '',
`OP_Downtype` varchar(255) NOT NULL default '',
`OP_Downlang` varchar(255) NOT NULL default '',
`OP_Downsize` varchar(255) NOT NULL default '',
`OP_Class` varchar(255) NOT NULL default '',
`OP_Lang` varchar(255) NOT NULL default '',
`OP_Downmake` varchar(255) NOT NULL default '',
`OP_Downsetup` varchar(255) NOT NULL default '',
`OP_Tag` varchar(255) NOT NULL default '',
`OP_Downrights` varchar(255) NOT NULL default '', /*下载权限*/
`OP_Sorting` int(11) NOT NULL default '0', /*排序*/
`OP_Attribute` varchar(255) NOT NULL default '', /*属性*/
`OP_Url` varchar(255) NOT NULL default '',
`OP_Description` text NOT NULL, /*描述*/
`OP_Click` int(11) NOT NULL default '0', /*点击量*/
`OP_Random` text NOT NULL, /*随机的一个验证码，用于验证下载文件的*/
`OP_Callback` int(11) NOT NULL default '0', /*回收站 0=NO  1=YES*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_job;
CREATE TABLE `ourphp_job` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Jobtitle` varchar(255) NOT NULL default '',
`time` datetime,
`OP_Jobwork` varchar(255) NOT NULL default '',
`OP_Jobadd` varchar(255) NOT NULL default '',
`OP_Jobnature` varchar(255) NOT NULL default '',
`OP_Jobexperience` varchar(255) NOT NULL default '',
`OP_Jobeducation` varchar(255) NOT NULL default '',
`OP_Jobnumber` varchar(255) NOT NULL default '',
`OP_Jobage` varchar(255) NOT NULL default '',
`OP_Jobwelfare` varchar(255) NOT NULL default '',
`OP_Jobwage` varchar(255) NOT NULL default '',
`OP_Jobcontact` varchar(255) NOT NULL default '',
`OP_Jobtel` varchar(255) NOT NULL default '',
`OP_Jobcontent` text NOT NULL,
`OP_Class` varchar(255) NOT NULL default '',
`OP_Lang` varchar(255) NOT NULL default '',
`OP_Tag` varchar(255) NOT NULL default '',
`OP_Sorting` int(11) NOT NULL default '0', /*排序*/
`OP_Attribute` varchar(255) NOT NULL default '', /*属性*/
`OP_Url` varchar(255) NOT NULL default '',
`OP_Description` text NOT NULL, /*描述*/
`OP_Click` int(11) NOT NULL default '0', /*点击量*/
`OP_Callback` int(11) NOT NULL default '0', /*回收站 0=NO  1=YES*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_booksection;
CREATE TABLE `ourphp_booksection` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Booksectiontitle` varchar(255) NOT NULL default '',
`OP_Booksectioncontent` text NOT NULL,
`OP_Booksectionlanguage` varchar(255) NOT NULL default '',
`OP_Booksectionsorting` int(11) NOT NULL default '0',
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_booksection VALUES('1','问题反馈','在这里可以把您碰到的问题反馈给我们。','cn','0','2015-1-1 12:00:00');
INSERT INTO ourphp_booksection VALUES('2','客户服务','您有什么需求或是需要什么帮助，可以在这里留言哦！','cn','1','2015-1-1 12:00:00');

DROP TABLE IF EXISTS ourphp_usercontrol;
CREATE TABLE `ourphp_usercontrol` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Userreg` int(11) NOT NULL default '0', /*是否可以注册 1可以 2不可以*/
`OP_Userlogin` int(11) NOT NULL default '0', /*是否可以登录 1可以 2不可以*/
`OP_Userprotocol` text NOT NULL, /*注册协议*/
`OP_Usergroup` int(11) NOT NULL default '0', /*默认用户组*/
`OP_Usermoney` varchar(255) NOT NULL default '', /*注册增加多少现金和积分  现金|积分|推广现金|推广积分*/
`OP_Useripoff` int(11) NOT NULL default '0', /*开启IP限制，1开启 2关闭*/
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_usercontrol VALUES('1','1','1','欢迎您注册成为[.$ourphp_web.website.] 用户！','1','0|0|0|0','2','2015-1-1 12:00:00');

DROP TABLE IF EXISTS ourphp_user;
CREATE TABLE `ourphp_user` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Useremail` text NOT NULL,
`OP_Userpass` varchar(255) NOT NULL default '',

/*联系方式*/
`OP_Username` varchar(255) NOT NULL default '',
`OP_Usertel` varchar(255) NOT NULL default '',
`OP_Userqq` int(11) NOT NULL default '0',
`OP_Userskype` varchar(255) NOT NULL default '',
`OP_Useraliww` varchar(255) NOT NULL default '',
`OP_Useradd` varchar(255) NOT NULL default '',

/*其它*/
`OP_Userclass` int(11) NOT NULL default '0', /*会员级别*/
`OP_Usersource` varchar(255) NOT NULL default '',/*会员来源*/
`OP_Userhead` varchar(255) NOT NULL default '',/*会员头像*/
`OP_Usermoney` decimal(10,2) NOT NULL default '0', /*账户现金*/
`OP_Userintegral` decimal(10,2) NOT NULL default '0', /*账户积分*/
`OP_Userip` varchar(255) NOT NULL default '',/*会员ip地址*/
`OP_Userproblem` varchar(255) NOT NULL default '',/*会员找回密码时的问题*/
`OP_Useranswer` varchar(255) NOT NULL default '',/*会员找回密码时的答案*/
`OP_Userstatus` int(11) NOT NULL default '0', /*账户状态 1开启 2锁定*/
`OP_Usertext` text NOT NULL,/*人生宣言*/
`logintime` datetime,/*登录时间*/
`OP_Usercode` varchar(255) NOT NULL default '',
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_userproblem;
CREATE TABLE `ourphp_userproblem` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Userproblem` varchar(255) NOT NULL default '',
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_userproblem VALUES('1','你妈妈的姓名？','2015-1-1 12:00:00');
INSERT INTO ourphp_userproblem VALUES('2','你爸爸的姓名？','2015-1-1 12:00:00');
INSERT INTO ourphp_userproblem VALUES('3','你老婆的姓名？','2015-1-1 12:00:00');
INSERT INTO ourphp_userproblem VALUES('4','你的家乡在哪？','2015-1-1 12:00:00');
INSERT INTO ourphp_userproblem VALUES('5','你的大学是哪家学校？','2015-1-1 12:00:00');
INSERT INTO ourphp_userproblem VALUES('6','你老婆的生日？','2015-1-1 12:00:00');
INSERT INTO ourphp_userproblem VALUES('7','你自已的生日？','2015-1-1 12:00:00');

DROP TABLE IF EXISTS ourphp_userleve;
CREATE TABLE `ourphp_userleve` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Userlevename` varchar(255) NOT NULL default '',
`OP_Userweight` int(11) NOT NULL default '0', /*用户组权重*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_userleve VALUES('1','普通会员','10');
INSERT INTO ourphp_userleve VALUES('2','银牌会员','20');
INSERT INTO ourphp_userleve VALUES('3','金牌会员','30');
INSERT INTO ourphp_userleve VALUES('4','分销商','40');
INSERT INTO ourphp_userleve VALUES('5','代理商','50');


DROP TABLE IF EXISTS ourphp_usermessage;
CREATE TABLE `ourphp_usermessage` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Usersend` varchar(255) NOT NULL default '',
`OP_Usercollect` varchar(255) NOT NULL default '',
`OP_Usercontent` text NOT NULL,
`OP_Userclass` int(11) NOT NULL default '0',
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_userpay;
CREATE TABLE `ourphp_userpay` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Useremail` varchar(255) NOT NULL default '',
`OP_Usermoney` decimal(10,2) NOT NULL default '0', /*账户现金*/
`OP_Userintegral` decimal(10,2) NOT NULL default '0', /*账户积分*/
`OP_Usercontent` text NOT NULL,
`OP_Useradmin` varchar(255) NOT NULL default '',
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_book;
CREATE TABLE `ourphp_book` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Bookcontent` text NOT NULL,
`OP_Bookname` varchar(255) NOT NULL default '',
`OP_Booktel` varchar(255) NOT NULL default '',
`OP_Bookip` varchar(255) NOT NULL default '',
`OP_Bookclass` int(11) NOT NULL default '0',
`OP_Booklang` varchar(255) NOT NULL default '',
`OP_Bookreply` text NOT NULL,
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_banner;
CREATE TABLE `ourphp_banner` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Bannerimg` text NOT NULL,
`OP_Bannertitle` varchar(255) NOT NULL default '',
`OP_Bannerurl` varchar(255) NOT NULL default '',
`OP_Bannerlang` varchar(255) NOT NULL default '',
`time` datetime,
`OP_Bannerclass` int(11) NOT NULL default '0',
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ourphp_qq;
CREATE TABLE `ourphp_qq` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_QQname` varchar(255) NOT NULL default '',
`OP_QQnumber` varchar(255) NOT NULL default '',
`OP_QQclass` varchar(255) NOT NULL default '',
`OP_QQsorting` varchar(255) NOT NULL default '',
`OP_QQother` varchar(255) NOT NULL default '',
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_link;
CREATE TABLE `ourphp_link` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Linkname` varchar(255) NOT NULL default '',
`OP_Linkurl` varchar(255) NOT NULL default '',
`OP_Linkclass` varchar(255) NOT NULL default '',
`OP_Linkimg` text NOT NULL,
`OP_Linksorting` varchar(255) NOT NULL default '',
`OP_Linkstate` int(11) NOT NULL default '0', /*显示隐藏 1显示 2隐藏*/
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_ad;
CREATE TABLE `ourphp_ad` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Adtitle` varchar(255) NOT NULL default '',
`OP_Adcontent` text NOT NULL,
`OP_Adclass` varchar(255) NOT NULL default '',
`OP_Adpiaofui` varchar(255) NOT NULL default '',
`OP_Adpiaofuu` text NOT NULL,
`OP_Adyouxiat` varchar(255) NOT NULL default '',
`OP_Adyouxiaf` text NOT NULL,
`OP_Adduilianli` varchar(255) NOT NULL default '',
`OP_Adduilianlu` text NOT NULL,
`OP_Adduilianri` varchar(255) NOT NULL default '',
`OP_Adduilianru` text NOT NULL,
`OP_Adstateo` int(11) NOT NULL default '0',/*显示隐藏 1显示 2隐藏*/
`OP_Adstatet` int(11) NOT NULL default '0',
`OP_Adstates` int(11) NOT NULL default '0',
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_ad VALUES('1','全站顶部','','','../../skin/headerbanner.gif','','','','','','','','2','2','2','2015-1-1 12:00:00');
INSERT INTO ourphp_ad VALUES('2','全站底部','','','../../skin/footerbanner.gif','','','','','','','','2','2','2','2015-1-1 12:00:00');
INSERT INTO ourphp_ad VALUES('3','信息列表页','','','../../skin/threadlist.gif','','','','','','','','2','2','2','2015-1-1 12:00:00');
INSERT INTO ourphp_ad VALUES('4','信息内容页','','','../../skin/article.gif','','','','','','','','2','2','2','2015-1-1 12:00:00');
INSERT INTO ourphp_ad VALUES('5','特殊广告','','','','','','','','','','','2','2','2','2015-1-1 12:00:00');


DROP TABLE IF EXISTS ourphp_watermark;
CREATE TABLE `ourphp_watermark` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Watermarkimg` varchar(255) NOT NULL default '',
`OP_Watermarkfont` varchar(255) NOT NULL default '',
`OP_Watermarkcolor` varchar(255) NOT NULL default '',
`OP_Watermarksize` varchar(255) NOT NULL default '',
`OP_Watermarkposition` int(11) NOT NULL default '0',
`OP_Watermarkoff` int(11) NOT NULL default '0', /*1打开 2关闭*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_watermark VALUES('1','watermark.png','www.ourphp.net','#000000','5','9','2');

DROP TABLE IF EXISTS ourphp_temp;
CREATE TABLE `ourphp_temp` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Temppath` varchar(255) NOT NULL default '',
`OP_Tempauthor` varchar(255) NOT NULL default '',
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_lang;
CREATE TABLE `ourphp_lang` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Lang` varchar(255) NOT NULL default '',
`OP_Font` varchar(255) NOT NULL default '',
`OP_Default` varchar(255) NOT NULL default '',
`OP_Note` varchar(255) NOT NULL default '',
`OP_Langtitle` varchar(255) NOT NULL default '',
`OP_Langkeywords` text NOT NULL,
`OP_Langdescription` text NOT NULL,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_lang VALUES ('1','cn','中文','Default','中文语言唯一标识','','','');

DROP TABLE IF EXISTS ourphp_adminclick;
CREATE TABLE `ourphp_adminclick` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Title` varchar(255) NOT NULL default '',
`OP_Url` varchar(255) NOT NULL default '',
`OP_Click` int(11) NOT NULL default '0',
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_mail;
CREATE TABLE `ourphp_mail` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Mailsmtp` varchar(255) NOT NULL default '',
`OP_Mailport` int(11) NOT NULL default '0',
`OP_Mailusermail` varchar(255) NOT NULL default '',
`OP_Mailuser` varchar(255) NOT NULL default '',
`OP_Mailpass` varchar(255) NOT NULL default '',
`OP_Mailsubject` varchar(255) NOT NULL default '',
`OP_Mailcontent` text NOT NULL,
`OP_Mailtype` varchar(255) NOT NULL default '',
`OP_Mailtitle` varchar(255) NOT NULL default '', /*邮件类型*/
`OP_Mailclass` int(11) NOT NULL default '0', /*1开启 2关闭*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_mail VALUES('1','smtp.qq.com','25','993141000@qq.com','993141000','123456','这是一封测试邮件','测试内容','HTML','注册会员邮件提醒','2');
INSERT INTO ourphp_mail VALUES('2','smtp.qq.com','25','993141000@qq.com','993141000','123456','这是一封测试邮件','测试内容','HTML','提交订单邮件提醒','2');
INSERT INTO ourphp_mail VALUES('3','smtp.qq.com','25','993141000@qq.com','993141000','123456','这是一封测试邮件','测试内容','HTML','后台发货邮件提醒','2');

DROP TABLE IF EXISTS ourphp_column;
CREATE TABLE `ourphp_column` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Uid` int(11) NOT NULL default '0',
`OP_Lang` varchar(255) NOT NULL default '',  /*语言类别*/
`OP_Columntitle` varchar(255) NOT NULL default '',  /*主标题*/
`OP_Columntitleto` varchar(255) NOT NULL default '', /*副标题*/
`OP_Model` varchar(255) NOT NULL default '', /*模型*/
`OP_Templist` varchar(255) NOT NULL default '', /*列表页模板*/
`OP_Tempview` varchar(255) NOT NULL default '', /*内容页模板*/
`OP_Url` varchar(255) NOT NULL default '', /*外部链接地址*/
`OP_About` text NOT NULL, /*单页面*/
`OP_Hide` int(11) NOT NULL default '0', /*栏目隐藏与显示，0为显示 1为隐藏*/
`OP_Sorting` int(11) NOT NULL default '0', /*栏目排序*/
`OP_Briefing` text NOT NULL, /*栏目介绍*/
`OP_Img` varchar(255) NOT NULL default '', /*栏目图片*/
`OP_Userright` varchar(255) NOT NULL default '', /*栏目权限*/
`OP_Weight` int(11) NOT NULL default '0', /*栏目权重*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_column VALUES('1','0','cn','网站首页','','weburl','','','/','','0','0','','','0','0');

DROP TABLE IF EXISTS ourphp_product;
CREATE TABLE `ourphp_product` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Class` int(11) NOT NULL default '0',
`OP_Lang` varchar(255) NOT NULL default '',  /*语言类别*/
`OP_Title` varchar(255) NOT NULL default '',  /*标题*/
`OP_Number` varchar(255) NOT NULL default '',  /*编号*/
`OP_Goodsno` varchar(255) NOT NULL default '',  /*货号*/
`OP_Brand` varchar(255) NOT NULL default '',  /*品牌*/
`OP_Market` decimal(10,2) NOT NULL default '0',  /*市场价*/
`OP_Webmarket` decimal(10,2) NOT NULL default '0',  /*本站价*/
`OP_Stock` int(11) NOT NULL default '0',  /*库存*/
`OP_Usermoney` text NOT NULL,  /*会员价格*/
`OP_Specificationsid` varchar(255) NOT NULL default '',  /*规格ID*/
`OP_Specificationstitle` text NOT NULL,  /*规格标题*/
`OP_Specifications` text NOT NULL,  /*产品规格*/
`OP_Pattribute` text NOT NULL,  /*产品属性*/
`OP_Minimg` varchar(255) NOT NULL default '',  /*缩略图*/
`OP_Maximg` varchar(255) NOT NULL default '',  /*大图*/
`OP_Img` text NOT NULL,  /*组图*/
`OP_Content` text NOT NULL,  /*内容*/
`OP_Down` int(11) NOT NULL default '0', /*下架 1下架 2不下架*/
`OP_Weight` int(11) NOT NULL default '1', /*重量*/
`OP_Freight` int(11) NOT NULL default '1', /*运费模板*/
`OP_Tag` varchar(255) NOT NULL default '', /*标签*/
`OP_Sorting` int(11) NOT NULL default '0', /*排序*/
`OP_Attribute` varchar(255) NOT NULL default '', /*属性*/
`OP_Url` varchar(255) NOT NULL default '',
`OP_Description` text NOT NULL, /*描述*/
`OP_Click` int(11) NOT NULL default '0', /*点击量*/
`time` datetime,
`OP_Integral` decimal(10,2) NOT NULL default '0', /*商品赠送积分 v1.2.2*/
`OP_Integralok` int(11) NOT NULL default '0', /*是否允许用积分对换 0=否 1=是*/
`OP_Integralexchange` decimal(10,2) NOT NULL default '0', /*兑换积分*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_productcp;
CREATE TABLE `ourphp_productcp` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Vender` varchar(255) NOT NULL default '', 
`OP_Brand` varchar(255) NOT NULL default '', 
`OP_Class` int(11) NOT NULL default '0', /*1厂商 2品牌*/
`OP_Img` varchar(255) NOT NULL default '',  /*品牌图片*/
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_productattribute;
CREATE TABLE `ourphp_productattribute` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Title` varchar(255) NOT NULL default '', 
`OP_Class` varchar(255) NOT NULL default '', 
`OP_Text` text NOT NULL,
`OP_Sorting` int(11) NOT NULL default '0', /*排序*/
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_productattribute VALUES('1','电脑系列','0','','99','2015-1-1 12:00:00');
INSERT INTO ourphp_productattribute VALUES('2','硬盘容量','1','500G|800G|1T','99','2015-1-1 12:00:00');
INSERT INTO ourphp_productattribute VALUES('3','内存容量','1','1G|2G|3G','99','2015-1-1 12:00:00');


DROP TABLE IF EXISTS ourphp_productspecifications;
CREATE TABLE `ourphp_productspecifications` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Title` varchar(255) NOT NULL default '', 
`OP_Titleto` varchar(255) NOT NULL default '',
`OP_Value` text NOT NULL, /*值*/
`OP_Class` int(11) NOT NULL default '0', /*1文字 2图片*/
`OP_Img` varchar(255) NOT NULL default '', 
`OP_Sorting` int(11) NOT NULL default '0', /*排序*/
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_productspecifications VALUES('1','尺码','女鞋','36|37|38|39','1','','99','2015-1-1 12:00:00');
INSERT INTO ourphp_productspecifications VALUES('2','颜色','女鞋','红色|白色|黑色','1','','99','2015-1-1 12:00:00');


DROP TABLE IF EXISTS ourphp_productset;
CREATE TABLE `ourphp_productset` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Pattern` int(11) NOT NULL default '0', /*1产品展示模式 2商城模式*/
`OP_Scheme` int(11) NOT NULL default '0', /*1统一价格 2详细价格*/
`OP_Stock` int(11) NOT NULL default '0', /*库存数量报警*/
`OP_buy` int(11) NOT NULL default '0', /*游客是否可以提交订单 1可以 2不可以*/
`OP_Sendout` text NOT NULL, /*发货方式*/
`time` datetime,
`OP_Delivery` int(11) NOT NULL default '0', /*货到付款 0=NO 1=YES*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_productset VALUES('1','2','1','100','2','','2015-1-1 12:00:00','0');


DROP TABLE IF EXISTS ourphp_webdeploy;
CREATE TABLE `ourphp_webdeploy` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Weboff` int(11) NOT NULL default '0', /*开站开关 1等于开 2关*/
`OP_Webofftext` text NOT NULL,
`OP_Webrewrite` int(11) NOT NULL default '0', /*伪静态开关 1等于开 2关*/
`OP_Webpage` text NOT NULL, /*翻页*/
`OP_Webkeywords` int(11) NOT NULL default '0', /*关键词优化*/
`OP_Webkeywordsto` text NOT NULL,
`OP_Webdescriptions` text NOT NULL,
`OP_Webfenci` int(11) NOT NULL default '0', /*分词开关 1等于开 2关*/
`OP_Webservice` varchar(255) NOT NULL default '',
`OP_Webocomment` int(11) NOT NULL default '2', /*其它评论开关 1等于开 2关 3登录可以评论*/
`OP_Webpcomment` int(11) NOT NULL default '2', /*商品评论开关 1等于开 2关  3登录可以评论 4只有购买者可以评论*/
`OP_Webweight` int(11) NOT NULL default '1', /*权限方式 1权限 2权重*/
`time` datetime,
`OP_Webfile` int(11) NOT NULL default '1', /*删除附件 1不删 2删*/
`OP_Ucenter` int(11) NOT NULL default '0', 
`OP_Searchtime` int(11) NOT NULL default '10',
`OP_Home` varchar(255) NOT NULL default 'cn|cn|cn', /*网站默认语言*/
`OP_Sensitive` text NOT NULL, /*网站过滤敏感词*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO ourphp_webdeploy VALUES('1','1','','2','20,20,20,20,20,20,20','1','OURPHP','OURPHP','2','default','2','4','1','2015-1-1 12:00:00','1','0','10','cn|cn|cn','傻逼|二货|狗屎|去死');


DROP TABLE IF EXISTS ourphp_orders;
CREATE TABLE `ourphp_orders` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Ordersname` text NOT NULL, 
`OP_Ordersid` int(11) NOT NULL default '0', 
`OP_Ordersnum` int(11) NOT NULL default '0', 
`OP_Ordersemail` varchar(255) NOT NULL default '', 
`OP_Ordersusername` varchar(255) NOT NULL default '', 
`OP_Ordersusertel` varchar(255) NOT NULL default '', 
`OP_Ordersuseradd` text NOT NULL, 
`OP_Ordersusetext` text NOT NULL, 
`OP_Ordersproductatt` text NOT NULL, 
`OP_Orderswebmarket` decimal(10,2) NOT NULL default '0',
`OP_Ordersusermarket` decimal(10,2) NOT NULL default '0',
`OP_Ordersweight` int(11) NOT NULL default '1', /*重量*/
`OP_Ordersfreight` int(11) NOT NULL default '1', /*运费价格*/
`OP_Ordersexpress` varchar(255) NOT NULL default '', 
`OP_Ordersexpressnum` varchar(255) NOT NULL default '', 
`time` datetime,
`OP_Ordersnumber` varchar(255) NOT NULL default '', 
`OP_Orderspay` int(11) NOT NULL default '1',  /*1 未付款 2已付款*/
`OP_Orderssend` int(11) NOT NULL default '1',  /*1 未发货 2已发货*/
`OP_Ordersgotime` datetime,
`OP_Integralok` int(11) NOT NULL default '0', /*是否允许用积分对换 0=普通商品 1=积分兑换*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_shoppingcart;
CREATE TABLE `ourphp_shoppingcart` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Shopproductid` int(11) NOT NULL default '0', 
`OP_Shopnum` int(11) NOT NULL default '0', 
`OP_Shopusername` varchar(255) NOT NULL default '', 
`OP_Shopatt` text NOT NULL, 
`OP_Shopkc` varchar(255) NOT NULL default '', 
`OP_Shophh` varchar(255) NOT NULL default '', 
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ourphp_api;
CREATE TABLE `ourphp_api` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Key` text NOT NULL,  
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ourphp_freight;
CREATE TABLE `ourphp_freight` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Freightname` varchar(255) NOT NULL default '', 
`OP_Freighttext` text NOT NULL,  
`OP_Freightdefault` int(11) NOT NULL default '0', 
`OP_Freightweight` int(11) NOT NULL default '0', 
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ourphp_search;
CREATE TABLE `ourphp_search` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Searchtext` text NOT NULL,  
`OP_Searchclick` int(11) NOT NULL default '0', 
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ourphp_comment;
CREATE TABLE `ourphp_comment` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Content` text NOT NULL,  /*内容*/
`OP_Class` int(11) NOT NULL default '0', /*分类*/
`OP_Type` varchar(255) NOT NULL default '', /*类别*/
`OP_Name` varchar(255) NOT NULL default '', /*姓名*/
`OP_Ip` varchar(255) NOT NULL default '', /*IP*/
`OP_Vote` int(11) NOT NULL default '0', /*好评*/
`OP_Scoring` varchar(255) NOT NULL default '', /*打分*/
`OP_Gocontent` text NOT NULL,  /*回复*/
`OP_Gotime` varchar(255) NOT NULL default '', /*回复时间*/
`time` datetime,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ourphp_plus;
CREATE TABLE `ourphp_plus` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Name` varchar(255) NOT NULL default '', /*插件名称*/
`OP_Version` varchar(255) NOT NULL default '', /*插件版本*/
`OP_Versiondate` varchar(255) NOT NULL default '', /*更新日期*/
`OP_Author` varchar(255) NOT NULL default '', /*插件作者*/
`OP_Fraction` varchar(255) NOT NULL default '', /*分数*/
`OP_About` text NOT NULL, /*插件介绍*/
`OP_Pluspath` text NOT NULL, /*管理路径*/
`OP_Time` date, /*安装日期*/
`OP_Off` int(11) NOT NULL default '1', /* 1关闭 2开启*/
`OP_Plugid` varchar(255) NOT NULL default '', /* 插件ID*/
`OP_Plugclass` varchar(255) NOT NULL default '', /* 插件类型*/
`OP_Plugmysql` varchar(255) NOT NULL default '', /* 插件数据表*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ourphp_integral;
CREATE TABLE `ourphp_integral` (
`id` int(10) unsigned NOT NULL auto_increment,
`OP_Iid` int(11) NOT NULL default '0', /* 产品ID*/
`OP_Iname` varchar(255) NOT NULL default '', /*产品名称*/
`OP_Imarket` decimal(10,2) NOT NULL default '0',/*产品价格*/
`OP_Iwebmarket` decimal(10,2) NOT NULL default '0',/*本站价格*/
`OP_Iintegral` decimal(10,2) NOT NULL default '0', /*积分*/
`OP_Ivirtual` int(11) NOT NULL default '0', /*虚拟实物 0=实物 1=虚拟*/
`OP_Iconfirm` int(11) NOT NULL default '0', /*确认领取 0=未领 1=领取*/
`OP_Iuseremail` varchar(255) NOT NULL default '', /*会员账号*/
`OP_Iadmin` int(11) NOT NULL default '0', /*管理权限 0=会员 1=管理*/
`OP_ITime` varchar(255) NOT NULL default '', /*领取时间*/
`time` datetime, /*产生时间*/
PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;