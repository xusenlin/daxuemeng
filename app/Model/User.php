<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use \Zizaco\Entrust\Traits\EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获取全部用户名,手机和id
     * @return mixed
     */
    public static function getAllUserName(){
        $allUsers = User::select('id','name','cellphone')->get();
        return $allUsers;
    }

}
