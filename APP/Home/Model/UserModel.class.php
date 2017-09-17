<?php
/**
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/8/17
 * Time: 9:38
 */

namespace Home\Model;

class UserModel extends \Think\Model{

    /*自动完成*/
    protected $_auto            =   array(
        array('user_add_date','time',3,'function'),
        array('user_check_code','getCheckCode',1,'callback')
    );

    /*字段映射*/
    protected $_map             =   array(
        'register_email'=>'user_email',
        'register_stu_no'=>'user_stu_num',
        'register_name'=>'user_name',
        'register_pwd1'=>'user_pwd'
    );


    public function resetUserPwd($email,$stu_num,$pwd)
    {
        if($this->where(array('user_email' => $email,'user_stu_num'=>$stu_num))->find()){
            $sql="update blog_user set user_pwd = '$pwd' WHERE user_stu_num='$stu_num'";
            if($this->execute($sql)){
                return true;
            }
            return false;
        }
        return false;
    }


    public function modifyUserInfo($newName,$stuNum)
    {
        $sql="update blog_user set user_name = '$newName' WHERE user_stu_num='$stuNum'";
        if($this->execute($sql)){
            session("user_name",$newName);
            return true;
        }
        return false;

    }

    public function getCheckCode()
    {
        return md5(uniqid());
    }

    protected function _after_insert($data, $options)
    {
        $webUrl=C('WEB_URL');
        $stuNum=$data['user_stu_num'];
        $checkCode=$data['user_check_code'];


        $userEmail=$data['user_email'];
        $emailInfo=$webUrl.U('Home/User/activeUser', array('user_stu_num' => $stuNum,'check_code'=>$checkCode));
        sentMail($userEmail, "账号激活邮件", "欢迎使用作业提交系统,你的账号已经注册.为了方便你的使用及账号安全,请尽快激活!!!<a href='$emailInfo'>点击激活</a>");
    }


    public function activeUser($stuNum,$checkCode)
    {
        $sql="update blog_user set user_check_code='',user_is_active='1' WHERE user_stu_num='$stuNum'";
        if ($this->execute($sql)) {
            return true;
        }
        return false;
    }

    public function updateLoginTimes($stuNum)
    {
        $sql="update blog_user set user_login_times =user_login_times+1 WHERE user_stu_num=$stuNum";
        $this->execute($sql);
    }
}