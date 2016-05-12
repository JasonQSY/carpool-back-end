<?php
/**
 * Created by PhpStorm.
 * User: JasonQSY
 * Date: 5/12/16
 * Time: 3:34 PM
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class Detail extends Controller
{
    /**
     * 显示详细信息
     * @param $id int
     */
    public function index($id)
    {
        // 假装索引了数据库
        if ($id === '0') {
            $data['item'] = [
                'creator' => '灰尘',
                'member' => [],
                'expected_number' => 3,
                'from' => 'D20',
                'to' => '东川路地铁站',
                'status' => 0 //not full
            ];
        } elseif ($id === '1') {
            $data['item'] = [
                'creator' => '胡主席',
                'member' => [],
                'expected_number' => 2,
                'from' => 'D20',
                'to' => '剑川路地铁站',
                'status' => 0
            ];
        } else {
            $data['item'] = [
                'creator' => 'Luke',
                'member' => ['灰尘'],
                'expected_number' => 2,
                'from' => 'D22',
                'to' => '我编不出来地点了',
                'status' => 1 //full
            ];
        }
        
        return view('detail', $data);
    }
}