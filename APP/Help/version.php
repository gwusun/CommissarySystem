<?php
/**
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/9/22
 * Time: 14:27
 */

$res=file_get_contents("../../VERSION.md");
echo "<pre>";
echo $res;