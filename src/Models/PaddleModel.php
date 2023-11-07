<?php

namespace Teckipro\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaddleModel extends Model
{
    use HasFactory;
    protected $table='subscriptions'; //very important
    public $timestamps = false; //very important
}
