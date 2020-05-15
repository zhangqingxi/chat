<script>

    let uid = "{{$uid ?? 0}}";

    getUserInfo({uid: uid}, function (user) {

        if(!uid)
            window.localStorage.setItem('user_id', user['id']);

        $('.user-avatar').attr('src', user['avatar']);

        $('.user-sex').text(user['sex']);

        if(user['sex'] === '男'){

            $('.user-sex-img').attr('src', '{{asset('static/img/boy.png')}}')

        }else{

            $('.user-sex-img').attr('src', '{{asset('static/img/girl.png')}}')

        }

        $('.user-signature').text(user['signature']);

        $('.user-nickname').text(user['nickname'] ? user['nickname'] : user['username']);

        $('.user-chat_no').text(user['chat_no']);

    });

</script>

<script src="{{asset('static/js/socket.js')}}"></script>
