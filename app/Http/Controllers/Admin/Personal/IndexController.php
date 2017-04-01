<?php

namespace App\Http\Controllers\Admin\Personal;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(){

        $user_info = Auth::user();

        return view('admin.personal.personal_center')->with(['user_info'=>$user_info]);
    }
}
