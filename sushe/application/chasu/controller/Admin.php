<?php
namespace app\chasu\controller;

use app\chasu\common\res;
use app\chasu\facade\yiban;
use app\chasu\model\History;
use app\chasu\model\Room;
use app\chasu\model\User;
use think\Db;
use think\Exception;
use think\facade\Request;

class Admin
{
    public function __construct()
    {
        $yb_uid = yiban::getUid();
        $info = \app\chasu\model\Teacher::where([
            "yb_uid" => $yb_uid,
            "isDelete" => 0,
        ])
            ->where("status",">","1")
            ->find();
        $this->info = $info or die("没有操作权限");

    }
    public function index()
    {
        return view();
    }

    public function room(){
        return view();
    }

    public function getRoom($id){
        return Room::where([
            "prev" => $id,
            "isDelete" => 0
        ])->select();
    }
    public function Allroom()
    {
        $data = Room::where([
            "isDelete" =>0,
            "prev" => null
        ])->select();
        return json($data);
    }
    public function saveRoom()
    {
        $data = Request::post();

        if (!$data) return false;

        Db::startTrans();
        try{
            $gongyu = Db::table("room")->insertGetId([
                "name" => $data['room_name']
            ]);
          foreach ($data['danyuan_name'] as $index => $danyuan){

                $danyuan_id = Db::table("room")->insertGetId([
                    "name" => $danyuan,
                    "prev" => $gongyu
                ]);

              for ($i=1;$i<=$data['louceng'][$index];$i++){
                    $louceng = Db::table("room")->insertGetId([
                        "name" => $i,
                        "prev" => $danyuan_id
                    ]);
                    $datas = [];
                    for ($n=1;$n<=$data['room_count'][$index];$n++){
                        array_push($datas,[
                            "name" => $n,
                            "prev" => $louceng
                        ]);
                    }
                    Db::name("room")->data($datas)->limit(100)->insertAll();
                }
            }
          Db::commit();
          return 1;
        }catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return 0;
        }
    }
    public function delete(){
        $id = Request::post("id");
        Db::startTrans();
        try{
            Room::where([
                "id" => intval($id)
            ])
                ->update(['isDelete'=>1]);

            $child1 = Room::where([
                "prev" => $id
            ])->select();
            if (count($child1)===0){
                User::where(["room_id"=>intval($id)])->update(['isDelete'=>1]);
            }
            foreach ($child1 as $danyuan){
                Room::where([
                    "id" => ($danyuan['id'])
                ])
                    ->update(['isDelete'=>1]);

                $child2 = Room::where([
                    "prev" => $danyuan['id']
                ])->select();
                if (count($child2)===0){
                    User::where(["room_id"=>$danyuan['id']])->update(['isDelete'=>1]);
                }
                foreach ($child2 as $louceng) {
                    Room::where([
                        "id" => ($louceng['id'])
                    ])
                        ->update(['isDelete' => 1]);

                    $child3 = Room::where([
                        "prev" => $louceng['id']
                    ])->select();
                    if (count($child3)===0){
                        User::where(["room_id"=>$louceng['id']])->update(['isDelete'=>1]);
                    }
                        foreach ($child3 as $fangjian){
                            Room::where([
                                "id" => ($fangjian['id'])
                            ])
                                ->update(['isDelete'=>1]);
                            User::where(["room_id"=>$fangjian['id']])->update(['isDelete'=>1]);
                        }
                    }
                }
            Db::commit();
            return res::success();
        }catch (Exception $e){
            Db::rollback();
            return res::fail();
        }
    }
    public function teachers(){
        return view();
    }
    public function teachersList($p=0){
        $teachers =  \app\chasu\model\Teacher::where("isDelete","0")
                ->withAttr("status",function ($value){
                $sta = [
                    "0" => "待审核",
                    "1" => "辅导员" ,
                    "2" => "后台管理"
                ];
                return $sta[$value];
            })
            ->limit($p,10)
            ->order("status")
            ->select();
        return json($teachers);
    }
    public function teacherSearch()
    {
        $name = Request::post("name");
        $teachers_list = \app\chasu\model\Teacher::where("name","like","{$name}%")->where("isDelete","0")
                ->withAttr("status",function ($value){
                    $sta = [
                        "0" => "待审核",
                        "1" => "辅导员" ,
                        "2" => "后台管理"
                    ];
                    return $sta[$value];
                })
                ->order("status")
                ->select();
        return json($teachers_list);
    }
    public function teacherCheck()
    {
        $post_data = Request::only(["id","type"],"post");
        if ($post_data['type'] == -1){
           $state =  \app\chasu\model\Teacher::where("id",intval($post_data['id']))->update(['isDelete'=>1]);
            if ($state){
                return res::success();
            }else{
                return res::fail();
            }
        }else{
            $state = \app\chasu\model\Teacher::where("id",intval($post_data['id']))->update(['status'=> intval($post_data['type'])]);
            if ($state){
                return res::success();
            }else{
                return res::fail();
            }
        }
    }
    public function students()
    {
        return view();
    }
    public function modifyStudentInfo($id)
    {
        $id = intval($id) or die("403");
        $user_info = User::where([
            "isDelete" => 0,
            "id" => $id
        ])->find();
        if (!$user_info) return "没有此用户";
        return view()->assign([
            "user" => $user_info
        ]);
    }
    public function modifyStudentInfoSub()
    {
        $hasFile = Request::has("photo","file");
        $post_data = Request::only(["name","college","major","room","id"],"post") or die("403");
        if ($hasFile){
            $post_file = Request::file("photo");
            $info = $post_file->move("./uploads");
            if ($info){
                $pic = $info->getSaveName() or die("文件上传失败");
                $post_data['pic'] = $pic;
            }
        }
        $id = $post_data['id'];
        unset($post_data['id']);

        History::makeLog("4","修改学生信息",$this->info['id'],json($post_data),"0");
        $state = User::where("id",$id)->update($post_data);
        return res::res($state);
    }
    public function deleteUser()
    {
        $id = Request::post("id") or die("403");

        History::makeLog("3","删除学生",$this->info['id'],$id,"0");

        $state = User::update(["isDelete"=>1],["id"=>$id]);
        return res::res($state);
    }

    public function allStudents()
    {
        return view();
    }
    public function studentsList($p=0)
    {
        $res =  User::where("isDelete","0")
            ->limit($p,10)
            ->order("id desc")
            ->select()->all();
        $res = array_map(function ($i){
            $i["room"] = Room::getRoomInfo($i["room"]);
            return $i;
        },$res);
        return json($res);
    }
    public function studentSearch()
    {
        $name = Request::post("name");
        $students_list = User::where("name","like","{$name}%")->where("isDelete","0")
            ->order("id desc")
            ->select();
        return json($students_list);
    }

    public function history()
    {
        return view();
    }
}