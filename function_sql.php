<?php
/**
 * Created by PhpStorm.
 * User: yangzc
 * Date: 2017/12/19
 * Time: 10:52
 * 公用sql函数
 */

if(!function_exists('sel_table_next_id')){
    /**
     * @param $table
     * @return bool
     * 查询某一个表的下一条增加数据的主键值
     */
    function sel_table_next_id($table){
        $sql = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES    
          WHERE TABLE_NAME='$table' ";
        $info = M()->query($sql);
        if($info){
            return $info[0]['auto_increment'];
        }else{
            return false;
        }
    }
}