<?php
/**
 * Created by PhpStorm.
 * User: 孙武
 * Date: 2017/8/28
 * Time: 9:29
 */

class BrowserVersion{
    /**
     * 获取浏览器的名称
     * @return bool|string 成功返回浏览器的名称,失败返回false
     */
    public function getBrowserName(){
        $agent=$_SERVER["HTTP_USER_AGENT"];
        if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
            return "ie";
        else if(strpos($agent,'Firefox')!==false)
            return "firefox";
        else if(strpos($agent,'Chrome')!==false)
            return "chrome";
        else if(strpos($agent,'Opera')!==false)
            return 'opera';
        else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
            return 'safari';
        else
            return false;
    }

    /**
     * 获取浏览器版本
     * bool|string 成功返回浏览器的版本,失败返回false
     */
    public function getBrowserVer(){
        if (empty($_SERVER['HTTP_USER_AGENT'])){    //当浏览器没有发送访问者的信息的时候
            return false;
        }
        $agent= $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs))
            return $regs[1];
        elseif (preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs))
            return $regs[1];
        elseif (preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs))
            return $regs[1];
        elseif (preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs))
            return $regs[1];
        elseif ((strpos($agent,'Chrome')==false)&&preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs))
            return $regs[1];
        else
            return false;
    }

    /**
     * 获取浏览器代理信息
     * @return string  浏览器代理信息
     */
    public function getAgent(){
        return $_SERVER["HTTP_USER_AGENT"];
    }


    /**
     * 检查浏览器版本
     */
    public function check(){
        $browser = $this->getBrowserName();
        $version = $this->getBrowserVer();
        if ($browser == 'ie' && $version < 11) {
            echo "<h3 style='text-align: center;color: red'>系统不支持IE11以下的浏览器,请更换浏览器!!!<br>推荐 [ 谷歌浏览器 ] 或 [ 火狐浏览器 ] !</h3>";
            echo "<h5 style='text-align: center;color: blue'>PS:如果你使用的是360浏览器,请将浏览器更换为极速模式!<br>
      <img src='./APP/Help/img/browser.png' alt='' style='
                                                                border: 1px solid #c1c1c1;
                                                                padding: 4px;
                                                                background-color: #d8d8d8;
                                                                position: relative;'>
    </h5>";
            exit;
        }
    }
}