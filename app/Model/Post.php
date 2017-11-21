<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    const CATEGORY_ID_IS_LEAGUE = 2; //文章是社团信息类型
    const CATEGORY_ID_IS_FOOD = 2; //文章是美食信息类型

    protected $guarded = array('id','_token','driving_id','league_id');
}
