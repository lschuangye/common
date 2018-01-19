<?php
/**
 * Created by PhpStorm.
 * User: yangzc
 * Date: 2018/1/19
 * Time: 18:14
 */


/**
 * @param $filename 文件路径
 * @param $name 下载的文件名 包括后缀
 */
function download_file($filename,$name){
//    header('Content-type: application/pdf');

    header('Content-Disposition: attachment; filename="'.$name.'"');
    readfile($filename);

//将文件内容读取出来并直接输出，以便下载
    readfile($filename);
}