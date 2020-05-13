$(function () {

    const apiUrl = 'https://chat.zhangqingxi.cn/api';

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

                        localStorage.setItem('user_id', res.data['user']['id']);

                        localStorage.setItem('user_avatar', res.data['user']['avatar'] ? res.data['user']['avatar'] : '');

                        localStorage.setItem('user_sex', res.data['user']['sex'] ? res.data['user']['sex'] : '');

                        localStorage.setItem('user_username', res.data['user']['username'] ? res.data['user']['username'] : '');

                        localStorage.setItem('user_chat_no', res.data['user']['chat_no']);

                        localStorage.setItem('user_signature', res.data['user']['signature'] ? res.data['user']['signature'] : '');

                        localStorage.setItem('user_nickname', res.data['user']['nickname'] ? res.data['user']['signature'] : '');

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

                inputHtml.find('input').val(value);

                break;

            case 'sign':

                title = '个性签名';

                inputHtml.find('input').val(value);

                break;

            case 'sex':

                break;

        }

        confirmPopup(title, inputHtml.html(), function (val, index) {

            value = val;

            //请求ajax
            ajax(url, 'PUT', {field:field, value:value}, function (res) {

                wcPop({ content: res.message, time:1});

                if(res.code === 0){

                    wcPop.close(index);

                }

            },function () {

                console.log(JSON.stringify(e))

            })

        });

    });

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

            data:JSON.stringify(data) ,

            beforeSend:function(){

                ajaxIndex = wcPop({'id': 'onRequest', 'shadeClose':false});

            },
            complete:function(){

                wcPop.close(ajaxIndex);

            },

            success:function (result) {

                successCallback(result);

            },

            error:function (e) {

                errorCallback(e);

            }

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

});
