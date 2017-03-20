<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: luofei614 <weibo.com/luofei614>　
// +----------------------------------------------------------------------
// | Rewrite: li <184117183@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\utils;
    /**
     * 权限认证类
     * 功能特性：
     * 1，是对规则进行认证，不是对节点进行认证。用户可以把节点当作规则名称实现对节点进行认证。
     *      $auth=new Auth();  $auth->check('规则名称','用户id')
     * 2，可以同时对多条规则进行认证，并设置多条规则的关系（or或者and）
     *      $auth=new Auth();  $auth->check('规则1,规则2','用户id','and')
     *      第三个参数为and时表示，用户需要同时具有规则1和规则2的权限。 当第三个参数为or时，表示用户值需要具备其中一个条件即可。默认为or
     */

//数据库
/*
DROP TABLE IF EXISTS `gms_role`;
CREATE TABLE `gms_role` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `status` int(3) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for gms_rule
-- ----------------------------
DROP TABLE IF EXISTS `gms_rule`;
CREATE TABLE `gms_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `pid` int(11) DEFAULT '0' COMMENT '上级菜单',
  `name` varchar(100) DEFAULT NULL COMMENT '菜单名称',
  `title` varchar(100) DEFAULT NULL COMMENT '菜单标题',
  `icon` varchar(30) DEFAULT '' COMMENT '图标',
  `type` varchar(1) DEFAULT '1' COMMENT '导航',
  `is_hide` varchar(1) DEFAULT '1' COMMENT '隐藏',
  `status` varchar(1) DEFAULT '1' COMMENT '状态',
  `sort` smallint(3) unsigned DEFAULT '1' COMMENT '排序'
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

 */

class Auth
{

    //默认配置
    protected $_config = array(
        'AUTH_ON' => true,                // 认证开关
        'AUTH_TYPE' => 1,                 // 认证方式，1为实时认证；2为登录认证。
        'AUTH_ROLE' => 'gms_role',        // 用户组数据表名
        'AUTH_RULE' => 'gms_rule',        // 权限规则表
        'AUTH_USER' => 'gms_user'           // 用户信息表
    );

    public function __construct()
    {
        $this->_config['AUTH_ROLE'] = $this->_config['AUTH_ROLE'];
        $this->_config['AUTH_RULE'] = $this->_config['AUTH_RULE'];
        $this->_config['AUTH_USER'] = $this->_config['AUTH_USER'];
        if (config('AUTH_CONFIG')) {
            //可设置配置项 AUTH_CONFIG, 此配置项为数组。
            $this->_config = array_merge($this->_config, config('AUTH_CONFIG'));
        }
    }

    /**
     * 检查权限
     * @param string $name  需要验证的规则列表,支持','|'/' 分隔的权限规则或索引数组
     * @param int  $uid           认证用户的id
     * @param string $mode        执行check的模式
     * @param $relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @return boolean           通过验证返回true;失败返回false
     */
    public function check($name, $uid, $mode = 'url', $relation = 'or')
    {
        if (!$this->_config['AUTH_ON'])
            return true;
        $authList = $this->getAuthList($uid); //获取用户需要验证的所有有效规则列表
        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, '/') !== false) {
                $name = str2arr($name,'/');
            }
            }else if(strpos($name, ',') !== false){
                $name = str2arr($name);
            } else {
            $name = array($name);
        }
        $list = array(); //保存验证通过的规则名
        if ($mode == 'url') {
            $REQUEST = unserialize(strtolower(serialize($_REQUEST)));
        }
        foreach ($authList as $auth) {
            $query = preg_replace('/^.+\?/U', '', $auth);
            if ($mode == 'url' && $query != $auth) {
                parse_str($query, $param); //解析规则中的param
                $intersect = array_intersect_assoc($REQUEST, $param);
                $auth = preg_replace('/\?.*$/U', '', $auth);
                if (in_array($auth, $name) && $intersect == $param) {  //如果节点相符且url参数满足
                    $list[] = $auth;
                }
            } else if (in_array($auth, $name)) {
                $list[] = $auth;
            }
        }
        if ($relation == 'or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation == 'and' and empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     * 根据用户id获取用户组,返回值为数组
     * @param  uid int     用户id
     * @return array       用户所属的用户组 array(
     *     array('uid'=>'用户id','role_id'=>'用户组id','name'=>'用户组名称','rules'=>'用户组拥有的规则id,多个,号隔开'),
     *     ...)
     */
    public function getRole($uid)
    {
        static $groups = array();
        if (isset($groups[$uid])) {
            return $groups[$uid];
        } else {
            $user_role = db('')->table($this->_config['AUTH_USER'] . ' a')
                ->where('a.id', $uid)->where('b.status', 1)
//                ->where("a.id='$uid' and b.status=`1`")
                ->join($this->_config['AUTH_ROLE'] . ' b', 'a.role_id = b.id')
                ->field('a.id as uid,b.id as role_id,b.name,b.rules')->select();
            $groups[$uid] = $user_role ?: array();
        }
        return $groups[$uid];
    }

    /**
     * 获得权限列表
     * @param integer $uid 用户id
     * @param integer $type
     */
    protected function getAuthList($uid)
    {
        static $_authList = array(); //保存用户验证通过的权限列表

        if ($this->_config['AUTH_TYPE'] == 2 && isset($_SESSION['_AUTH_LIST_' . $uid])) {
            return $_SESSION['_AUTH_LIST_' . $uid];
        }

        //读取用户所属用户组
        $roles = $this->getRole($uid);

        $ids = array();
        //获取所有用户组所拥有的rule的ID
        foreach ($roles as $role) {
            $ids = array_merge($ids, str2arr(trim($role['rules'], ',')));
        }
        $ids = array_unique($ids);

        if (empty($ids)) {
            return array();
        }
        //读取用户组所有权限规则
        $rules = db($this->_config['AUTH_RULE'])
            ->where('id', 'in', $ids)
            ->where('status', 1)
            ->field('name')
            ->select();
        foreach ($rules as $rule) {
            //只要存在就记录
            $_authList[] = strtolower($rule['name']);
        }
        $_authList = array_unique($_authList);
        if ($this->_config['AUTH_TYPE'] == 2) {
            //规则列表结果保存到session
            $_SESSION['_AUTH_LIST_' . $uid] = $_authList;
        }
        return $_authList;
    }

//    /**
//     * 获得用户资料,根据自己的情况读取数据库
//     */
//    protected function getUserInfo($uid)
//    {
//        static $userinfo = array();
//        if (!isset($userinfo[$uid])) {
//            $userinfo[$uid] = M()->where(array('uid' => $uid))->table($this->_config['AUTH_USER'])->find();
//        }
//        return $userinfo[$uid];
//    }

}
