<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Model\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    //角色列表
    public function index(){
        $rolesModel = new Role();
        $roles = $rolesModel->paginate(PAGING_NUMBER_ADMIN);

        return view('admin.permission.roles_list')->with(['roles'=>$roles]);
    }

    //用户和角色列表
    public function roles_users(){
        $roleUser = DB::table('role_user as ru')
            ->join('users as u','ru.user_id','=','u.id')
            ->join('roles as r','ru.role_id','=','r.id')
            ->select('u.cellphone','u.nickname','r.display_name')
            ->paginate(PAGING_NUMBER_ADMIN);
        return view('admin.permission.roles_users')->with(['roles_user'=>$roleUser]);
    }
}
