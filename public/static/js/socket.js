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

            return ;

        }

        console.log("ws连接关闭!" + JSON.stringify(e));

    };

    webSocket.onerror = function (e) {

        console.log("ws连接错误!" + JSON.stringify(e));

    };

    webSocket.onopen = function (e) {

        webSocket.send(JSON.stringify({type:'init', 'data':{'user_id': window.localStorage.getItem('user_id')}}));

        console.log("ws连接成功!" + JSON.stringify(e));

    };

    webSocket.onmessage = function (event) {    //如果获取到消息，心跳检测重置

        console.log("ws收到消息!" + event.data);

    };

};

// 监听窗口关闭事件，当窗口关闭时，主动去关闭websocket连接，防止连接还没断开就关闭窗口，server端会抛异常。
window.onbeforeunload = function() {

    webSocket.close();

};

createWebSocket(wsUrl);   //连接ws


