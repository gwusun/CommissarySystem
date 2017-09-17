<?php
return array(
    //'配置项'=>'配置值'
    "SHOW_PAGE_TRACE" =>true,

    //配置路径常量
    "BOOTSTRAP_CSS_URL"=>'/APP/Plugins/bootstrap/css/',
    "BOOTSTRAP_JS_URL"=>'/APP/Plugins/bootstrap/js/',
    "HOME_CSS_URL"=>'/APP/Home/Public/css/',
    "HOME_JS_URL"=>'/APP/Home/Public/js/',
    "HOME_IMG_URL"=>'/APP/Home/Public/img/',


    //邮箱插件路径
    "PLUGIN_EMAIL"=>'/APP/Plugins/PHPMailer/',

    //web网址
    "WEB_URL"=>'http://192.168.56.156',


    //数据库配置
    'DB_TYPE' => 'mysql',     // 数据库类型
    'DB_HOST' => 'localhost', // 服务器地址
    'DB_NAME' => 'blog',          // 数据库名
    'DB_USER' => 'root',      // 用户名
    'DB_PWD' => '',          // 密码
    'DB_PREFIX' => 'blog_',    // 数据库表前缀


    //默认path
    'DEFAULT_MODULE'        =>  'Home',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'UpWork', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称
);