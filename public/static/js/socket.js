const wsUrl = 'wss://chat.zhangqingxi.cn/ws';

let webSocket = null;  //避免ws重复连接

let createWebSocket = function(url) {

    try{

        if('WebSocket' in window){

            webSocket = new WebSocket(url);

        }

        initEventHandle();

    }catch(e){

       console.log(JSON.stringify(e))

    }

};

let initEventHandle = function () {

    webSocket.onclose = function (e) {

        console.log('ws断开连接: ' + e.code + ' ' + e.reason + ' ' + e.wasClean);

        if(e.code === 1006 || e.code === 1005){

            createWebSocket(wsUrl);

        }

    };

    webSocket.onerror = function (e) {

        console.log("ws连接错误!" + JSON.stringify(e));

    };

    webSocket.onopen = function () {

        webSocket.send(JSON.stringify({type:'init', 'data':{'user_id': window.localStorage.getItem('user_id')}}));

        console.log("ws连接成功!");

    };

    webSocket.onmessage = function (event) {    //如果获取到消息，心跳检测重置

        let data = $.parseJSON(event.data);

        console.log("ws收到消息：" + data.message, '内容：' + JSON.stringify(data.data));

        if(data.type === 'add_friend'){

            let audio = new Audio(baseUrl + '/static/music/ding.mp3');

            audio.play().then(r => function (e) {

                console.log(JSON.stringify(e));

            });

        }else if(data.type === 'init'){

            //首页
            if(data.data['total_unread_count'] > 0){

                $('.total_unread .ff-ar').html('(<span class="count">'+data.data['total_unread_count']+'</span>)');

                $('.wechat-pagination li:eq(0) i').html('<em class="wc__badge">'+data.data['total_unread_count']+'</em>');

            }else{

                $('.total_unread .ff-ar').html('');

                $('.wechat-pagination li:eq(0) i').html('');

            }

            chats(data.data['chats']);

            //通讯录
            contacts(data.data['contacts']);

        }else if(data.type === 'friend_chat'){

            let audio = new Audio(baseUrl + '/static/music/ding.mp3');

            audio.play().then(r => function (e) {

                console.log(JSON.stringify(e));

            });

            //首页
            let count = $('.total_unread .ff-ar .count').text();

            count = count ? parseInt(count) : 0;

            count += 1;

            $('.total_unread .ff-ar').html('(<span class="count">'+count+'</span>)');

            $('.wechat-pagination li:eq(0) i').html('<em class="wc__badge">'+count+'</em>');

            updateChat(data.data['friend_id'], data.data['avatar'], data.data['remarks'], data.data['content'], data.data['time'], data.data['counts'], data.data['type']);

            //聊天页
            let html = '<li class="others">' +

                        '<a class="avatar" href="friend/detail/'+data.data['friend_id']+'"><img src="'+data.data['avatar']+'" alt=""/></a>' +

                        '<div class="content">';

            if(data.data['type'] === 0){

                html += '<div class="msg">' + data.data['content'] + '</div>'

            }

            html += '</div></li>';

            let item = $("#J__chatMsgList");

            item.append(html);

            $(".wc__chatMsg-panel").animate({scrollTop: item.height()}, 0);

        }

    };

};

// 监听窗口关闭事件，当窗口关闭时，主动去关闭websocket连接，防止连接还没断开就关闭窗口，server端会抛异常。
window.onbeforeunload = function() {

    webSocket.close();

};

createWebSocket(wsUrl);   //连接ws


