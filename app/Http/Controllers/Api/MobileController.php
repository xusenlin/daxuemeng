<?php

namespace App\Http\Controllers\Api;

use App\Model\School;
use App\Model\Student;
use App\Model\UserLeaseComment;
use App\Model\UserLeaseFlow;
use App\Model\UserPhoto;
use App\Model\UserPhotoComment;
use App\Model\UserPhotoFlow;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class MobileController extends Controller
{
    //租赁回复api
    public function comment(Request $request){
        if(!$request->comment)
            error('请输入内容!');

        if($request->lease_id){
            $comment = new UserLeaseComment();

            $comment->lease_id = $request->lease_id;
        }
        if($request->photo_id){
            $comment = new UserPhotoComment();

            $comment->photo_id = $request->photo_id;
        }

        $comment->content = $request->comment;
        $comment->author = Auth::user()->id;

        if ($comment->save())
            success('回复成功');
        error('服务器错误!');
    }

    //喜欢租赁
    public function lease_love(Request $request){
        if(!$request->lease_id)
            error('租赁id出错!');

        $love = UserLeaseFlow::where('lease_id','=',$request->lease_id)
            ->where('user_id','=',Auth::user()->id)
            ->where('type','=','favorite')
            ->first();

        if ($love){
            $love->delete();
            success('取消喜欢成功',false);
        }else{
            $newLove = new UserLeaseFlow();
            $newLove->user_id = Auth::user()->id;
            $newLove->lease_id = $request->lease_id;
            $newLove->type = 'favorite';
            if ($newLove->save())
                success('喜欢成功',true);
            error('保存失败');
        }

    }

    //图片上传
    public function photo_upload(Request $request){

        $photoUrl = [];
        $destinationPath = 'uploads/selfie/';
        foreach ($request->photo as $index => $photo_base64){
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $photo_base64, $result)){
                $type = $result[2];
                $new_file =$destinationPath.$index.uniqid(get_login_user()).".{$type}";
                $photoUrl[] = $new_file;
                file_put_contents(public_path($new_file), base64_decode(str_replace($result[1], '', $photo_base64)));
            }
        }
        $userId = get_login_user();
        $photoModel = new UserPhoto();

        $photoModel->message = $request->form_data['user_message'];
        $photoModel->city = $request->form_data['city'];
        $photoModel->photo = join(',',$photoUrl);
        $photoModel->user_id = $userId;

        $student = Student::where('user_id','=',$userId)
            ->select('school_id')
            ->first();

        if (@$student->school_id)
            $school = School::find($student->school_id);
     
        $photoModel->place = isset($school)? $school->name : '花溪大学城';

        if ($photoModel->save())
            success('上传成功！');
        error('');

    }

    //用户信息修改
    public function user_edit(Request $request){

        $column = $request->column;
        $columnVal = $request->columnVal;

        if ($column=='cellphone'){
            try {
                $this->validate($request, [
                    'columnVal'      => 'required|size:11|unique:users,cellphone,'.get_login_user(),
                ], [
                    'columnVal.unique'         => '手机号已经存在',
                    'columnVal.required'         => '手机号是必填的',
                    'columnVal.size'         => '手机号必须是11位',
                ]);
            } catch (\Illuminate\Foundation\Validation\ValidationException $e) {
                $response = $e->getResponse();
                $errorContent = json_decode($response->getContent(), true);
                $errors = '';
                foreach ($errorContent as $errorMsgs) {
                    foreach ($errorMsgs as $msg) {
                        $errors .= $msg . "，";
                    }
                }
                error($errors);
            }}
        if ($column=='email' && !filter_var($columnVal, FILTER_VALIDATE_EMAIL))
            error('邮箱格式不正确!');
        if ($column == 'nickname'){
            try {
                $this->validate($request, [
                    'columnVal'      => 'required|unique:users,nickname,'.get_login_user(),
                ], [
                    'columnVal.unique'         => '昵称已经存在',
                    'columnVal.required'         => '昵称是必填的',
                ]);
            } catch (\Illuminate\Foundation\Validation\ValidationException $e) {
                $response = $e->getResponse();
                $errorContent = json_decode($response->getContent(), true);
                $errors = '';
                foreach ($errorContent as $errorMsgs) {
                    foreach ($errorMsgs as $msg) {
                        $errors .= $msg . "，";
                    }
                }
                error($errors);
            }

        }
        
        if($column == 'student_grade' || $column == 'student_class' || $column =='change_school' ){
            
            $student = Student::where('user_id','=',get_login_user())
                ->first();
            if (!$student){
                $student = new Student();
                $student->user_id = get_login_user();
            }
            
           
            if ($column == 'change_school'){

                $student->school_id = $columnVal[0];
                $student->department_id = $columnVal[1];
                $student->major_id = $columnVal[2];
            }
            
            
            if ($column == 'student_grade')
                $student->grade = $columnVal;

            if ($column == 'student_class')
                $student->class = $columnVal;

            if ($student->save())
                success('修改成功！');
            error('服务器出错！');
        }

        $userModel =  Auth::user();

        if($column == 'avatar'){
            $destinationPath = 'uploads/avatar/';
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $columnVal, $result)){
                $type = $result[2];
                $new_file =$destinationPath.get_login_user().uniqid(get_login_user()).".{$type}";
                file_put_contents(public_path($new_file), base64_decode(str_replace($result[1], '', $columnVal)));
                $userModel->$column = $new_file;
                if ($userModel->save())
                    success('修改成功！');
                error('服务器出错！');
            }
            error('服务器出错！');

        }
        
        $userModel->$column = $columnVal;



        if ($userModel->save())
            success('修改成功！');
        error('服务器出错！');

    }
}
