<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /*
     * 自定义登录字段。
     */
    protected $username = 'cellphone';

    /*
        * 登录注册视图。
        */
    protected $loginView = 'auth.login';
    protected $registerView = 'auth.register';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if ( isMobile()){
            $this->redirectTo = '/' ;
            $this->loginView = 'mobile.login';
            $this->registerView = 'mobile.register';
        }
        $this->middleware('guest', ['except' => 'logout']);
    }


    //可以使用昵称或者手机号登录
    protected function getCredentials(Request $request)
    {

        $login = $request->get('cellphone');

        $field = strlen($login)== 11 && is_numeric($login) ? 'cellphone' : 'nickname';

        return [
            $field => $login,
            'password' => $request->get('password'),
        ];
    }

    /**
     * 重写登录验证
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'cellphone' =>'required|min:2',
            'password' => 'required|min:6',
        ], [
            'cellphone.required' => '手机号或者昵称必须填写！',
            'cellphone.min' => '手机号必须为11位，昵称必须大于2位！',
            
            'password.required' => '请填写密码！',
            'password.min' => '密码长度必须大于6位！',
        ]);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'cellphone' =>'required|max:11|min:11|unique:users',
            'nickname' => 'required|max:6|min:2|unique:users',
            'password' => 'required|confirmed|min:6',
        ], [
            'cellphone.required' => '手机号必须填写！',
            'cellphone.max' => '手机号必须为11位！',
            'cellphone.min' => '手机号必须为11位！',
            'cellphone.unique' => '手机号已经被注册！',
            'nickname.required' => '昵称必须填写！',
            'nickname.max' => '昵称不能大于6个字符！',
            'nickname.min' => '昵称不能少于2个字符！',
            'nickname.unique' => '昵称已经存在！',
            'password.required' => '请填写密码！',
            'password.min' => '密码长度必须大于6位！',
            'password.confirmed' => '两次输入的密码不一致！',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        return User::create([
            'cellphone' => $data['cellphone'],
            'nickname' => $data['nickname'],
            'password' => bcrypt($data['password']),
        ]);
    }


    //重写注册方法，改变注册字段

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $userModel = new User();

        $userModel->cellphone = $request->cellphone;
        $userModel->nickname = $request->nickname;
        $userModel->password = bcrypt($request->password);

        if ($userModel->save());
        return redirect($this->redirectPath());
        echo '<script>alert("系统出错！");</script>';
        die();
    }
}
