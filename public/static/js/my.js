//url地址
const baseUrl = 'https://chat.zhangqingxi.cn';

//api地址
const apiUrl = baseUrl + '/api';

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

    //添加用户到通讯录
    $('.add-contact').unbind('click').bind('click', function (){

        let chat_no = $('.user-chat_no').text();

        let url = apiUrl + '/friend/add';

        ajax(url, 'POST', JSON.stringify({chat_no: chat_no}), function (res) {

            if(res.code === 0){

                wcPop({content: res.message, time: 1, skin:'toast', icon: "success"});

            }else{

                wcPop({content: res.message, time: 1, skin:'toast', icon: "info"});

            }

        }, function (e) {

            console.log(JSON.stringify(e));

        });

    });

    //修改好友备注
    $('.user_remarks').unbind('click').bind('click', function (){

        let title = '修改备注',
            inputHtml = $('#J__popupTmpl-input'),
            value = $(this).text(),
            friend_id = $('.friend_id').val();

        inputHtml.find('input').attr('value', value);

        confirmPopup(title, inputHtml.html(), function (val, index) {

            value = val;

            let url = apiUrl + '/friend/remarks';

            ajax(url, 'PUT', JSON.stringify({friend_id: friend_id, remarks: value}), function (res) {

                if(res.code === 0){

                    wcPop({ content: res.message, time:1, skin:'toast', icon: "success", end: function () {

                            $('.user_remarks').text(value);

                            wcPop.close(index);

                        }});

                }else{

                    wcPop({ content: res.message, time:1, skin:'toast', icon: "info"});

                }

            }, function (e) {

                console.log(JSON.stringify(e));

            });

        });

    });

});

/**
 * 好友申请列表
 */
let newFriendsList = function(){

    let url = apiUrl + '/friend/new';

    ajax(url, 'GET', '', function (res) {

        if(res.code === 0){

            $.each(res.data['lists'], function (k, v) {

                let html =  '<div class="row flexbox flex-alignc wc__material-cell">' +

                            '<img class="uimg" alt="" src="'+v['friend']['avatar']+'"/>' +

                            '<span class="name flex1">'+(v['friend']['remarks'] ? v['friend']['remarks'] : (v['friend']['nickname'] ? v['friend']['nickname'] : v['friend']['username']))+'</span>' +

                            '<div class="friend-span">';

                if(v['is_friend_count'] === 1){

                    html += '<span class="friend-passed">已添加</span>';

                }else{

                    html += '<span class="friend-pass" data-id="'+v['id']+'">通过</span>&nbsp;<span class="friend-refuse" data-id="'+v['id']+'">拒绝</span>';

                }

                html += '</div></div>';

                $('.new-friends').append(html);

                //通过
                $('.new-friends .friend-pass').unbind('click').bind('click', function () {

                    let id = $(this).data('id'), _self = $(this).parent();

                    validateFriend(id, 0, _self);

                });

                //拒绝
                $('.new-friends .friend-refuse').unbind('click').bind('click', function () {

                    let id = $(this).data('id'), _self = $(this).parent();

                    validateFriend(id, 1, _self);

                });

            })

        }else{

            wcPop({content: res.message, time: 1, skin:'toast', icon: "info"});

        }

    }, function (e) {

        console.log(JSON.stringify(e));

    })

};

/**
 * 验证好友
 * @param id 好友请求ID
 * @param type 类型 0通过 1拒绝
 * @param _self 元素节点
 */
let validateFriend = function(id, type = 0,_self){

    let url = apiUrl + '/friend/validate';

    ajax(url, 'POST', JSON.stringify({id:id, type: type}), function (res) {

        if(res.code === 0) {

            wcPop({

                content: res.message, time: 1, skin: 'toast', icon: "success", end: function () {

                    _self.html('<span class="friend-passed">已添加</span>');

                }

            });

        }else if(res.code === 20010){

            wcPop({

                content: res.message, time: 1, skin: 'toast', icon: "success", end: function () {

                    _self.parent().remove();

                }

            });

        }else{

            wcPop({content: res.message, time: 1, skin:'toast', icon: "info"});

        }

    }, function (e) {

        console.log(JSON.stringify(e));

    })

};

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

    console.log(11);return;

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
 * 通讯录列表
 * @param data
 */
let contacts = function(data){

    $.each(data, function (k, v) {

        let html =  '<li id="'+k+'">' +

                    '<h2 class="initial wc__borT">'+k+'</h2>';

        $.each(v, function (key, value) {

            html += '<div class="row flexbox flex-alignc wc__material-cell friend_item" data-id="'+value['friend_id']+'">' +

                    '<img class="uimg" alt="" src="'+value['avatar']+'"/>' +

                    '<span class="name flex1">'+value['nickname']+'</span>' +

                    '</div>';

        });

        html +=     '</li>';

        $('.contact-list').append(html);

        $('.friend_item').unbind('click').bind('click', function (res) {

            location.href = '/friend/detail/' + $(this).data('id')

        })

    });

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
 * 聊天
 * @param uid 好友ID
 * @param content 内容
 * @param type 类型
 */
let chat = function(uid, content, type = 0){

    let url = apiUrl + '/friend/chat';

    ajax(url, 'POST', JSON.stringify({uid:uid, content:content, type:type}), function (res) {

        if(res.code !== 0){

            wcPop({ content: res.message, time:1, skin:'toast', icon: "info"});

        }

    }, function (e) {

        console.log(JSON.stringify(e))

    }, false);

};

/**
 * 聊天列表
 * @param data
 */
let chats = function(data){

    $.each(data, function (k, v) {

        let html = createChatItem(v['friend_info']['id'], v['friend_info']['avatar'], v['friend_info']['remarks'], v['content'], v['time'], v['unread_counts'], v['content_type']);

        $('.chat-list').append(html);

        $('.chat-item').unbind('click').bind('click', function () {

            location.href = 'chat/' + $(this).data('id');

        })

    })

};

let chatMessage = function(uid, page){

    let url = apiUrl + '/friend/messages';

    ajax(url, 'GET', {uid: uid, page: page}, function (res) {

        if(res.code === 0){

            $.each(res.data['messages'], function (k, v) {

                let html = '';

                if(k !== 0 && k < res.data['messages'].length - 1){

                    let dateBegin = new Date(res.data['messages'][k + 1]['created_at']),
                        dateEnd = new Date(v['created_at']),//获取当前时间
                        minutesDiff = Math.floor((dateEnd - dateBegin) / (60 * 1000));//计算出相差分钟数

                    if(minutesDiff > 5){

                        html += '<li class="time"><span>'+v['time']+'</span></li>';

                    }

                }

                //我发的
                if(v['mine']){

                    html += '<li class="me">' +

                        '<div class="content">';

                    if(v['content_type'] === 0){

                        html += '<div class="msg">' + v['content'] + '</div>';

                    }else if(v['content_type'] === 2){//图片消息

                        html += '<div class="msg">' + v['content'] + '</div>';

                    }

                    html += '</div><a class="avatar" href="javascript:void(0);"><img alt="" src="'+v['user']['avatar']+'" /></a></li>';

                }else{

                    html += '<li class="others">' +

                        '<a class="avatar" href="friend/detail/'+v['user']['id']+'"><img src="'+v['user']['avatar']+'" alt=""/></a>' +

                        '<div class="content">';

                    if(v['content_type'] === 0){

                        html += '<div class="msg">' + v['content'] + '</div>'

                    }else if(v['content_type'] === 2){//图片消息

                        html += '<div class="msg">' + v['content'] + '</div>';

                    }

                    html += '</div></li>';

                }

                $("#J__chatMsgList").prepend(html);

            });

            $(".wc__chatMsg-panel").animate({scrollTop: $("#J__chatMsgList").height()}, 0);

        } else {

            wcPop({ content: res.message, time:1, skin:'toast', icon: "info"});

        }

    }, function (e) {

        console.log(JSON.stringify(e));

    })

};

/**
 * 创建聊天元素
 * @param friend_id 好友ID
 * @param avatar 好友头像
 * @param remarks 好友备注
 * @param content 消息内容
 * @param time 发送时间
 * @param counts 未读条数
 * @param type 类型
 * @returns {string}
 */
let createChatItem = function(friend_id, avatar, remarks, content, time, counts, type){

    let html = '<li class="flexbox wc__material-cell chat-item chat-item-'+friend_id+'" data-id="'+friend_id+'">' +

        '<div class="img"><img alt="" src="'+avatar+'"/><em class="wc__badge">'+(counts > 0 ? counts : '')+'</em></div>' +

        '<div class="info flex1">' +

        '<h2 class="title">'+remarks+'</h2>';

    if(type === 0){//文本消息

        html += '<div class="desc clamp1">'+content+'</div>';

    }else if(type === 1){

        html += '<div class="desc clamp1">[语音]</div>';

    }else if(type === 2){

        html += '<div class="desc clamp1">[图片]</div>';

    }else if(type === 3){

        html += '<div class="desc clamp1">[视频]</div>';

    }

    html += '</div>' +

        '<label class="time">'+time+'</label>' +

        '</li>';

    return html;

};

/**
 * 更新聊天消息
 * @param friend_id 好友ID
 * @param avatar 好友头像
 * @param remarks 好友备注
 * @param content 消息内容
 * @param time 发送时间
 * @param counts 未读条数
 * @param type 类型
 */
let updateChat = function(friend_id, avatar, remarks, content, time, counts, type){

    //是否存在聊天列表
    if($('.chat-item-' + friend_id).length === 1){

        $('.chat-item-' + friend_id + ' .wc__badge').text(counts);

        $('.chat-item-' + friend_id + ' .clamp1').html(content);

    }else{

        //创建
        let html = createChatItem(friend_id, avatar, remarks, content, time, counts, type);

        $('.chat-list').prepend(html);

        $('.chat-item').unbind('click').bind('click', function () {

            location.href = 'chat/' + $(this).data('id');

        })

    }

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

