<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     *
     * @return void
     */
    public function __construct()
    {
        /*必须登录才能访问这个类*/
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {

        return view('admin.home');
    }
}
