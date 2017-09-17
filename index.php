<?php


header("Content-type: text/html; charset=utf-8");

//检查浏览器版本
require_once './APP/Plugins/BrowserVersion.class.php';
$bv=new BrowserVersion();
$bv->check();


// 关闭调试模式
define("APP_DEBUG", true);
//define("APP_DEBUG", false);

define('APP_PATH', './APP/');
define("DS", DIRECTORY_SEPARATOR);

require_once './ThinkPHP/ThinkPHP.php';