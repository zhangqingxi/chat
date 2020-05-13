<script>

    accessToken = localStorage.getItem('user_access_token');

    if(!accessToken){

        wcPop({ content: '登陆已失效，请重新登陆', time:1, end:function () {

                location.href = '/login';

            }

        });

    }

    $('.user-avatar').attr('src', localStorage.getItem('user_avatar'));

    $('.user-sex').attr('src', localStorage.getItem('user_sex'));

    $('.user-signature').attr('src', localStorage.getItem('user_signature'));

    $('.user-nickname').text(localStorage.getItem('user_nickname') ? localStorage.getItem('user_nickname') : localStorage.getItem('user_username'));

    $('.user-chat-no').text(localStorage.getItem('user_chat_no'));


</script>

<script src="{{asset('static/js/socket.js')}}"></script>
