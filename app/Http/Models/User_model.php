<?php
/**
 * Created by PhpStorm.
 * User: JasonQSY
 * Date: 5/20/16
 * Time: 4:51 PM
 */

namespace App\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

final class User_model extends Authenticatable
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