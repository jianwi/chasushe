<?php
/**
 * Created by PhpStorm
 * User: Dujianjun
 * Date: 2019/10/20
 * Time: 下午11:26
 */

namespace app\chasu\controller\auth;


use app\chasu\facade\yiban;

class Admin
{
    function auth()
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
}