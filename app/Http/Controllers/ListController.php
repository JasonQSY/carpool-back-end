<?php
/**
 * Created by PhpStorm.
 * User: JasonQSY
 * Date: 5/20/16
 * Time: 7:20 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use App\Http\Requests\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Input;
use App\JsonGeneral;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

final class ListController extends Controller
{
    private $userController;
    private $jsonGeneral;

    public function __construct(UserController $userController, JsonGeneral $jsonGeneral)
    {
        $this->userController = $userController;
        $this->jsonGeneral = $jsonGeneral;
    }

    /**
     * 获取所有活跃的订单
     *
     * API: /list/get
     */
    public function index()
    {
        $returnList = [];
        $list = DB::select('select * from act WHERE state = ?', [0]);
        foreach ($list as $item) {
            $creator = $this->userController->get_username_by_uid($item->creator_uid);
            $people = [];
            if ($item->people1_uid !== -1) {
                $people[] = $this->userController->get_username_by_uid($item->people1_uid);
            }
            if ($item->people2_uid !== -1) {
                $people[] = $this->userController->get_username_by_uid($item->people2_uid);
            }
            if ($item->people3_uid !== -1) {
                $people[] = $this->userController->get_username_by_uid($item->people3_uid);;
            }
            $returnList[] = [
                'creator' => $creator,
                'name' => $item->name,
                'people' => $people,
                'from' => $item->from,
                'to' => $item->to,
                'expectedNum' => $item->expectedNumber,
                'state' => $item->state
            ];
        }

        // 其实response应该封装进lib,但是先算了吧
        return response()->json($returnList);
    }

    /**
     * 获取一个订单的具体信息
     *
     * @param $id
     */
    public function detail($id)
    {
        $list = DB::select('select * from act WHERE act_id = ?', [$id]);
        $item = $list[0];
        $creator = $this->userController->get_username_by_uid($item->creator_uid);
        $people = [];
        if ($item->people1_uid !== -1) {
            $people[] = $this->userController->get_username_by_uid($item->people1_uid);
        }
        if ($item->people2_uid !== -1) {
            $people[] = $this->userController->get_username_by_uid($item->people2_uid);
        }
        if ($item->people3_uid !== -1) {
            $people[] = $this->userController->get_username_by_uid($item->people3_uid);;
        }
        $returnItem = [
            'creator' => $creator,
            'name' => $item->name,
            'people' => $people,
            'from' => $item->from,
            'to' => $item->to,
            'expectedNum' => $item->expectedNumber,
            'state' => $item->state
        ];

        // 其实response应该封装进lib,但是先算了吧
        return response()->json($returnItem);
    }

    /**
     * 创建一个订单
     *
     * @param info
     * @return bool->status
     */
    public function add()
    {
        //$creator = Input::get('creator');

        //$state = Input::get('state');
        //$people[] = Input::get('people');

        $creator_wechat_openid = Input::get('creator');
        $name = Input::get('name');
        $from = Input::get('from');
        $to = Input::get('to');
        $expectedNumber = Input::get('expectedNum');
        if ($this->userController->get_uid_by_wechat_id($creator_wechat_openid)) {
            try {
                DB::table('act')->insert([
                    'name' => $name,
                    'creator_uid' => $this->userController->get_uid_by_wechat_id($creator_wechat_openid),
                    'people1_uid' => -1,
                    'people2_uid' => -1,
                    'people3_uid' => -1,
                    'from' => $from,
                    'to' => $to,
                    'expectedNumber' => $expectedNumber,
                    'state' => 0,
                ]);
                return $this->jsonGeneral->show_success();  //Use redirect and session ?
            } catch (Exception $e) {
                return $this->jsonGeneral->show_error("Database error");
            }
        } else {
            return $this->jsonGeneral->show_error("Invalid wechat_id");
        }


    }

    /**
     * 更新一个订单
     * @todo
     * @param $id
     * @param $info
     */
    public function update()  //Post
    {
        $act_id = Input::get('act_id');
        $info = Input::get('info');
        return Redirect::to('list/get');  //Temporarily redirect to list/get
    }

    /**
     * 移除一个订单
     *
     * 刚开始有什么好移除的吗,我懒得写了
     *
     * @todo
     * @param $id
     * @return status
     */
    public function remove($id)
    {
        // remove according to id.
        try {
            $res = DB::delete('delete from act WHERE act_id = ?', [$id]);  //The other act_id(s) will not change
        } catch (Exception $e) {
            return $this->jsonGeneral->show_error("Database error");
        }
        if ($res) {
            return $this->jsonGeneral->show_success(); //Use redirect and sessions?
        } else {
            return $this->jsonGeneral->show_error("Invalid act id");
        }
    }
}