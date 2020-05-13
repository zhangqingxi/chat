<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8" />

    <title>微聊</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="apple-touch-fullscreen" content="yes">

    <meta http-equiv="Access-Control-Allow-Origin" content="*">

    <link rel="stylesheet" href="{{asset('static/css/reset.css')}}" />

    <link rel="stylesheet" href="{{asset('static/css/animate.css')}}" />

    <link rel="stylesheet" href="{{asset('static/css/swiper-3.4.1.min.css')}}" />

    <link rel="stylesheet" href="{{asset('static/css/layout.css')}}" />

    <script src="{{asset('static/js/jquery-1.9.1.min.js')}}"></script>

    <script src="{{asset('static/js/zepto.min.js')}}"></script>

    <script src="{{asset('static/js/fontSize.js')}}"></script>

    <script src="{{asset('static/js/swiper-3.4.1.min.js')}}"></script>

    <script src="{{asset('static/js/wcPop/wcPop.js')}}"></script>

    <script src="{{asset('static/js/my.js')}}"></script>

</head>

<body>

@include('chat.common.popup')

@yield('content')

</body>

</html>
