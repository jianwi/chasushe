<?php
/**
 * Created by PhpStorm
 * User: Dujianjun
 * Date: 2019/10/13
 * Time: 下午6:06
 */

namespace app\chasu\controller;


use app\chasu\common\res;
use think\Db;
use think\facade\Request;

class TeacherClass extends auth\Admin
{
    private $db;
    private $m;
    public function __construct()
    {
        $this->auth();
        $this->db = Db::table("teacher_class");
        $this->m =  model("TeacherClass");
    }

    public function getMyClass()
    {
        $teacher_id = Request::get("teacher_id/d");
        $res = $this->db->where([
            "teacher_id" => $teacher_id,
            "teacher_class.isDelete" => 0
        ])
            ->join("class_info","teacher_class.class=class_info.id")
            ->field("teacher_class.*,class_info.name")
            ->select();
        return res::res($res);
    }
    public function arrange()
    {
        $post_data = Request::only(["teacher_id","class"],"post") or die("403");
        $post_data['type'] = 1;
        $id = $this->db->insertGetId($post_data);
        $result = $this->db
            ->join("class_info","teacher_class.class=class_info.id")
            ->where("teacher_class.id",$id)
            ->find();
        return res::res($result);
    }
    public function delClass()
    {
        $id = Request::post("id/d") or die("403");
        $res = $this->db->where([
            "id"=> $id
        ])
            ->update([
                "isDelete" => 1
            ]);
        return res::res($res);
    }


}