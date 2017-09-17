<?php
/**
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/8/17
 * Time: 8:37
 */

namespace Admin\Model;
class UpWorkConsoleModel extends \Think\Model{
    /*自动完成*/
    protected $_auto = array(
        array("con_date","time","3","function"),
    );

    /*字段映射*/
    protected $_map             =   array(
        'save_path_root'=>'con_save_root',
        'grade'=>'con_grade',
        "major"=>"con_major",
        "course"=>"con_course",
        "course_type"=>"con_course_type",
        "request"=>"con_request",
        "save_path"=>"con_save_path",
        "switch"=>"con_switch",
    );

    protected function _before_update(&$data,$options) {
//        $rootPath=$data['con_save_root'];
//        /*创建文件保存目录*/
//        getDir($rootPath);
    }

}