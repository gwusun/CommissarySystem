<?php
/**
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/8/16
 * Time: 21:59
 */

/**
 * 获取文件存储名称
 */
function getFileNamebak()
{
    $m = D('upwork_console');
    $info = $m->find();

    $str = $info['con_grade'];
    $str .= $info['con_major'];
    $str .= session('user_name');
    $str .= session('user_stu_num');
    $str .= $info['con_course'];
    $str .= $info['con_course_type'];
    $day = getdate($info['con_date']);
    $str .= $day['year'];
    $mon = $day['mon'];

    /*单位日期自动填充*/
    if ($mon < 10) {
        $str .= '0' . $mon;
    } else {
        $str .= $day['mon'];
    }
    $str .= $day['mday'];
    return $str;
}

/**
 * 获取文件存储名称
 */
function getFileName()
{
//    软件工程20150107030131孙武的实验开发报告2017.9
    $m = D('upwork_console');
    $info = $m->find();

    $str='';
    $str .= $info['con_major'];
//    $str .= $info['con_grade'];
    $str .= session('user_stu_num');
    $str .= session('user_name');
    $str .= $info['con_course'];
    $str .= $info['con_course_type'];
    $day = getdate($info['con_date']);
    $str .= $day['year'].'.';
    $mon = $day['mon'];
    $str .=$mon;

//    /*单位日期自动填充*/
//    if ($mon < 10) {
//        $str .= '0' . $mon;
//    } else {
//        $str .= $day['mon'];
//    }
//    $str .= $day['mday'];
    return $str;
}

/**
 * 获取数据库存储的文件存储路径
 */
function getFileSavePath()
{
    $m = D('upwork_console');
    $info = $m->find();
    $str = $info['con_save_path'];
    return $str;
}


/**
 * 创建目录
 */

function getDir($path)
{
    if (!mkdir($path, 0, true)) {
        die("创建目录" . $path . "失败");
    }
}

/**
 * 获取文件保存跟路径
 * @return mixed
 */
function getFileSaveRoot()
{
    $m = D('upwork_console');
    $info = $m->find();
    $str = $info['con_save_root'];
    return $str;
}

/**
 * 获取文件压缩路径
 * @return string
 */
function getCompressPath()
{
    $mCom = D('upwork_console');
    $conInfo = $mCom->field('con_save_path')->find();
    $conSavePath = $conInfo['con_save_path'];
    $pos = strrpos($conSavePath, '/');
    $conSavePath = substr($conSavePath, 2, $pos - 2);
    return $compressPath = getFileSaveRoot() . $conSavePath . "/";//压缩文件夹
}

/**
 * 通过文件全路径获得文件名
 * @param $pathName 文件名
 */
function getFIleNameFromPath($pathName)
{
    $pos = strrpos($pathName, DIRECTORY_SEPARATOR);
    return substr($pathName, $pos + 1);
}

function checkIsOn()
{
    $m = D('work_console');
    $info = $m->find();
    if (!$info['con_switch']) {
        die('现在不可以提交');
    }
}


function sentMail($to, $title, $body)
{
    require_once "./APP/Plugins/PHPMailer/" . 'PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.qq.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = '1228746736@qq.com';                 // SMTP username
    $mail->Password = 'gxulvdvgiipxjhic';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('1228746736@qq.com', '孙武');
    $mail->addAddress($to);               // Name is optional
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $title;
    $mail->Body = $body;

    if (!$mail->send()) {
        die('Message could not be sent.错误信息:'.$mail->ErrorInfo);
    } else {
        //成功
    }
}

/**
 * 检查是否登陆
 */
function checkIsLogin()
{
    $stuNum=session('user_stu_num');
    if(!$stuNum){
        die("尚未登陆!请登录是重试！！！");
    }
}
