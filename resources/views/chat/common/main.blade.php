<script>

    getUserInfo(function (user) {

        window.localStorage.setItem('user_id', user['id']);

        $('.user-avatar').attr('src', user['avatar']);

        $('.user-sex').text(user['sex']);

        $('.user-signature').text(user['signature']);

        $('.user-nickname').text(user['nickname'] ? user['nickname'] : user['username']);

        $('.user-chat_no').text(user['chat_no']);

    });

</script>

<script src="{{asset('static/js/socket.js')}}"></script>
