<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{asset('semantic/dist/semantic.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
</head>
@yield('style')
<body>

@include('web.common.menu')

@yield('banner')

@section('content')
@show

@include('web.common.footer')

@yield('scripts')

<script>
    $('.ui.dropdown').dropdown({
        on: 'hover'
    });

    function logout() {
        $('.logoutform').submit();
    }
</script>
</body>
</html>
