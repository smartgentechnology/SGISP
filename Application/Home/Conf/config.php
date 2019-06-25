<?php
return array(
	//'配置项'=>'配置值'
	//网站
	'ZW' => array(
        'DB_TYPE' => 'mysql',
		'DB_HOST' => 'hdm1868641.my3w.com',
        'DB_USER' => 'hdm1868641',
        'DB_PWD' => 'smartgen980318',
        'DB_NAME' => 'hdm1868641_db',
        'DB_PORT' => '3306',
		'DB_PREFIX'=>'',// 数据库表前缀
		'DB_CHARSET'=>'utf8',
    ),
	'YW' => array(
        'DB_TYPE' => 'mysql',
		'DB_HOST' => '160.153.153.158',
        'DB_USER' => 'hdm1868641',
        'DB_PWD' => 'smartgen980318',
        'DB_NAME' => 'hdm1868641_db',
        'DB_PORT' => '3306',
		'DB_PREFIX'=>'',// 数据库表前缀
		'DB_CHARSET'=>'utf8',
    ),
	//OA数据库
	'DB_TYPE'=>'mysql',
	'DB_HOST'=>'127.0.0.1',
	'DB_USER'=>'smartgen',
	'DB_PWD'=>'smartgen',
	'DB_NAME'=>'sbangong',
	'DB_PORT'=>'3306',
	'DB_PREFIX'=>'lc_',// 数据库表前缀
	'DB_CHARSET'=>'utf8',
	
	
	//OA数据库
	'OA' => array(
        'DB_TYPE' => 'mysql',
		'DB_HOST' => '192.168.0.1',
        'DB_USER' => 'root',
        'DB_PWD' => 'oa123456',
        'DB_NAME' => 'v56',
        'DB_PORT' => '3306',
		'DB_CHARSET'=>'utf8',
    ),
	//U8数据库
	'U8' => array(
        'DB_TYPE' => 'Sqlsrv',
		'DB_HOST' => '192.168.0.13',
        'DB_USER' => 'smartgen',
        'DB_PWD' => 'smartgen',
        'DB_NAME' => 'UFDATA_001_2017',
        'DB_PORT' => '1433',
		'DB_CHARSET'=>'utf8',
    ),
	
	//页面调试
	'SHOW_PAGE_TRACE'=>true,
	//开启布局文件
	//'LAYOUT_ON'=>true,
	//'LAYOUT_NAME'=>'layout',
	//开启语言包
	'LANG_SWITCH_ON'=>true,
	//自动侦测语言
	//'LANG_AUTO_DETECT'=>true,
	//允许切换到的语言列表
	//'LANG_LIST'=>'zh-cn',
	//默认语言切换变量
	//'VAR_LANGUAGE'=>'1'

	
);