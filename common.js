/**
 * Created by yangzc on 2017/7/28.
 * 公用js库2018
 */

/**
 * Created by yangzc
 * 获取 name值相同的 input 的值 返回 arr
 * @param $name
 * @returns {Array}
 */
function eq_input_val($name){
    var obj = $("input[name="+$name+"]");
    var arr =[];
    for(var i=0;i<obj.length;i++){
        var value = $(obj[i]).val();
        arr.push(value);
    }
    return arr;
}

/*
 * @param num
 * @returns {*}
 * 判断是否是正整数
 */
function is_int(num){
    //判断是否是数字
    var r = /^\+?[1-9][0-9]*$/;　　//正整数
    if(!r.test(num)){
        return false;
    }else{
        return num;
    }
}


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

/**
 * ajax 上传文件
 *  var formData = new FormData();
 *  var name = $("input").val();
 *  formData.append("file",$("#upload")[0].files[0]);
 *  formData.append("name",name);
 *  name input 的id 和上传文件的name 值
 *  param 额外的参数 默认post   json格式 如:{a:1,b:2}
 */
function ajax_upload_files(Url,name,param,func,load){
    var formData = new FormData();
    formData.append(name,$("#"+name)[0].files[0]);
    for(var k in param){
        formData.append(k,param[k]);
    }
    $.ajax({
        url : Url,
        type : 'POST',
        data : formData,
        // 告诉jQuery不要去处理发送的数据
        processData : false,
        // 告诉jQuery不要去设置Content-Type请求头
        contentType : false,
        beforeSend:load,//正在进行，请稍候
        success : func,
        error : function(responseStr) {
            return msg('请求失败~',201);
        }
    });
}

