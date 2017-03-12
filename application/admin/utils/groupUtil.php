<?php
namespace app\admin\utils;
/**
 * Created by PhpStorm.
 * User: 李
 * Date: 2017/3/9 0009
 * Time: 19:35
 */
class groupUtil
{
    private $dao;

    function __construct()
    {
        // TODO: Implement __construct() method.
        $this->dao = $user = model('Group');
    }

    /**
     * 传入groupID 返回 自身节点信息和下属节点信息
     * @param int $groupId
     * @return array
     */
    public function getAllGroupInfo($groupId = 1)
    {
        $data = $this->dao->where('id', $groupId)->find(); //查找语句
        $result = array();
        if ($data) {//判断有数据
            $parent = $data;//父节点
//            $name = $this->dao->where(['id' => $data['pid']])->getField('name'); //查找语句
            $name = $this->dao->where('id', $data['pid'])->value('name');; //查找语句
//            $map['level'] = array('LIKE', $parent['level'] . '%');
            $child = $this->dao->where('level', 'like', $parent['level'] . '%')->select();
            if ($child) {
                $groupHashMap = array();
                foreach ($child as $row) {
                    $groupHashMap[$row['id']] = $row['name'];
                }
                $groupHashMap[$parent['pid']] = $name ? $name : '根节点';
                foreach ($child as $k => $groupInfo) {
                    $groupInfo['p_name'] = "";
                    if ($k >= 1 && $child[$k - 1]['pid'] == $groupInfo['pid']) {
                        $child[$k]['p_name'] = $child[$k - 1]['p_name'];
                    } else {
                        $child[$k]['p_name'] = $groupHashMap[$groupInfo['pid']];
                    }
                }
            }

            $result = $child;
        }
        return $result;
    }

    /**
     * 返回下属节点groupID 字符串
     * @param string $group_ids
     * @param bool $is_str
     * @return string|array 下属节点ID字符串
     */
    function getAllChildID($group_ids, $is_str = true)
    {

        if (!$group_ids) {
            if ($is_str) {
                return '';
            } else {
                return array();
            }
        }
        $array_group_ids = array();
        $temp_group_id = str2arr($group_ids);
        foreach ($temp_group_id as $id) {
            $data = $this->getAllGroupInfo($id);
            if ($data) {
                foreach ($data as $group) {
                    array_push($array_group_ids, $group['id']);
                }
            }
        }
        $array_group_ids = array_unique($array_group_ids);
        if ($is_str) {
            return arr2str($array_group_ids);
        } else {
            return $array_group_ids;
        }
    }
}