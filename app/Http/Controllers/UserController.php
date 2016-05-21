<?php
/**
 * Created by PhpStorm.
 * User: JasonQSY
 * Date: 5/20/16
 * Time: 10:18 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
//use App\Http\Requests\Request;
use Illuminate\Http\Response;
use App\JsonGeneral;
use Illuminate\Support\Facades\Input;

final class UserController extends Controller
{
    /**
     * @var App\JsonGeneral
     */
    private $jsonGeneral;

    /**
     * UserController constructor.
     * 
     * @param JsonGeneral $jsonGeneral
     */
    public function __construct(JsonGeneral $jsonGeneral)
    {
        $this->jsonGeneral = $jsonGeneral;
    }

    /**
     * @todo
     */
    public function login()
    {

    }

    /**
     * Maybe unnecessary
     * 
     * @todo
     */
    private function login_by_uid($uid)
    {
        //
    }

    /**
     * 注册
     * 
     * @todo
     * @return mixed
     */
    public function register()
    {
        // 应该先调 validaion, 然而我懒
        if (FALSE) {
            // 验证错误
            return $this->jsonGeneral->show_error();
        }

        $user = new User;
        //$user->username = Input::get('username');
        $user->username = "songbai";
        return $this->jsonGeneral->show_success($user->username);
    }

    /**
     * 查不到 FALSE
     * 
     * @param $uid
     * @return mixed
     */
    public function get_username_by_uid($uid)
    {
        $result = DB::select('select * from users where uid = ?', [$uid]);
        if (! $result) {
            return false;
        }
        $username = $result[0]->username;
        return $username;
    }

    /**
     * 查不到 FALSE
     *
     * @param $username
     * @return bool | int
     */
    public function get_uid_by_username($username)
    {
        $result = DB::select('select * from users where username = ?', [$username]);
        if (! $result) {
            return false;
        }
        $uid = $result[0]->uid;
        return $uid;
    }

    /**
     * 查不到 FALSE
     *
     * @param $wechat_id
     * @return bool | int
     */
    public function get_uid_by_wechat_id($wechat_id)
    {
        $result = DB::select('select * from users where wechat_openid = ?', [$wechat_id]);
        if (! $result) {
            return false;
        }
        $uid = $result[0]->uid;
        return $uid;
    }

    /**
     * 查不到 FALSE
     *
     * @return bool | int
     */
    public function authToken() {
        $wechat_id = Input::get('wechat_openid');
        $token = Input::get('access_token');
        $result = DB::select('select * from users where wechat_openid = ?', [$wechat_id]);
        if (! $result) {
            $user = new User;
            try {
                //$user_data = file_get_contents(
                $url = 'https://api.weixin.qq.com/sns/userinfo?' . 'access_token=' . strval($token) . '&openid=' . strval($wechat_id) . '&lang=zh_CN' ;
                $user_ch = curl_init();
                curl_setopt($user_ch, CURLOPT_URL, $url);
                curl_setopt($user_ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($user_ch, CURLOPT_CONNECTTIMEOUT, 10);
                $user_data = curl_exec($user_ch);
                curl_close($user_ch);
                $user_json = json_decode($user_data, true);
                if ($user_json) {
                    if (!array_key_exists('nickname', $user_json)) {
                        return $this->jsonGeneral->show_error('Can not get wechat nickname');
                    }
                    $user->username = $user_json['nickname'];
                    return $this->jsonGeneral->show_success($user->username);
                } else {
                    return $this->jsonGeneral->show_error('Invalid wechat_openid or access_token');
                }
            } catch (Exception $e) {
                return $this->jsonGeneral->show_error('Invalid wechat_openid or access_token');
            }
        } else {
            return json_encode($result);
        }
    }
}