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
        $username = $result[0]->username;
        return $username;
    }

    /**
     * 查不到 FALSE
     * 
     * @todo
     * @param $username
     * @return bool | int
     */
    public function get_uid_by_username($username)
    {
        
    }
}