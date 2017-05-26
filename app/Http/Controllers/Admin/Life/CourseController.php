<?php

namespace App\Http\Controllers\Admin\Life;

use App\Model\Course;
use App\Model\Department;
use App\Model\Major;
use App\Model\School;
use App\Model\Timetable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CourseController extends Controller
{
    public function index(Request $request){

        $db = DB::table('timetables as t')
            ->leftJoin('courses as c','t.course_id','=', 'c.id')
            ->select('t.*','t.comment as timetable_comment','c.name as course_name','c.school as school_name','c.department as department_name','c.major as major_name')
            ->orderBy('t.id', 'desc');

        if($request->s_school)$db->where('c.school_id', $request->s_school);
        if($request->s_department)$db->where('c.department_id', $request->s_department);
        if($request->s_major)$db->where('c.major_id', $request->s_major);
        if($request->s_name)$db->where('c.name', 'like', $request->s_name);

        $courses = $db->paginate(PAGING_NUMBER_ADMIN);

        return view('admin.life.course_list')->with(['courses'=>$courses]);
    }

    public function course_add(Request $request) {
        $id = $request->id;
        if ($id) {
            $course = DB::table('timetables as t')
                ->leftJoin('courses as c','t.course_id','=', 'c.id')
                ->where('t.id', $id)
                ->select('t.*','t.comment as timetable_comment','c.*')
                ->first();
        }
        return view('admin.life.course_add')->with(['Course'=>@$course]);
    }

    public function course_save(Request $request) {
        $id = $request->id;
        try {
            $this->validate($request, [
                'name' => 'required',
                'school' => 'required',
                'department' => 'required',
                'major' => 'required',
                'grade' => 'required',
                'class' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
            ], [
                'name.required' => '课程名称必须填写！',
                'school.required' => '所属学校必须选择！',
                'department.required' => '所属院系必须选择！',
                'major.required' => '所属专业必须选择！',
                'grade.required' => '年级必须填写！',
                'class.required' => '班级必须填写！',
                'start_time.required' => '上课开始时间必须填写！',
                'end_time.required' => '上课结束时间必须填写！',

            ]);
        } catch (\Illuminate\Foundation\Validation\ValidationException $e) {
            $response = $e->getResponse();
            $errorContent = json_decode($response->getContent(), true);
            $errors = '';
            foreach ($errorContent as $errorMsgs) {
                foreach ($errorMsgs as $msg) {
                    $errors .= $msg . "<br>";
                }
            }
            error($errors);
        }

        $class = str_replace("，", ",", $request->class);

        if($id) {
            $Timetable = Timetable::find($id);
            $Course = Course::find($Timetable->course_id);
        } else {
            $Course = new Course();
            $Timetable = new Timetable();
        }
        $School = School::find($request->school);
        $Department = Department::find($request->department);
        $Major = Major::find($request->major);

        $Course->name = $request->name;
        $Course->school_id = $request->school;
        $Course->school = $School->name;
        $Course->department_id = $request->department;
        $Course->department = $Department->name;
        $Course->major_id = $request->major;
        $Course->major = $Major->name;

        if (! $Course->save()) error("系统错误");


        $Timetable->course_id = $Course->id;
        $Timetable->grade = $request->grade;
        $Timetable->class = $class;
        $Timetable->teacher = $request->teacher;
        $Timetable->place = $request->place;
        $Timetable->type = $request->type;
        $Timetable->weekday = $request->weekday;
        $Timetable->start_time = $request->start_time;
        $Timetable->end_time = $request->end_time;
        $Timetable->comment = $request->comment;

        if ($Timetable->save()) success();
        else error();
    }

    function course_del(Request $request) {
        $id = $request->id;
        if (! $id) error("非法操作");

        if (is_numeric($id)) {
            if (Timetable::destroy($id)) success();
            else error("系统错误");
        } else if($id == 'all') {
            if (DB::table('timetables')->delete()) success();
            else error("系统错误");
        }

    }


}
