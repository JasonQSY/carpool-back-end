<?php
/**
 * Created by PhpStorm.
 * User: JasonQSY
 * Date: 5/12/16
 * Time: 3:04 PM
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class Market extends Controller
{
    /**
     * 显示可以交易的拼车信息
     */
    public function index()
    {
        $data['list'] = [
            [
                'creator' => '灰尘',
                'member' => [],
                'expected_number' => 3,
                'from' => 'D20',
                'to' => '东川路地铁站',
                'status' => 0 //not full
            ],
            [
                'creator' => '胡主席',
                'member' => [],
                'expected_number' => 2,
                'from' => 'D20',
                'to' => '剑川路地铁站',
                'status' => 0
            ],
            [
                'creator' => 'Luke',
                'member' => ['灰尘'],
                'expected_number' => 2,
                'from' => 'D22',
                'to' => '我编不出来地点了',
                'status' => 1 //full
            ]
        ];
        return view('market', $data);
    }

}