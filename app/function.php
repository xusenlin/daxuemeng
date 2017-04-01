<?php
/**
 * Created by PhpStorm.
 * User: Jordan
 * Date: 2017/2/7
 * Time: 9:16
 */

function get_sex($sex){
    if(!$sex)return 'null';
    if (1 == $sex || 'male' == $sex )return '男';
    if (2 == $sex || 'female' ==$sex )return '女';
    if ('all' ==$sex )return '不限';
    if (3 ==$sex )return '保密';
}

function get_menu_data(){
    $menu = Config::get('menu');
    return $menu;

}

function error($message="", $code=null){
    echo json_encode(array('success'=> false, "errorCode"=>$code, "msg"=>$message));
    die;
}

function success($message="",$data=null){
    echo json_encode(array('success'=> true, "data"=>$data,"msg"=>$message));
    die;
}
