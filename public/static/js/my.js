//api地址
const apiUrl = 'https://chat.zhangqingxi.cn/api';

$(function () {

    //注册用户
    $('.register').unbind('click').bind('click', function () {
        let username = $('input[name=username]').val(),
            password = $('input[name=password]').val(),
            rePassword = $('input[name=re-password]').val();

        if(username === '' || username.trim() === ''){

            wcPop({content: '账号不能为空！', time:1, skin:'toast', icon: "info"});

            return;

        }else if(password === '' || password.trim() === ''){

            wcPop({ content: '密码不能为空！', time:1, skin:'toast', icon: "info"});

            return;

        }else if(password !== rePassword){

            wcPop({ content: '两次输入的密码不一致！', time:1, skin:'toast', icon: "info"});

            return;

        }

        let url = apiUrl + '/register',
            data = {username:username, password:password, re_password:rePassword},
            method = 'POST';

        ajax(url,method,JSON.stringify(data), function (res) {

            if(res.code === 0){

                wcPop({ content: res.message, time:1, skin:'toast', icon: "success", end:function () {

                        localStorage.setItem('user_access_token', res.data['token']);

                        location.href = '/';

                    }

                });

            }else{

                wcPop({ content: res.message, time:1, skin:'toast', icon: "info"});

            }

        },function (e) {

            console.log(JSON.stringify(e))

        } )

    });

    //用户登陆
    $('.login').unbind('click').bind('click', function () {
        let username = $('input[name=username]').val(),
            password = $('input[name=password]').val();

        if(username === '' || username.trim() === ''){

            wcPop({content: '账号不能为空！', time:1, skin:'toast', icon: "info"});

            return;

        }else if(password === '' || password.trim() === ''){

            wcPop({ content: '密码不能为空！', time:1, skin:'toast', icon: "info"});

            return;

        }

        let url = apiUrl + '/login',
            data = {username:username, password:password},
            method = 'POST';

        ajax(url,method,JSON.stringify(data), function (res) {

            if(res.code === 0){

                wcPop({ content: res.message, time:1, skin:'toast', icon: "success", end:function () {

                        localStorage.setItem('user_access_token', res.data['token']);

                        location.href = '/';

                    }

                });

            }else{

                wcPop({ content: res.message, time:1, skin:'toast', icon: "info"});

            }

        },function (e) {

            console.log(JSON.stringify(e))

        } )

    });

    //更新用户信息
    $('.user-info-item ').unbind('click').bind('click', function () {

        let field = $(this).data('field'),
            title,
            inputHtml = $('#J__popupTmpl-input'),
            value = $(this).find('.val').text();

        switch (field) {

            case 'chat_no':

                title = '微聊号';

                inputHtml.find('input').attr('value', value);

                break;

            case 'nickname':

                title = '昵称';

                inputHtml.find('input').attr('value', value);

                break;

            case 'signature':

                title = '个性签名';

                inputHtml.find('input').attr('value', value);

                break;

            case 'sex':

                break;

        }

        if(field === 'sex'){

            let sexIdx = wcPop({

                id: 'sexChoose',

                skin: 'androidSheet',

                title: '设置性别',

                shadeClose: true,

                btns: [
                    {

                        text: '<span>男</span>',

                        style: 'line-height: 50px; ' + (value === '男' ? 'color: red' : ''),

                        onTap() {

                            value = '男';

                            updateUser({field:field,value:value}, function (){

                                $('.user-'+field).text(value);

                                wcPop.close(sexIdx);

                            });

                        }

                    },
                    {

                        text: '<span>女</span>',

                        style: 'line-height: 50px; ' + (value === '女' ? 'color: red' : ''),

                        onTap() {

                            value = '女';

                            updateUser({field:field,value:value}, function (){

                                $('.user-'+field).text(value);

                                wcPop.close(sexIdx);

                            });

                        }

                    },

                ]

            });

        }else{

            confirmPopup(title, inputHtml.html(), function (val, index) {

                value = val;

                updateUser({field:field,value:value}, function (){

                    $('.user-'+field).text(value);

                    wcPop.close(index);

                });

            });

        }

    });

    //上传用户头像
    $('.chooseImg').unbind('change').bind('change', function () {
        let file = $('#avatar')[0].files[0],
            reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function (e) {

            let value = e.target['result'];

            $('.user-avatar').attr('src', value);

            updateUser({field: 'avatar', value: value});

        }

    });

    //搜索数据
    $('.search').unbind('keyup').bind('keyup', function (event) {

        let value = $(this).val(), search_result_element = $('.search-result');

        if(value === '' || value.trim() === ''){

            search_result_element.find('.contact, .group_chat').css('display', 'none');

            return;

        }

        search_result_element.find('.find-user').css('display', 'block').find('.value').text(value);

        if(event.keyCode === 13){//回车键

            search(value, function (res) {

                //遍历好友数据

                //编辑群聊数据

            });

        }

    });

    //搜索用户
    $('.find-user').unbind('click').bind('click', function () {

        let value = $(this).find('.value').text();

        if(value === '' || value.trim() === ''){

            return;

        }

        search(value, function (res) {

            if(res.data['uid'] === ''){

                wcPop({content: '用户不存在', time: 1, skin:'toast', icon: "info"});

                return;

            }

            location.href = '/user/find/' + res.data['uid'];

        });

    });



});

/**
 * 搜索数据
 * @param value 关键词
 * @param callback 成功回调
 */
let search = function(value, callback){

    let url = apiUrl + '/search';

    ajax(url, 'GET',{keyword:value}, function (res) {

        if(res.code === 0){

            callback && callback(res);

        }else{

            wcPop({content: res.message, time: 1, skin:'toast', icon: "info"});

        }

    }, function (e) {

        console.log(JSON.stringify(e))

    })

};

/**
 * 获取用户信息
 * @param data 参数
 * @param callback 回调
 */
let getUserInfo = function (data, callback) {

    let url = apiUrl + '/user';

    ajax(url, 'GET', data, function (res) {

        if(res.code === 0){

            callback(res.data['user']);

        }else {

            wcPop({content: res.message, time: 1, skin:'toast', icon: "info"});

        }

    },function (e) {

        console.log(JSON.stringify(e))

    })

};

/**
 * 更新用户
 * @param data 数据
 * @param callback
 */
let updateUser = function(data, callback){

    let url = apiUrl + '/user/update';

    //请求ajax
    ajax(url, 'PUT', JSON.stringify(data), function (res) {

        if(res.code === 0){

            wcPop({ content: res.message, time:1, skin:'toast', icon: "success"});

            localStorage.setItem('user_' + data['field'], data['value']);

            callback && callback();

        }else{

            wcPop({ content: res.message, time:1, skin:'toast', icon: "info"});

        }

    },function (e) {

        console.log(JSON.stringify(e))

    })

};

/**
 * 封装ajax
 * @param url 地址
 * @param method 方法
 * @param data 数据
 * @param successCallback 成功回调
 * @param errorCallback 失败回调
 * @param showLoading 是否loading
 */
let ajax = function (url, method, data, successCallback, errorCallback, showLoading = true) {

    let accessToken = localStorage.getItem('user_access_token');

    if(accessToken){

        $.ajaxSetup({

            headers:{

                'Authorization': 'Bearer ' + accessToken

            }

        });

    }

    $.ajaxSetup({

        headers:{

            'Accept': 'application/json'

        }

    });

    let ajaxIndex = '';

    $.ajax({

        url:url,

        method:method,

        dataType:'json',

        contentType : "application/json; charset=utf-8",

        data: data,

        beforeSend:function(){

            if(showLoading)
                ajaxIndex = wcPop({id: 'onRequest', skin:'toast', content: '请求接口...', shadeClose:false, icon: 'loading'});

        },
        complete:function(){

            if(showLoading)
                wcPop.close(ajaxIndex);

        },

        success:function (result) {

            //token失效
            if(result.code === 20002){

                wcPop({ content: result.message, time:1, skin:'toast', icon: "info", end:function () {

                        localStorage.removeItem('user_access_token');

                        location.href = '/login';

                    }

                });

            }else {

                successCallback(result);

            }

        },

        error:function (e) {

            errorCallback(e);

        }

    })

};

/**
 * 弹窗
 * @param title 标题
 * @param content 内容
 * @param callback 回调
 */
let confirmPopup = function (title,content,callback) {
    let confirmPopupIndex = wcPop({
        id: 'confirmPopup',
        skin: 'ios',
        title: title,
        content: content,
        style: 'background-color: #fff; max-width: 320px; width: 95%;',
        shadeClose: false,
        btns: [
            {
                text: '提交',
                style: 'background:#ffba00;color:#fff;font-size:18px;',
                onTap() {
                    let value = $("#confirmPopup input").val();
                    callback(value, confirmPopupIndex);
                }
            }
        ]
    });
};

