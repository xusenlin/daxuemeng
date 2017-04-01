<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    const TYPE_DRIVING = 'driving'; //文章是驾校信息类型

    protected $guarded = array('id','_token','driving_id');
}
