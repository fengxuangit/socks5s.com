<?php
return array(
	//'配置项'=>'配置值'

    //standard configuration
    'DEFAULT_TIMEZONE'=>'Asia/ShangHai',//time setting
    'SESSION_AUTO_START' => true, //是否开启session
    'DEFAULT_AJAX_RETURN' => 'JSON', //默认ajax返回格式 JSON
    'SHOW_PAGE_TRACE'  => false, // 显示页面Trace信息
    'AUTHCODE'         =>   '1e38de0a85d4178ac353e165aabba0ab', //
    'URL_MODEL'        => 2,
    'URL_CASE_INSENSITIVE' =>true,

    //Tempate setting
    'TMPL_PARSE_STRING' => array(
            '__PUBLIC__' => __ROOT__.'/Public/',
    ),
    'TMPL_FILE_DEPR' => '_',

    //db settings
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_NAME' => 'shadow',
    'DB_USER' => 'root',
    'DB_PWD'  => 'fuckqq',
    'DB_CHARSET' => 'utf8',
    'DB_PREFIX' => 's_',
    'DB_DEBUG' => TRUE,

    //input filter
    'DEFAULT_FILTER' => 'trim,strip_tags,stripslashes',

    'ONE_DAY_UNIX'  => 86400,   //一天的unix时间戳

    //EMAIL SETTINGS 
    'MAIL_ADDRESS'=>'qqq@163.com', // 邮箱地址
    'MAIL_SMTP'=>'smtp.163.com', // 邮箱SMTP服务器
    'MAIL_LOGINNAME'=>'qqq@163.com', // 邮箱登录帐号
    'MAIL_PASSWORD'=>'111111', // 邮箱密码

);
