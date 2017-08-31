/**
 * Created by yangzc on 2017/7/28.
 * 公用js库
 */
/**
 * 验证ajax 返回参数
 * @param $data
 */
function check_data($data){
    if($data.errcode!=200){
        return layer.msg($data.msg);
    }else{
        return $data.data;
    }
}

/***
 * jq ajaxpost
 * @param url
 * @param data
 * @param call_function
 */
function ajax_post(url,data,call_function){
    $.ajax({
        url:url,
        type:'post',
        data:data,
        dataType:'json',
        success:call_function,
        error:function(){
            return layer.msg('请求失败');
        }
    });
}
