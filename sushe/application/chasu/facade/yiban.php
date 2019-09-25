<?php
/**
 * Created by PhpStorm
 * User: Dujianjun
 * Date: 2019/9/7
 * Time: 下午11:33
 */
namespace app\chasu\facade;
use think\Facade;

class yiban extends Facade
{
    protected static function getFacadeClass()
{
    return '\app\chasu\common\yiban';
}
}