<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    public static function getSchoolDeparts($school_id) {
        return Department::where('school_id', $school_id)->get();
    }
}
