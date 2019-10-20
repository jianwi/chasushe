<?php
/**
 * Created by PhpStorm
 * User: Dujianjun
 * Date: 2019/10/7
 * Time: 下午10:13
 */

namespace app\chasu\controller;



use app\chasu\common\res;
use think\Db;
use think\facade\Request;

class ClassInfo extends auth\Admin
{
    private $db;
    private $m;
    protected $beforeActionList = [
        'auth' =>  ['except'=>'getCollegeList,getClassList'],
    ];
    public function __construct()
    {
        $this->db = Db::table("class_info");
        $this->m =  model("ClassInfo");
    }

    public function index()
    {
        return view();
    }
    public function addCollege()
    {
        $psd = Request::post() or die("403");
        $psd['type'] = 1;
        $res =  model("ClassInfo")->saveClassInfo($psd);
        return res::res($res);
    }
    public function delCollege()
    {
        $psd = Request::post("id/d") or die("403");
        $res =  $this->m->delDataById($psd);
        return res::res($res);
    }

    /**
     * 学院,班级重命名
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function rename()
    {
        $post_data = Request::only(["id","name"],"post") or die("403");

        $result = $this->db->where([
            "id" => intval($post_data['id'])
            ])
            ->update([
            "name" => $post_data['name'],
        ]);
        return res::res($result);
    }

    /**
     * 班级列表
     */

    public function addClass()
    {
        $post_data = Request::only(["name","college"],"post") or die("403");
        $post_data['type'] = 2;
        $result = $this->m->saveClassInfo($post_data);
        return res::res($result);
    }

    public function delClass()
    {
        $psd = Request::post("id/d") or die("403");
        $res =  $this->m->delDataById($psd);
        return res::res($res);
    }
    public function getClassList()
    {
        $college = Request::get("college_id/d") or die("403");
        $condition = [
            "isDelete" => 0,
            "type" => 2,
            "college" => $college
        ];
        return res::res($this->db->where($condition)->select());
    }
    public function getCollegeList()
    {
        $condition = [
            "isDelete" => 0,
            "type" =>1
        ];
        return res::res($this->db->where($condition)->select());
    }
}