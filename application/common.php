<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use app\admin\utils\Auth;

/**
 * 检测用户是否登录
 * @return integer 0--->未登录，大于0---->当前登录用户ID
 */
function is_login()
{
    $user = session(config('auth_key'));
    if (empty($user)) {
        return 0;
    } else {
        return session(config('auth_key'));
    }
}

/**
 * 检测当前用户是否为管理员
 * @param int $uid 传入uid
 * @return boolean true-管理员，false-非管理员
 */
function is_admin($uid)
{
    $uid = is_null($uid) ? is_login() : $uid;
    if (in_array($uid, config('administrator'))) {
        return true;
    } else {
        return false;
    }
}

/**
 * 权限认证
 * @param $authName
 * @return bool
 */
function is_auth($authName)
{
    $Auth = new Auth();
    $authKey = is_login();
    Think\Log::record('$authName-------------->' . $authName);
    //判断当前认证key是否不在 超级管理组配置中
    if (!is_admin($authKey)) {
        if (!$Auth->check($authName, $authKey)) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}

/**
 * list 结构转为 tree 结构
 * @param array $list 源数据
 * @param string $pk 父节点ID
 * @param string $pid 数据ID
 * @param string $child 子节点名称
 * @param int $root 根节点ID
 * @return array
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str 要分割的字符串
 * @param  string $glue 分割符
 * @return array
 */
function str2arr($str, $glue = ',')
{
    return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array $arr 要连接的数组
 * @param  string $glue 分割符
 * @return string
 */
function arr2str($arr, $glue = ',')
{
    return implode($glue, $arr);
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree 原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array $list 过渡用的中间数组，
 * @return array        返回排过序的列表数组
 */
function tree_to_list($tree, $child = '_child', $order = 'id', &$list = array())
{
    if (is_array($tree)) {
        foreach ($tree as $key => $value) {
            $Leaf = $value;
            if (isset($Leaf[$child])) {
                unset($Leaf[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $Leaf;
        }
        $list = list_sort_by($list, $order, $sort = 'asc');
    }
    return $list;
}

/**
 * 获取当前登录用户的组织ID
 */
function get_group_id()
{
    return session('user_info')['group_id'];
}

/**
 * 获取当前登录用户的用户组ID
 */
function get_role_id()
{
    return session('user_info')['role_id'];
}

function message($code, $msg = '', $data = array())
{
    return ['Code' => $code, 'Msg' => $msg, 'Data' => $data];
}

function formatRow($total, $data)
{
    return ['total' => $total, 'rows' => $data];
}