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

final class ListController extends Controller
{
    private $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
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
     * @return bool
     */
    public function add()
    {
        $creator = Input::get('creator');
        $name = Input::get('name');
        $people[] = Input::get('people');
        $from = Input::get('from');
        $to = Input::get('to');
        $expectedNumber = Input::get('expectedNum');
        $state = Input::get('state');
        DB::table('act')->insert([
            'creator' => $creator,
            'name' => $name,
            // todo 需要转换一下uid
        ]);
    }

    /**
     * 更新一个订单
     *
     * @param $id
     * @param $info
     */
    public function update($id, $info)
    {

    }

    /**
     * 移除一个订单
     *
     * 刚开始有什么好移除的吗,我懒得写了
     *
     * @todo
     * @param $id
     */
    public function remove($id)
    {
        // remove according to id.
    }
}