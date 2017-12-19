<?php
/**
 * Created by PhpStorm.
 * User: yangzc
 * Date: 2017/12/19
 * Time: 10:51
 * 公用数组函数
 */

/**
 * @param $array
 * @param $val
 * @return mixed
 * 删除数组制定的val
 */
function array_remove($array,$val){
    foreach ($array as $k=>$v){
        if($v==$val){
            unset($array[$k]);
            break;
        }
    }
    return $array;
}

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