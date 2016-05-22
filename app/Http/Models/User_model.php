<?php
/**
 * Created by PhpStorm.
 * User: JasonQSY
 * Date: 5/20/16
 * Time: 4:51 PM
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

final class User_model extends Model
{
    /**
     * @var string
     */
    protected $table = "users";

    /**
     * @var string
     */
    protected $primaryKey = "uid";
}