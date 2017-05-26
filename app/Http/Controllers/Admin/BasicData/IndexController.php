<?php

namespace App\Http\Controllers\Admin\BasicData;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(){

        $usersModel = new User();
        $users = $usersModel->paginate(PAGING_NUMBER_ADMIN);

        return view('admin.users.users_list')->with(['users'=>$users]);
    }
    
    //禁用用户
    public function Disabled($user_id = null){

        if (!$user_id)error('参数错误!');
        $info = '';
        $userModel = User::find($user_id);
        if( 0 == $userModel->active){
            $userModel->active = 1;
            $info = '启用用户成功';
        }else{
            $userModel->active = 0;
            $info = '禁用用户成功';
        }
        if($userModel->save()){
            success($info);
        }
    }

}
