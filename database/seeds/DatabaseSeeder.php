<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Model::unguard();
//        \App\Model\User::create([
//            'name' => '徐森林',
//            'cellphone' => 15117875524 ,
//            'email' => '613773868@qq.com',
//            'avatar' => "",
//            'password' => bcrypt(123456),
//            'remember_token' => str_random(10),
//            'qq' => '613773868',
//            'sex' =>1,
//            'signature' => '个性签名,我还需要什么个性签名。',
//            'nickname' => '森林',
//            'type' =>'admin',
//        ]);
        $this->call(UserTableSeeder::class);
    }
}



class UserTableSeeder extends Seeder
{
    public function run()
    {
        //\App\Model\User::truncate();
        factory(\App\Model\User::class, 20)->create();
    }
}