<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {



    public function index(){
        $this->display();
    }

    /**
     * 报名
     */
    public function signUp()
    {
        if(IS_POST){
            $saveData=array();
            $saveData['n_name']=I('post.name');
            $saveData['n_tel']=I('post.tel');
            $saveData['n_grade']=I('post.grade');
            $saveData['n_subject']=I('post.subject');
            $saveData['n_level']=I('post.level');
            $saveData['n_time']=time();

            $mSignUp=D('signup');
            if($mSignUp->add($saveData)){
                $this->success("报名成功", U('index'), 3);
            }else{
                dump($mSignUp->getError());
                exit;
                $this->error("报名失败,请从新报名", U('signUp'), 3);
            }

        }else{

            $this->display();
        }
    }

    public function getSignUpList()
    {
        $mSignUp=D('signup');
        $signUpInfo=$mSignUp->order('n_time desc')->select();
        $this->assign("signInfo",$signUpInfo);
        $this->display('list');
    }
}