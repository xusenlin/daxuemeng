<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//在命令行输入php artisan tinker >>>namespace App\Model >>>>factory(Post::class,50)->create();

/*
 * 用户模拟
 */
$factory->define(\App\Model\User::class, function (Faker\Generator $faker) {
    return [
        'nickname' => $faker->name,
        'cellphone' => '1511'.$faker->numberBetween(7875500,9875500) ,
        'email' => $faker->email,
        'password' => bcrypt(123456),
        'avatar' => $faker->imageUrl(256,256),
        'name' => $faker->name,
        'remember_token' => str_random(10),
        'qq' =>$faker->numberBetween(1875500,9875500),
        'sex' =>rand(1,3),
        'signature' => $faker->sentence,
    ];
});

/*
 * post模拟
 */
$factory->define(\App\Model\Post::class, function (Faker\Generator $faker) {
    $arr = array('draft','published','recycled');
    return [
        'title' => $faker->sentence(mt_rand(3,10)),
        'content' => $faker->text,
        'excerpt' => $faker->sentence(mt_rand(3,50)),
        'status' => $arr[rand(0,2)],
        'type' => \App\Model\Post::TYPE_DRIVING,
        'cover' => $faker->imageUrl(256,256),
        'published_time' => date('Y-m-d h:i:s',time()),
        'view_count' => rand(1,100),
        'comment_count' => rand(1,100),
        'favorite_count' => rand(1,100),
        'collected_count' => rand(1,100),
        'forward_count' => rand(1,100),
    ];
});

/*
 * 二手市场模拟
 */
$factory->define(\App\Model\SecondaryMarket::class, function (Faker\Generator $faker) {
    $arr = array('标签一','标签二','标签三','其他标签');
    $status = array('pending','published');
    $user_ids = \App\Model\User::lists('id')->toArray();
    return [
        'name' => $faker->sentence(mt_rand(3,6)).'产品名称',
        'title' => $faker->sentence(mt_rand(3,6)).'出售标题',
        'description' => '产品描述'.$faker->sentence(mt_rand(3,50)),
        'tag' => $arr[rand(0,3)],
        'cover' => $faker->imageUrl(256,256),
        'original_price' =>rand(30,100),
        'status' => $status[rand(0,1)],
        'owner' => $faker->randomElement($user_ids),
        'cellphone' => '1511'.$faker->numberBetween(7875500,9875500) ,
    ];
});