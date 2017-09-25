<?php
/**
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/8/17
 * Time: 9:38
 */

namespace Home\Model;

class TeamModel extends \Think\Model
{
    protected function _after_insert($data, $options)
    {
        $tId = $data['t_id'];
        $sql = "update blog_team set t_user_id=$tId where t_id=$tId";
        $this->execute($sql);
        $userNames = $_POST['userName'];
        $userNums = $_POST['userNum'];
        $saveData = array();

        $mTeamUser = D('team_user');
        for ($i = 0; $i < count($userNums); $i++) {
            $saveData['t_id'] = $tId;
            $saveData['tu_user_name'] = $userNames[$i];
            $saveData['tu_user_num'] = $userNums[$i];
            $mTeamUser->add($saveData);
        }
    }


    /**
     * 根据id获取team信息
     * @param $tId
     * @return array
     */
    public function getTeamInfo($tId)
    {
//        echo $tId;exit;
        //查询数据库信息
        $sql = "select t.t_project_name,t.cat_id,t.t_leader_name,t.t_leader_num,tu.t_id,tu.tu_user_name,tu.tu_user_num from blog_team as t INNER JOIN blog_team_user as tu where t.t_id = tu.t_id and t.t_id=$tId";
        $res = $this->query($sql);
        $teamInfo = $this->dealTeamInfo($res);
        $teamInfo = $this->dealTeamInfo2($teamInfo);
        return $teamInfo;
    }

    /**
     * 将连表查询出来的数据进行整理合并（名字学号）
     * @return array
     */
    public function dealTeamInfo($res)
    {
        //处理的数据
        /*
         * array(3) {
  [0] => array(6) {
    ["t_project_name"] => string(9) "第一组"
    ["t_leader_name"] => string(6) "孙武"
    ["t_leader_num"] => string(2) "31"
    ["t_id"] => string(1) "6"
    ["tu_user_name"] => string(6) "宝宝"
    ["tu_user_num"] => string(2) "32"
  }
  [1] => array(6) {
    ["t_project_name"] => string(9) "第一组"
    ["t_leader_name"] => string(6) "孙武"
    ["t_leader_num"] => string(2) "31"
    ["t_id"] => string(1) "6"
    ["tu_user_name"] => string(9) "大宝宝"
    ["tu_user_num"] => string(2) "33"
  }
  [2] => array(6) {
    ["t_project_name"] => string(9) "第一组"
    ["t_leader_name"] => string(6) "孙武"
    ["t_leader_num"] => string(2) "31"
    ["t_id"] => string(1) "6"
    ["tu_user_name"] => string(9) "中宝宝"
    ["tu_user_num"] => string(2) "43"
  }
}
         */

        //处理的结果
        /*
         * array(1) {
  [1] => array(6) {
    ["t_id"] => string(1) "6"
    ["t_project_name"] => string(9) "第一组"
    ["t_leader_name"] => string(6) "孙武"
    ["t_leader_num"] => string(2) "31"
    ["tu_user_name"] => array(3) {
      [0] => string(6) "宝宝"
      [1] => string(9) "大宝宝"
      [2] => string(9) "中宝宝"
    }
    ["tu_user_num"] => array(3) {
      [0] => string(2) "32"
      [1] => string(2) "33"
      [2] => string(2) "43"
    }
  }
}
         */

        $returnDate = array();
        $j = 0;
        $flag = 0;
        //两个数组拼装数据信息
        foreach ($res as $k => $v) {
            if ($flag == $v['t_id']) {
                /*当前的t_id在returnDate中*/
//                $returnDate[$j]['tu_user_name']=$returnDate[$j]['tu_user_name'].",".$v['tu_user_name'];
//                $returnDate[$j]['tu_user_num']=$returnDate[$j]['tu_user_num'].",".$v['tu_user_num'];
//                $returnDate[$j]['user_info']=$returnDate[$j]['user_info']."<br>".$v['tu_user_name'].$v['tu_user_num'];;
//                $returnDate[$j]['user_info_1'][]=$v['tu_user_name'].$v['tu_user_num'];
                $returnDate[$j]['tu_user_name'][] = $v['tu_user_name'];
                $returnDate[$j]['tu_user_num'][] = $v['tu_user_num'];

            } else {
                /*不在returnData中*/
                $flag = $v['t_id'];
                $j++;


                $returnDate[$j]['t_id'] = $v['t_id'];
                $returnDate[$j]['cat_id'] = $v['cat_id'];
                $returnDate[$j]['cat_name'] = $this->getCatNameByCatId($v['cat_id']);
                $returnDate[$j]['t_project_name'] = $v['t_project_name'];
                $returnDate[$j]['t_leader_name'] = $v['t_leader_name'];
                $returnDate[$j]['t_leader_num'] = $v['t_leader_num'];
//                $returnDate[$j]['tu_user_name']=$v['tu_user_name'];
//                $returnDate[$j]['tu_user_num']=$v['tu_user_num'];
//                $returnDate[$j]['user_info']=$v['tu_user_name'].$v['tu_user_num'];
//                $returnDate[$j]['user_info_1'][]=$v['tu_user_name'].$v['tu_user_num'];
                $returnDate[$j]['tu_user_name'][] = $v['tu_user_name'];
                $returnDate[$j]['tu_user_num'][] = $v['tu_user_num'];

            }
//            if($flag!=$v['t_id']) $j++;

        }
//        dump($returnDate);
//        exit;
        return $returnDate;
    }


    /**
     * 二次处理将单个数组融合
     */
    public function dealTeamInfo2($arr)
    {
        //处理的数据
        /*处理的数据
         * array(1) {
              [1] => array(6) {
                ["t_id"] => string(1) "6"
                ["t_project_name"] => string(9) "第一组"
                ["t_leader_name"] => string(6) "孙武"
                ["t_leader_num"] => string(2) "31"
                ["tu_user_name"] => array(3) {
                  [0] => string(6) "宝宝"
                  [1] => string(9) "大宝宝"
                  [2] => string(9) "中宝宝"
                }
                ["tu_user_num"] => array(3) {
                  [0] => string(2) "32"
                  [1] => string(2) "33"
                  [2] => string(2) "43"
                }
              }
            }
         */

        //处理的结果
        /*处理结果
                 * array(1) {
          [1] => array(6) {
            ["t_id"] => string(1) "6"
            ["t_project_name"] => string(9) "第一组"
            ["t_leader_name"] => string(6) "孙武"
            ["t_leader_num"] => string(2) "31"
            ["tu_user_name"] => array(3) {
              [0] => string(6) "宝宝"
              [1] => string(9) "大宝宝"
              [2] => string(9) "中宝宝"
            }
            ["tu_user_num"] => array(3) {
              [0] => string(2) "32"
              [1] => string(2) "33"
              [2] => string(2) "43"
            }
          }
        }
         */
        $arr = $arr[1];
        $returnData = array();
        $returnData['t_id'] = $arr['t_id'];
        $returnData['cat_id'] = $arr['cat_id'];
        $returnData['cat_name'] = $arr['cat_name'];
        $returnData['t_project_name'] = $arr['t_project_name'];
        $returnData['t_leader_name'] = $arr['t_leader_name'];
        $returnData['t_leader_num'] = $arr['t_leader_num'];
        //解决数组里面的二维数组
        for ($i = 0; $i < count($arr['tu_user_name']); $i++) {
            $returnData['t_user_info'][$i]['name'] = $arr['tu_user_name'][$i];
            $returnData['t_user_info'][$i]['num'] = $arr['tu_user_num'][$i];
        }

        return $returnData;

    }

    /**
     * 根据id删除旧的数据
     * @param $id
     * @return bool
     */
    public function clearOldDate($id)
    {
        $sql1 = "delete from blog_team WHERE t_id=$id";
        $sql2 = "delete from blog_team_user WHERE t_id=$id";
        if ($this->execute($sql1) && $this->execute($sql2)) return true;
        return false;
    }

    public function checkIsAccess($id)
    {
        $info = $this->find($id);
        $stu_num = $info['user_stu_num'];
        $s_stu_num = session('user_stu_num');
        $team_leader=$info['t_leader_num'];
        //允许组长和团队创建者修改
        if ($stu_num !== $s_stu_num && $stu_num !==$team_leader) {
            return false;
        }
        return true;
    }

    public function getCategoryInfoByCatId($catId)
    {
//        $sql="select * from blog_team WHERE cat_id =$catId";
//        $sql = "select t.*,tu.* from blog_team as t INNER JOIN blog_team_user as tu  WHERE cat_id =$catId and t.t_id=tu.t_id";
        $sql = "select t.*,tu.* from blog_team as t INNER JOIN blog_team_user as tu  WHERE cat_id =$catId and t.t_id=tu.t_id";
        if ($catId == -1) {
            $sql = "select t.*,tu.* from blog_team as t INNER JOIN blog_team_user as tu  WHERE t.t_id=tu.t_id";
        }
        $data = $this->query($sql);
        $data = $this->dealTeamInfo($data);
        $returnData = array();
        foreach ($data as $v) {
            $returnData[] = $this->dealTeamInfo3($v);
        }
        return $returnData;


    }

    public function dealTeamInfo3($arr)
    {
        //处理的数据
        /*处理的数据
         array(7) {
              ["t_id"] => string(2) "12"
              ["cat_id"] => string(1) "1"
              ["t_project_name"] => string(20) "我、w\\\]]]]]]]]]]"
              ["t_leader_name"] => string(2) "ss"
              ["t_leader_num"] => string(2) "ss"
              ["tu_user_name"] => array(2) {
                [0] => string(3) "wer"
                [1] => string(6) "王五"
              }
              ["tu_user_num"] => array(2) {
                [0] => string(3) "ewr"
                [1] => string(2) "33"
              }
            }

        //处理的结果
        /*处理结果

                      [0] => array(6) {
                ["t_id"] => string(2) "12"
                ["cat_id"] => string(1) "1"
                ["t_project_name"] => string(20) "我、w\\\]]]]]]]]]]"
                ["t_leader_name"] => string(2) "ss"
                ["t_leader_num"] => string(2) "ss"
                ["t_user_info"] => array(2) {
                  [0] => array(2) {
                    ["name"] => string(3) "wer"
                    ["num"] => string(3) "ewr"
                  }
                  [1] => array(2) {
                    ["name"] => string(6) "王五"
                    ["num"] => string(2) "33"
                  }
                }
              }
        }
         */
//        $arr = $arr[1];
        $returnData = array();
        $returnData['t_id'] = $arr['t_id'];
        $returnData['cat_id'] = $arr['cat_id'];
        $returnData['cat_name'] = $arr['cat_name'];
        $returnData['t_project_name'] = $arr['t_project_name'];
        $returnData['t_leader_name'] = $arr['t_leader_name'];
        $returnData['t_leader_num'] = $arr['t_leader_num'];
        //解决数组里面的二维数组
        for ($i = 0; $i < count($arr['tu_user_name']); $i++) {
            $returnData['t_user_info'][$i]['name'] = $arr['tu_user_name'][$i];
            $returnData['t_user_info'][$i]['num'] = $arr['tu_user_num'][$i];
        }

        return $returnData;

    }

    /*
     * 根据catId获取名字
     * @return string 名字
     */
    public function getCatNameByCatId($catId)
    {
        $mCat = D('team_category');
        $sql = "select cat_name from blog_team_category WHERE cat_id=$catId";
        $data = $this->query($sql);
        $data = $data[0]['cat_name'];
        return $data;
    }

}