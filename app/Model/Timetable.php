<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    //
    public static function getWeekdayDesc($weekday=null) {
        $weekdays = array(1=>"星期一",2=>"星期二",3=>"星期三",4=>"星期四",5=>"星期五",6=>"星期六",7=>"星期日");
        return $weekday?$weekdays[$weekday]:$weekdays;
    }

    public static function getCourseTypeDesc($type=null) {
        $types = array('every'=>'每周','odd'=>'单周','even'=>'双周');
        return $type?$types[$type]:$types;
    }
}
