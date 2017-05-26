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

function isMobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

/**
 * 把图片转换成指定的大小，
 *
 * @param unknown_type $file_path 换成的图片位置, 本地位置的绝对路径或者是url
 * @param unknown_type $maxwidth 要转换的宽
 * @param unknown_type $maxheight 要转换的高
 * @param unknown_type $suffix 转换后的图片的后缀，原图为name.jpg 新图为 name.suffix.jpg
 * @param unknown_type $save_path 新文件要保存的绝对位置，沒有指定則保存在原文件所在目录
 * @param unknown_type $keep_scale 保持宽高比例,默认为false不保持，按指定的进行缩放，如果为true，则忽略maxheight，高度按比例缩放
 *
 * @return string|bool 新文件全路径, 失败返回false
 */
function img_scale($file_path, $maxwidth, $maxheight, $suffix='default', $save_path=null, $keep_scale=true){
    list($width, $height, $orig_type, $attr) = @getimagesize($file_path);
    if(empty($width))return false;

    #如果图片的实际宽度大于要转换成的宽度

    if($width>$maxwidth){
        $zoom = $maxwidth/$width;
        $new_width  = $maxwidth;
        $new_height = ceil($height*$zoom);//先按比例縮放
        if(!$keep_scale && $new_height>$maxheight){//縮放后仍然大于要求的高則使用指定的高
            $new_height = $maxheight;
        }
    }else{
        #如果图片的实际宽度小于能够显示的最大宽度，显示实际宽度
        $new_width  = $width;
        $new_height = $height;
        if(!$keep_scale && $new_height>$maxheight){
            $new_height = $maxheight;
        }
    }

    $fileinfo = pathinfo($file_path);
    $file = ($save_path ? $save_path: $fileinfo['dirname'].'/').$fileinfo['filename'].'.'.$suffix.'.'.@$fileinfo['extension'];

    #创建缩略图
    $image = @imagecreatefromstring( file_get_contents( $file_path) );
    list($dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) = array(0,0,0,0,$new_width,$new_height,$width,$height);
    $newimage = @imagecreatetruecolor( $dst_w, $dst_h);

    // preserve PNG transparency
    if ( IMAGETYPE_PNG == $orig_type) {
        @imagealphablending( $newimage, false);
        @imagesavealpha( $newimage, true);
    }

    @imagecopyresampled( $newimage, $image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

    // we don't need the original in memory anymore
    @imagedestroy( $image );

    ob_start();
    switch($orig_type){
        case IMAGETYPE_GIF:@imagegif( $newimage );break;
        case IMAGETYPE_PNG:@imagepng( $newimage );break;
        default:
            @imagejpeg( $newimage, null, 100 );
    }
    @imagedestroy( $newimage );
    file_put_contents($file, ob_get_clean());

    if(file_exists($file)){
        return $file;
    }else{
        return false;
    }
}

function get_login_user($column = 'id'){
    if (Auth::user())
        return Auth::user()->$column;
    return null;
}