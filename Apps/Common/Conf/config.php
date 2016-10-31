<?php
return array(
	//'配置项'=>'配置值'

    //standard configuration
    'DEFAULT_TIMEZONE'=>'Asia/ShangHai',//time setting
    'SESSION_AUTO_START' => true, //是否开启session
    'DEFAULT_AJAX_RETURN' => 'JSON', //默认ajax返回格式 JSON
    'SHOW_PAGE_TRACE'  => True, // 显示页面Trace信息

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
    'DB_PWD'  => '123480',
    'DB_CHARSET' => 'utf8',
    'DB_PREFIX' => 's_',
    'DB_DEBUG' => TRUE,

    //input filter
    'DEFAULT_FILTER' => 'strip_tags,stripslashes',

    'ONE_DAY_UNIX'  => 86400,   //一天的unix时间戳

);