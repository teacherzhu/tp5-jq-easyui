<?php
/**
 * Created by PhpStorm.
 * User: 李
 * Date: 2017/2/25 0025
 * Time: 0:09
 */

namespace app\admin\model;

use think\Log;
use think\Model;
use think\Request;

class User extends model
{
    protected $table = "gms_user";
    protected $autoWriteTimestamp = true;

    public function login($param)
    {

        if (!is_login()) {
            $request = Request::instance();
            $username = trim($param['username']);//I("post.username", "", "trim");
            $password = trim($param['password']);//I("post.password", "", "trim");

            if (empty ($username) || empty ($password)) {
                return message('404', '用户名或密码不能为空!');
            }

            $map = array(
                'username' => $username,
                'password' => $password,
                'status' => 1
            );
            $user_info = db($this->table)->where($map)->field('password,create_time,update_time', true)->find();

            if ($user_info) {
                $this->save(['login_ip' => $request->ip(), 'login_time' => time()], $map);
                session(config('auth_key'), $user_info ['id']);
                session('user_info', $user_info);
                return message('200', 'index');
            } else {
                return message('400', '用户名密码错误或者此用户已被禁用!');
            }
        } else {
            return redirect(config('user_index'));
        }
    }

    /* 退出登录 */
    public function logout()
    {
        session(config('auth_key'), '');
        session('menu_list', '');
        session(null);
    }

}