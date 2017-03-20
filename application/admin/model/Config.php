<?php
/**
 * Created by PhpStorm.
 * User: 李
 * Date: 2017/3/19 0019
 * Time: 10:50
 */

namespace app\admin\model;

class Config extends Base
{

    protected $table = "gms_config";
    protected $autoWriteTimestamp = 'datetime';

    public function getConfigs()
    {
        $res = array();
        $temp = $this->where('status', 1)->field('name,value')->select();
        foreach ($temp as $name => $value) {
            $res[$value['name']] = $value['value'];
        }
        return $res;
    }


}