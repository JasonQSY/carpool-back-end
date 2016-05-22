<?php
/**
 * Created by PhpStorm.
 * User: JasonQSY
 * Date: 5/20/16
 * Time: 10:18 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Libraries\JsonGeneral;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Libraries\CurlLib;

final class UserController extends Controller
{
    /**
     * @var App\Libraries\JsonGeneral
     */
    private $jsonGeneral;

    /**
     * @var CurlLib
     */
    private $curl_lib;
    
    private $appid = '';
    private $appsecret = '';
    
    /**
     * UserController constructor.
     * 
     * @param JsonGeneral $jsonGeneral
     * @param CurlLib $curlLib
     */
    public function __construct(JsonGeneral $jsonGeneral, CurlLib $curlLib)
    {
        $this->jsonGeneral = $jsonGeneral;
        $this->curl_lib = $curlLib;
    }

    /**
     * @todo
     */
    public function login()
    {
        if (!empty(Input::get('code'))) {
            // redirect
            $this_url = urlencode(url('login')); //todo
            $gate_url = "http://www.weixingate.com/api/v1/wgate_oauth?back=$this_url&force=1";
            redirect('$gate_url');
        } else {
            // read
            $wechat_code = Input::get('code');
            $wechat_wgateid = $this->curl_lib->get_from("http://api.weixingate.com/v1/wgate_oauth/userinfo?code=$wechat_code");
            $result = DB::select('select * from users where wechat_openid = ?', [$wechat_wgateid]);
            if ($result) {
                $uid =
            }

        }
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
     * Get code for weixin authorization
     *
     * @param string $redirect_uri
     * @return string
     */
    public function getCodeUrl() {
        $redirect_uri = Input::get('redirect_uri');
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?' . 'appid=' . strval($this->appid) . '&redirect_uri=' . urlencode($redirect_uri) . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect' ;
        return $url;
    }

    /**
     * Get code for weixin access_token
     *
     * @param $code,
     * @return mixed
     */
    public function getAccessToken() {
        $code = Input::get('code');
        if (!$code) {
            return $this->jsonGeneral->show_error("Invalid weixin code");
        }
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . strval($this->appid) . '&secret=' . strval($this->appsecret) . '&code=' . strval($code) . '&grant_type=authorization_code';
        $user_ch = curl_init();
        curl_setopt($user_ch, CURLOPT_URL, $url);
        curl_setopt($user_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($user_ch, CURLOPT_CONNECTTIMEOUT, 10);
        $user_data = curl_exec($user_ch);
        curl_close($user_ch);
        $user_json = json_decode($user_data, true);
        if (!$user_json) {
            return $this->jsonGeneral->show_error('Error Code');
        } else {
            if (isset($user_json['errcode'])) {
                return $this->jsonGeneral->show_error('Error Code');
            } else {
                return $user_json;
            }
        }
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
        $session = new Session();
        $session->set('uid', $wechat_id);
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
                    $session->set('uid', $wechat_id);
                    return $this->jsonGeneral->show_success($user->username);
                } else {
                    return $this->jsonGeneral->show_error('Invalid wechat_openid or access_token');
                }
            } catch (Exception $e) {
                return $this->jsonGeneral->show_error('Invalid wechat_openid or access_token');
            }
        } else {
            $session->set('uid', $wechat_id);
            return json_encode($result);
        }
    }
}