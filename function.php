<?php
/**
 * Created by PhpStorm.
 * User: yangzc
 * Date: 2017/7/28
 * Time: 9:40
 * 公共函数库
 */


if(!function_exists('str_explode')){
    /**
     * @param $str
     * @return array
     * 自定义字符串截取
     */
    function str_explode($str,$at='_')
    {
        if (strpos($str, $at) !== false) {
            return explode($at, $str);
        }
    }
}


/**
 * @param $tel
 * @return string
 * 正则验证手机号码
 */
function checkTel($tel){
    if(!preg_match('/^1[3|4|5|7|8]\d{9}$/',trim($tel))){
        $this->jsonReturn(201,'手机号码格式错误');
    }
    return trim($tel);
}
/**
 * 生成UUID
 * @param string $prefix 可以指定前缀
 * @return string
 */
function create_uuid($prefix = "") {
    $str = md5(uniqid(mt_rand(), true));
    $uuid  = substr($str,0,8) . '_';
    $uuid .= substr($str,8,4) . '_';
    $uuid .= substr($str,12,4) . '_';
    $uuid .= substr($str,16,4) . '_';
    $uuid .= substr($str,20,12);
    return $prefix . $uuid;
}

if(!function_exists('file_log')){
    /**
     * @param $path
     * @param $content
     * 文件日志
     */
    function file_log($path,$content){
        file_put_contents($path,$content,FILE_APPEND);
    }
}

if(!function_exists('dump_r')){
    /**
     * @param $data
     * 打印
     */
  function dump_r($data){
        echo "<pre>".print_r($data,true);die;
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

if(!function_exists('get_city')){
    /**
     * 获取 IP  地理位置
     * 淘宝IP接口
     * @Return: array
     */
    function get_city($ip = '')
    {
        if($ip == ''){
            $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
            $ip=json_decode(file_get_contents($url),true);
            $data = $ip;
        }else{
            $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
            $ip=json_decode(file_get_contents($url));
            if((string)$ip->code=='1'){
                return false;
            }
            $data = (array)$ip->data;
        }

        return $data?$data['country'].$data['country_id'].$data['area'].$data['region'].$data['city'].$data['isp']:'';
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


if(!function_exists('two_number')){
    /**
     * @param $val
     * @return string
     * 把结果保留两位小数
     */
    function two_number($val){
        return sprintf("%.2f",$val);
    }
}