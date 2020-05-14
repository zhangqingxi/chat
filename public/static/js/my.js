const apiUrl = 'https://chat.zhangqingxi.cn/api';

$(function () {

    //注册用户
    $('.register').unbind('click').bind('click', function (event) {
        let username = $('input[name=username]').val(),
            password = $('input[name=password]').val(),
            rePassword = $('input[name=re-password]').val();

        if(username === '' || username.trim() === ''){

            wcPop({content: '账号不能为空！', time:1});

        }else if(password === '' || password.trim() === ''){

            wcPop({ content: '密码不能为空！', time:1});

        }else if(password !== rePassword){

            wcPop({ content: '两次输入的密码不一致！', time:1});

        }

        let url = apiUrl + '/register',
            data = {username:username, password:password, re_password:rePassword},
            method = 'POST';

        ajax(url,method,data, function (res) {

            if(res.code === 0){

                wcPop({ content: res.message, time:1, end:function () {

                        localStorage.setItem('user_access_token', res.data.token);

                        location.href = '/';

                    }

                });

            }else{

                wcPop({ content: res.message, time:1});

            }

        },function (e) {

            console.log(JSON.stringify(e))

        } )

    });

    //用户登陆
    $('.login').unbind('click').bind('click', function (event) {
        let username = $('input[name=username]').val(),
            password = $('input[name=password]').val();

        if(username === '' || username.trim() === ''){

            wcPop({content: '账号不能为空！', time:1});

        }else if(password === '' || password.trim() === ''){

            wcPop({ content: '密码不能为空！', time:1});

        }

        let url = apiUrl + '/login',
            data = {username:username, password:password},
            method = 'POST';

        ajax(url,method,data, function (res) {

            if(res.code === 0){

                wcPop({ content: res.message, time:1, end:function () {

                        localStorage.setItem('user_access_token', res.data['token']);

                        location.href = '/';

                    }

                });

            }else{

                wcPop({ content: res.message, time:1});

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
            value = $(this).find('.val').text(),
            url = apiUrl + '/user/update';

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

                        onTap(e) {

                            value = '男';

                            updateUser(url, {field:field,value:value}, function (){

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

                            updateUser(url, {field:field,value:value}, function (){

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

                updateUser(url, {field:field,value:value}, function (){

                    $('.user-'+field).text(value);

                    wcPop.close(index);

                });

            });

        }

    });

    //上传用户头像
    $('.chooseImg').unbind('change').bind('change', function (event) {
        let url = apiUrl + '/user/update',
            file = $('#avatar')[0].files[0],
            reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function (e) {

            let image = e.target['result'];

            $('.user-avatar').attr('src', image);

            updateUser(url, {field: 'avatar', value: image});

        }

    })

});

let updateUser = function(url, data, callback){

    //请求ajax
    ajax(url, 'PUT', data, function (res) {

        wcPop({ content: res.message, time:1});

        if(res.code === 0){

            localStorage.setItem('user_' + data['field'], data['value']);

            callback && callback();

        }

    },function () {

        console.log(JSON.stringify(e))

    })

};

//封装ajax
let ajax = function (url, method, data, successCallback, errorCallback) {

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

        data: data ? JSON.stringify(data) : '',

        beforeSend:function(){

            ajaxIndex = wcPop({id: 'onRequest', skin:'toast', content: '请求接口...', shadeClose:false, icon: 'loading'});

        },
        complete:function(){

            wcPop.close(ajaxIndex);

        },

        success:function (result) {

            //token失效
            if(result.code === 20002){

                wcPop({ content: result.message, time:1, end:function () {

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

let getUserInfo = function (callback) {

    let url = apiUrl + '/user';

    ajax(url, 'GET', '', function (res) {

        if(res.code === 0){

            localStorage.setItem('user_id', res.data['user']['id']);

            callback(res.data['user']);

        }else {

            wcPop({ content: res.message, time:1});

        }

    },function (e) {

        console.log(JOSN.stringify(e))

    })

};

//弹窗
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

