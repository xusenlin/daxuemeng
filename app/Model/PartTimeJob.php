<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PartTimeJob extends Model
{
    protected $guarded = array('id','_token','job_id');
}
