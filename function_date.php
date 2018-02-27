<?php
/**
 * Created by PhpStorm.
 * User: yangzc
 * Date: 2017/12/19
 * Time: 10:51
 * 公用日期函数
 */

/**
 * @return array
 * 返回当天的最大和最小时间戳
 */
function today_begin_end($time){
    $time = $time?$time:time();

    $begin =date('Y-m-d', $time);
    $end = date('Y-m-d',$time)." 23:59:59";

    return [strtotime($begin),strtotime($end)];
}

/**
 * @return array
 * 返回当月第一天和最后一天
 */
function month_begin_end($time){
    $time = $time?$time:time();
    $begin =date('Y-m-01', strtotime(date("Y-m-d",$time)));
    $end = date('Y-m-d', strtotime("$begin +1 month -1 day"));

    return [strtotime($begin),strtotime($end)];
}
/**
 * 返回传入时间戳 当周的第一天和最后一天
 */
function week_begin_end($time = ''){

    $time = $time?$time:time();

    $w =  date('w',$time);
    if($w==0){
        $time = $time-24*3600;
    }
    $start = date("Y-m-d H:i:s",mktime(0,0,0,date("m",$time),date("d",$time)-date("w",$time)+1,date("Y",$time)));
    $end = date("Y-m-d H:i:s",mktime(23,59,59,date("m",$time),date("d",$time)-date("w",$time)+7,date("Y",$time)));
    return [strtotime($start),strtotime($end)];
}

/**
 * @param $time
 * @return bool|mixed
 * 根据时间戳得到星期
 */
function weekday($time)
{
    if(is_numeric($time))
    {
        $weekday = array('星期天','星期一','星期二','星期三','星期四','星期五','星期六');
        return $weekday[date('w', $time)];
    }
    return false;
}