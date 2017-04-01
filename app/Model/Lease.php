<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    protected $guarded = array('id','_token','lease_id');
}
