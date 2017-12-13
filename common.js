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

/**
 * 对象转数组
 */
function object_to_array($obj){
    var arr = [];
    for(var val in $obj){
        arr.push($obj[val]);
    }
    return arr;
}
/**
 *数组转对象
 */
function array_to_object($arr){
    var object = new Object();
    for(var key in $arr){
        object[key] = $arr[key];
    }
    return object;
}


$(function(){

    //加载本地图片
    var fileList = [];
    var imageFile = document.getElementById('imageFile');// input id
    var changeImg = function(){
        var image = document.getElementById('image'); //img id
        var file = document.getElementById("imageFile").files[0];
        fileList = file;
        //imageData.append('imgFile1', file);
        var reader = new FileReader();
        reader.onload = function(){
            image.src = this.result;
        };
        reader.onerror = function(){
            alert('上传文件错误');
        };
        reader.readAsDataURL(file);
    };
    imageFile.addEventListener('change',changeImg);
})


/**
 * ajax 上传文件
 *  var formData = new FormData();
 *  var name = $("input").val();
 *  formData.append("file",$("#upload")[0].files[0]);
 *  formData.append("name",name);
 */
function ajax_upload_file(Url,formData,func){
    $.ajax({
        url : Url,
        type : 'POST',
        data : formData,
        // 告诉jQuery不要去处理发送的数据
        processData : false,
        // 告诉jQuery不要去设置Content-Type请求头
        contentType : false,
        beforeSend:function(){
            console.log("正在进行，请稍候");
        },
        success : func,
        error : function(responseStr) {
            return msg('请求失败~',201);
        }
    });
}