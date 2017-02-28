<?php
/**
 * Created by PhpStorm.
 * User: 李
 * Date: 2017/2/27 0027
 * Time: 20:33
 */

namespace app\admin\model;

use think\Log;
use think\Model;

class Rule extends model
{
    protected $table = "gms_rule";


    public function getRule()
    {
        $menus = session('menu_list');
        if (!$menus) {
            session('menu_list', '');
            if (in_array(session(config('auth_key')), config('administrator'))) {
                $map = array(
                    'is_hide' => 0,
                    'status' => 1
                );
            } else {
                $Role = new Role();
                $rules = $Role->getRules(session(config('auth_key')));
                $ids = array();
                foreach ($rules as $g) {
                    $ids = array_merge($ids, explode(',', trim($g ['rules'], ',')));
                }
                $ids = array_unique($ids);
                $map = array(
                    'id' => array('in', $ids),
                    'is_hide' => 0,
                    'status' => 1
                );
            }

            $menus =  db($this->table)->where($map)->field('id,pid,name,title,icon as iconCls')->order('sort asc')->select();
            if ($menus) {
                foreach ($menus as $rid => $rules_one) {
                    $menus [$rid] ['attributes'] = array(
                        "url" => url($rules_one ['name']),
                        "rule" => $rules_one ['name']
                    );
                    $menus [$rid] ['text'] = $rules_one ['title'];
                }
                $menus = list_to_tree($menus, $pk = 'id', $pid = 'pid', 'children');

                session('menu_list', $menus);
                return $menus;
            }
            else{
                return message(400,'此用户没有任何权限');
            }
        }
        return $menus;
    }

}