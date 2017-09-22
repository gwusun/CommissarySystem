<?php
/**
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/9/22
 * Time: 14:27
 */
header('content-type:text/html;charset=utf-8');
$res=file_get_contents("../../VERSION.md");
echo "<pre>";
echo $res;