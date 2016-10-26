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

    //alipay config
    'alipay_config'=>array(
        'partner' =>'2088312545109961',   //这里是你在成功申请支付宝接口后获取到的PID；
        'key'=>'v19jcnd1183iyspqelzd6tmdzr9u47at',//这里是你在成功申请支付宝接口后获取到的Key
        'sign_type'=>strtoupper('MD5'),
        'input_charset'=> strtolower('utf-8'),
        'cacert'=> getcwd().'\\cacert.pem',
        'transport'=> 'http',
    ),

    'alipay'   =>array(
         //这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
        'seller_email'=>'18110801781',
        //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
        'notify_url'=>'http://www.xxx.com/Pay/notifyurl', 
        //这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
        'return_url'=>'http://www.xxx.com/Pay/returnurl',
        //支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
        'successpage'=>'User/myorder?ordtype=payed',
        //支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
        'errorpage'=>'User/myorder?ordtype=unpay',
    ),
);