<?php
/**
 * Created by PhpStorm.
 * User: JasonQSY
 * Date: 5/20/16
 * Time: 4:51 PM
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

final class Act_model extends Model
{
    /**
     * @var string
     */
    protected $table = "act";

    /**
     * @var string
     */
    protected $primaryKey = "act_id";

    /*
    public function get_current_number($id)
    {
        $item = $this->find($id);
        $number = 0;
        if ($item['people1_uid'] !== -1) {
            $number += 1;
        }
        if ($item['people2_uid'] !== -1) {
            $number += 1;
        }
        if ($item['people3_uid'] !== -1) {
            $number += 1;
        }
        return $number;
    }*/
}