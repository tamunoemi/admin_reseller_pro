<?php

namespace Teckipro\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaddleCustomersModel extends Model
{
    use HasFactory;
    protected $table='customers'; //very important
    public $timestamps = false; //very important
}
