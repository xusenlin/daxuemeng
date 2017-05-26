<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    //
    public static function getDepartmentMajors($department_id) {
        return Major::where('department_id', $department_id)->get();
    }
}
