<?php
/**
 * Created by PhpStorm.
 * User: yangzc
 * Date: 2017/7/28
 * Time: 9:40
 * 公共函数库
 */


if(!function_exists('remove_arraych')){
    /**
     * @param $array
     * @return array
     * 去掉二维数组重复的值
     */
    function remove_arraych($array,$keys){
        $result=array();
        foreach ($array as $key => $value) {
            $has = false;
            foreach($result as $val){
                if($val[$keys]==$value[$keys]){
                    $has = true;
                    break;
                }
            }
            if(!$has)
                $result[]=$value;
        }
        return $result;
    }
}


if(!function_exists('curl_return_code')){
    /**
     *返回状态吗
     * @param $url
     * @return mixed
     */
    function curl_return_code($url){
        $ch = curl_init ();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_NOBODY, FALSE);
         #curl_setopt( $ch, CURLOPT_POSTFIELDS, "username=".$username."&password=".$password );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_exec($ch);
        return curl_getinfo($ch,CURLINFO_HTTP_CODE);
    }
}

if(!function_exists('curl_post')){
    /**
     * @param $url
     * @param string $data
     * @return mixed
     * curl模拟post请求
     */
    function curl_post($url,$data='')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $rust = curl_exec($ch);
        curl_close($ch);
        //打印获得的数据
        return $rust;
    }
}



if(!function_exists('curl_get')){
    /**
     * @param $url
     * @return mixed
     * curl 模拟get请求
     */
    function curl_get($url)
    {
        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, $url);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($cu);
        curl_close($cu);
        return $ret;
    }
}


if(!function_exists('curlXml')){
    /**
     * @param $url
     * @param $sml
     * @return mixed
     * curl 模拟xml数据提交
     */
    function curlXml($url,$xml){
        $ch = curl_init();
        $header[] = "Content-type: text/xml";//定义content-type为xml
        curl_setopt($ch, CURLOPT_URL, $url); //定义表单提交地址
        curl_setopt($ch, CURLOPT_POST, 1);   //定义提交类型 1：POST ；0：GET
        curl_setopt($ch, CURLOPT_HEADER, 1); //定义是否显示状态头 1：显示 ； 0：不显示
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//定义请求类型
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);//定义是否直接输出返回流
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); //定义提交的数据，这里是XML文件
        $result = curl_exec($ch);
        curl_close($ch);//关闭
        return $result;
    }
}

//公共方法
if(!function_exists('trim_all')){
    /**
     * @param $str
     * @return mixed
     * 去掉前后中间的空格
     */
    function trim_all($str){
        return  preg_replace('# #','',$str);
    }
}

if(!function_exists('get_ip')){
    /**
     * @return string
     * 获取ip地址
     */
    function get_ip()
    {
        if(isset($_SERVER['HTTP_X_REAL_IP']) && $_SERVER['HTTP_X_REAL_IP']<>'')
        {
            $onlineip = htmlentities($_SERVER['HTTP_X_REAL_IP']);
        }else if(isset($_SERVER['REMOTE_ADDR'])){
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }else{
            $onlineip = '127.0.0.1';
        }
        return $onlineip;
    }

}

if(!function_exists('get_http')){
    /**
     * @return string
     * 获取当前域名
     */
    function get_http(){
        $http = (isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!='off')?'https://':'http://';
        $http = $http.$_SERVER['SERVER_NAME'];
        $port = $_SERVER["SERVER_PORT"]==80?'':':'.$_SERVER["SERVER_PORT"];
        $url = $http.$port;
        $host = $url.'/';
        return $host;
    }

}


if(!function_exists('make_pwd')){

    /**
     * @param $password
     * @param $salt
     * @return string
     * 密码加密
     */
    function make_pwd($password,$salt){
        if(trim($password) && $salt){
            return sha1(md5($password.$salt));
        }else{
            exit('error');
        }

    }

}

if(!function_exists('preg_pwd')){
    /**
     * @param $pwd
     * 验证密码规则
     * 6-16 字母数字
     */
    function preg_pwd($pwd)
    {
        if(!preg_match('/^[0-9a-zA-Z_#.+*,?.;]{6,16}$/',$pwd))
        {
            return false;
        }
        return $pwd;
    }
}

if(!function_exists('is_upload_file')){
    /**
     * @return bool
     * 判断是否有文件上传
     */
    function is_upload_file($name){
        if(isset($_FILES[$name])){
            $file = $_FILES[$name];
            if(is_array($file['size'])){
                //多图片
                if($file['size'][0]>0){
                    return true;
                }else{
                    return false;
                }

            }else{
                //单个图片
                if($file['size']>0){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }

    }
}


if(!function_exists('towNumber')){
    /**
     * @param $val
     * @return string
     * 把结果保留两位小数
     */
    function two_number($val){
        return sprintf("%.2f",$val);
    }
}