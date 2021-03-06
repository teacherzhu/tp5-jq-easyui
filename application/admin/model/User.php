<?php
/**
 * Created by PhpStorm.
 * User: 李
 * Date: 2017/2/25 0025
 * Time: 0:09
 */

namespace app\admin\model;

class User extends Base
{
    protected $table = "gms_user";
    protected $autoWriteTimestamp = 'datetime';




    protected function formatDataContent($data)
    {
        $role = new Role();
        foreach ($data['data'] as $k => $item) {
            $data['data'][$k]['role_name'] = $role->getRoleName($item['role_id']);
            $data['data'][$k]['status'] = get_status($item['status']);
        }
        return $data;
    }


    protected function formatDataStructure($data)
    {
        return formatRow($data['total'], $data['data']);
    }

    public function login($param)
    {

        $username = trim($param->param('username'));//I("post.username", "", "trim");
        $password = trim($param->param('password'));//I("post.password", "", "trim");

        if (empty ($username) || empty ($password)) {
            return message('404', '用户名或密码不能为空!');
        }

        $map = array(
            'username' => $username,
            'password' => $password,
            'status' => 1
        );
        $user_info = $this->where($map)->field('password,create_time,update_time', true)->find();

        if ($user_info) {
            $this->save(['login_ip' => $param->ip(), 'login_time' => date('Y-m-d H:i:s',time())], $map);
            session(config('auth_key'), $user_info ['id']);
            session('user_info', $user_info);
            return message('200', 'index');
        } else {
            return message('400', '用户名密码错误或此用户已被禁用!');
        }

    }

    /* 退出登录 */
    public function logout()
    {
        cache('DB_CONFIG_DATA', NULL);
        session(config('auth_key'), '');
        session('menu_list', '');
        session(null);
    }

}