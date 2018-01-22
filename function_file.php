<?php
/**
 * Created by PhpStorm.
 * User: yangzc
 * Date: 2018/1/19
 * Time: 18:14
 * 文件 操作函数
 */


/**
 * @param $filename 文件路径
 * @param $name 下载的文件名 包括后缀
 * $type 为文件类型  如 pdf  doc 等
 */
function download_file($filename,$name,$type=''){
    if($type){
        header('Content-type: application/'.$type);
    }

    header('Content-Disposition: attachment; filename="'.$name.'"');
    readfile($filename);

//将文件内容读取出来并直接输出，以便下载
    readfile($filename);
}