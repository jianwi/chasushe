<?php
/**
 * Created by PhpStorm
 * User: Dujianjun
 * Date: 2019/10/8
 * Time: 下午8:51
 */

namespace app\chasu\model;


use think\Db;
use think\Model;

class ClassInfo extends Model
{
    private $db;
    public function __construct()
    {
        $this->db = Db::table("class_info");
    }
    public function saveClassInfo($data)
    {
        if (!$data) return false;
        $id = $this->db->insertGetId($data);
        return $this->db->get($id);
    }

    public function updateClassInfo($data,$condition)
    {
        $id = $this->db->where($condition)->update($data);
        return $this->db->get($id);
    }
    public function delData($condition)
    {
        $ud = [
            "isDelete" => 1,
        ];
        return $this->updateClassInfo($ud,$condition);
    }

    public function delDataById($id)
    {
        $condition = [
            "id" => $id
        ];
        return $this->delData($condition);
    }


}