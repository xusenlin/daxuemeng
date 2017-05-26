<?php

namespace App\Http\Controllers\Admin\BasicData;

use App\Model\Department;
use App\Model\Major;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\School;
use DB;

class SchoolController extends Controller
{
    public function index(){
        $SchoolModel = new School();
        $schools = $SchoolModel->paginate(PAGING_NUMBER_ADMIN);

        return view('admin.basic_data.school_list')->with(['schools'=>$schools]);
    }

    public function school_add(Request $request) {
        $id = $request->id;
        if ($id) $school = School::find($id);
        return view('admin.basic_data.school_add')->with(['School'=>@$school]);
    }

    public function school_save(Request $request) {
        $id = $request->id;
        try {
            $this->validate($request, [
                'name' => 'required|unique:schools,name,' . $id,
            ], [
                'name.required' => '学校名称必须填写！',
                'name.unique' => '该学校已经存在！',
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

        if($id) $School = School::find($id);
        else $School = new School();
        $School->name = $request->name;
        $School->address = $request->address;
        $School->description = $request->description;

        if ($School->save()) success();
        else error();
    }

    public function department_list(){
        $db = DB::table('departments as d')->leftJoin('schools as s','d.school_id','=', 's.id')
            ->select('d.id','d.name','d.school_id','s.name as school_name')
            ->orderBy('d.school_id', 'asc');

        $departments = $db->paginate(PAGING_NUMBER_ADMIN);

        return view('admin.basic_data.department_list')->with(['departments'=>$departments]);
    }

    public function department_add(Request $request) {
        $id = $request->id;
        if ($id) $Department = Department::find($id);
        return view('admin.basic_data.department_add')->with(['Department'=>@$Department]);
    }

    public function department_save(Request $request) {
        $id = $request->id;
        try {
            $this->validate($request, [
                'name' => 'required',
                'school' => 'required',
            ], [
                'name.required' => '院系名称必须填写！',
                'school.required' => '所属学校必须选择！',
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

        if($id) {
            $isExist = Department::where('school_id', '=', $request->school)
                ->where('name', '=', $request->name)
                ->where('id', '!=', $id)
                ->first();
            if($isExist) error($request->name."已经存在");

            $Department = Department::find($id);
        } else {
            $isExist = Department::where('school_id', '=', $request->school)
                ->where('name', '=', $request->name)
                ->first();
            if($isExist) error($request->name."已经存在");

            $Department = new Department();
        }
        $Department->name = $request->name;
        $Department->school_id = $request->school;
        $Department->description = $request->description;

        if ($Department->save()) success();
        else error();
    }

    public function major_list(){
        $db = DB::table('majors as m')
            ->leftJoin('departments as d', 'd.id','=', 'm.department_id')
            ->leftJoin('schools as s', 's.id','=', 'm.school_id')
            ->select('m.id','m.name','d.name as department_name','s.name as school_name')
            ->orderBy('m.school_id', 'asc')
            ->orderBy('m.department_id', 'asc');

        $majors = $db->paginate(PAGING_NUMBER_ADMIN);

        return view('admin.basic_data.major_list')->with(['majors'=>$majors]);
    }

    public function  major_add(Request $request) {
        $id = $request->id;
        if ($id) $Major = Major::find($id);
        return view('admin.basic_data.major_add')->with(['Major'=>@$Major]);
    }

    public function  major_save(Request $request) {
        $id = $request->id;
        try {
            $this->validate($request, [
                'name' => 'required',
                'school' => 'required',
                'department'=> 'required',
            ], [
                'name.required' => '专业名称必须填写！',
                'school.required' => '所属学校必须选择！',
                'department.required' => '所属院系必须选择！',''
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

        if($id) {
            $isExist = Major::where('school_id', '=', $request->school)
                ->where('department_id', '=', $request->department)
                ->where('name', '=', $request->name)
                ->where('id', '!=', $id)
                ->first();
            if($isExist) error($request->name."已经存在");

            $Major = Major::find($id);
        } else {
            $isExist = Major::where('school_id', '=', $request->school)
                ->where('department_id', '=', $request->department)
                ->where('name', '=', $request->name)
                ->first();
            if($isExist) error($request->name."已经存在");

            $Major = new Major();
        }
        $Major->name = $request->name;
        $Major->school_id = $request->school;
        $Major->department_id = $request->department;
        $Major->description = $request->description;

        if ($Major->save()) success();
        else error();
    }

    public function school_department(Request $request)
    {
        $departments = Department::getSchoolDeparts($request->school);
        success('', $departments);
    }

    public function department_major(Request $request)
    {
        $majors = Major::getDepartmentMajors($request->department);
        success('', $majors);
    }
}
