$(function () {

    const ws = 'wss://chat.zhangqingxi.cn/ws';

    let webSocket = new WebSocket(ws);

    webSocket.onopen = function () {

        console.log("连接成功");

        webSocket.send(JSON.stringify({type:'init', 'data':{'user_id': window.localStorage.getItem('user_id')}}))

    };

    //服务端发送消息的触发事件
    webSocket.onmessage = function (event) {

        let data = $.parseJSON(event.data);

        console.log(data);
        if(data.type === 'message'){

        }else if(data.type === 'chat'){

        }else if(data.type === 'init'){

            //用户信息
            let user = data.data['user'];



        }

    };
    //服务端关闭的触发事件
    webSocket.onclose = function (event) {
        console.log("服务器已关闭");
    };


});
