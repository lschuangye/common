<?php
 /*****
  * 公共父类
  */
 class Controller{


     /**
      * @param $page
      * @param $limit
      * @return array
      * 初始化页码
      * 1为第一页
      */
     function page_init($page,$limit){
         if($page<1 || $limit<1){
             $this->jsonReturn(201,'页码参数错误');
         }else{

             $pageNum = ($page-1)*$limit;


             return ['page'=>intval($pageNum),'limit'=>intval($limit)];
         }
     }



     /**
      * @param $tel
      * @return string
      * 验证手机号码格式
      */
     function checkTel($tel){
         if(!preg_match('/^1[3|4|5|7|8]\d{9}$/',trim($tel))){
             $this->jsonReturn(201,'手机号码格式错误');
         }
         return trim($tel);
     }

     /**
      * @param $code
      * @param $data
      * @param string $msg
      * 返回json格式数据
      */
     function jsonReturn($code,$msg='',$data=[]){

         if(trim($code)){
             header('Content-Type:application/json; charset=utf-8');
             if(empty($msg)){
                 $msg = $this->get_msg();
             }
             $arr = array('errcode'=>$code,'data'=>$data,'msg'=>$msg,'time'=>time());
             $this->requestLog($arr);
             exit(json_encode($arr,JSON_UNESCAPED_UNICODE));
         }else{
             exit('request error: not code！');
         }

     }

     /**
      * @param $param
      * 验证参数
      */
     protected function checkRequest($param){
         if(is_array($param)){
             $arr =[];
             foreach ($param as $key=>$val){
                 if(!isset($_REQUEST[$key]) || !trim($_REQUEST[$key])){
                     if($val){
                         $msg = $val;
                     }else{
                         $msg = 'not '.$key;
                     }
                     return $this->jsonReturn(201,$msg);
                 }
                 $arr[$key] = trim($_REQUEST[$key]);
             }

             return $arr;
         }else{
             return $this->jsonReturn(201,'参数错误');
         }
     }
     /**
      * @param $name name
      * @param $path  路径
      * @param array $exts arr文件类型
      * @return string   图片名称
      * api 单张图片上传
      */
     protected function upload_file($name,$path,$exts=array('jpg', 'gif', 'png', 'jpeg')){
         $upload = new \Think\Upload();// 实例化上传类
         $upload->maxSize   =     3145728 ;// 设置附件上传大小
         $upload->exts      =     $exts;// 设置附件上传类型
         $upload->rootPath ='Public';
         $upload->savePath  =      $path; // 设置附件上传目录
         $info   =   $upload->uploadOne($_FILES[$name]);
         if($info){
             $imgSrc = get_http().'/Public'.$info['savepath'].$info['savename'];
             return $imgSrc;

         }else{
             $this->jsonReturn(201,$upload->getError());
         }
     }


     /**
      * @param $path
      * @param array $ext
      * 多文件上传
      * $path 从public 下一级开始
      */
     function upload_files($path,$ext =array('jpg', 'gif', 'png', 'jpeg') ){
         $upload = new \Think\Upload();// 实例化上传类
         $upload->maxSize   =     3145728 ;// 设置附件上传大小
         $upload->exts      =      $ext ;// 设置附件上传类型
         $upload->rootPath ='Public/';
         $upload->savePath  =     $path; // 设置附件上传目录
         //上传文件
         $info   =   $upload->upload();
         if(!$info) {
             // 上传错误提示错误信息
             $this->jsonReturn(201,$upload->getError());
         }else{
             // 上传成功 获取上传文件信息
             $arr = [];
             foreach($info as $file){
                 $arr[] =  get_http().'/Public'.$file['savepath'].$file['savename'];
             }
             return $arr;
         }

     }

     /**
      * @param $table  表明
      * @param array $delField arr 需要过滤的字段
      * @return array|string
      * 返回数据表的字段
      */
     function getFileds($table,$delField=[]){
         $field = M()->query('describe '.$table);
         $arr = [];
         if($field){
             foreach ($field as $key=>$val){
                 $a = 1;
                 foreach ($delField as $k=>$v){
                     if($val['field']==$v){
                         $a = 0;
                         continue;
                     }

                 }
                 if($a==0){
                     continue;
                 }
                 $arr[] = $val['field'];

             }
             if(count($arr)<1){
                 $arr = ' * ';
             }
         }else{
             $arr = ' * ';
         }
         return $arr;
     }

     /**
      * 请求日志
      */

     function requestLog($return){

         $dir = APP_PATH.'Runtime/log_api/'.MODULE_NAME.'/'.date('Y_m_d').'/';
         if(!is_dir($dir))
         {
             mkdir($dir,0777,true);
         }
//        $request = print_r($_REQUEST,true);
         $request = 'GET:'.print_r($_GET,true)."\nPOST:".print_r($_POST,true)."\n";
         if($_FILES){
             $request = "file:\n".print_r($_FILES,true)."\n\n".$request;
         }
         $type = $_SERVER['REQUEST_METHOD'];
         $return = print_r($return,true);
         $ip = get_ip();
         //最后执行的sql语句
         $sql = M()->getLastSql();

         $con = "请求来源:".$this->get_os()."\n请求ip:".$ip."\n请求方式:".$type."\n请求参数:\n".$request."\nsql:".$sql."\n"."返回值:\n".$return."\n\n\n\n\n\n";
         file_put_contents($dir.CONTROLLER_NAME.'_'.ACTION_NAME.'.log','请求时间:'.date('Y-m-d H:i:s',time())."\n".$con."\n",FILE_APPEND);
     }


     /**
      * 获取客户端操作系统信息包括win10
      * @param  null
      * @author  Jea杨
      * @return string
      */
     function get_os(){
         $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
         $os = 'other';

         if (preg_match('/win/i', $agent) && strpos($agent, '95'))
         {
             $os = 'Windows 95';
         }
         else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90'))
         {
             $os = 'Windows ME';
         }
         else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent))
         {
             $os = 'Windows 98';
         }
         else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent))
         {
             $os = 'Windows Vista';
         }
         else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent))
         {
             $os = 'Windows 7';
         }
         else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent))
         {
             $os = 'Windows 8';
         }else if(preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent))
         {
             $os = 'Windows 10';#添加win10判断
         }else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent))
         {
             $os = 'Windows XP';
         }
         else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent))
         {
             $os = 'Windows 2000';
         }
         else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent))
         {
             $os = 'Windows NT';
         }
         else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent))
         {
             $os = 'Windows 32';
         }
         else if (preg_match('/linux/i', $agent))
         {
             $os = 'Linux';
         }
         else if (preg_match('/unix/i', $agent))
         {
             $os = 'Unix';
         }
         else if (preg_match('/mac/i', $agent) && preg_match('/PC/i', $agent))
         {
             $os = 'Macintosh';
         }else if(strpos($agent, 'iphone') || strpos($agent, 'ipad')){
             $os = 'ios';
         } else if(strpos($agent, 'android')){
             $os = 'android';
         }else if(strpos($agent, 'mac')){
             $os = '苹果mac';
         }else{
             $os = '未知操作系统';
         }


         return $os;
     }
 }