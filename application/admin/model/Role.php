<?php
/**
 * Created by PhpStorm.
 * User: 李
 * Date: 2017/2/27 0027
 * Time: 20:38
 */

namespace app\admin\model;

use think\Model;

class Role extends Base
{
    protected $table = "gms_role";
    protected $autoWriteTimestamp = 'datetime';

    public function getRoleName($id)
    {
        if ($id)
            return $this->where(['id' => $id])->cache(true,60)->value('name');
    }

    public function getRules($id)
    {
        if ($id)
            return $this->where(['id' => $id])->value('rules');
    }

    protected function formatDataContent($data)
    {
        foreach ($data['data'] as $k => $item) {
            $data['data'][$k]['status'] = get_status($item['status']);
        }
        return $data;
    }


    protected function formatDataStructure($data)
    {
        return formatRow($data['total'], $data['data']);
    }


}