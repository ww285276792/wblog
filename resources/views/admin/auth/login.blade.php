<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>{{trans('auth.login')}}</title>
    <link rel="stylesheet" type="text/css" href="{{asset('semantic/dist/semantic.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <style type="text/css">
        body {
            background-image: url({{asset('static/images/adminbg.jpg')}});
            background-position: center center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        body > .grid {
            height: 100%;
        }

        .column {
            max-width: 450px;
        }
    </style>
</head>
<body>
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <form method="post" action="{{route('admin.login')}}" class="ui large loadable form">
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="email" value="{{ old('email') }}"
                               placeholder="{{trans('auth.account')}}">
                    </div>
                    @if($errors->first('email'))
                        <div class="ui visible error message">
                            {{$errors->first('email')}}
                        </div>
                    @endif
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="{{trans('auth.password')}}">
                    </div>
                    @if($errors->first('password'))
                        <div class="ui visible error message">
                            {{$errors->first('password')}}
                        </div>
                    @endif
                </div>
                <div class="field">
                    <div class="two fields">
                        <div class="field">
                            <input type="text" value="{{ old('captcha')}}"
                                   name="captcha" placeholder="{{trans('auth.captcha')}}">
                        </div>
                        <div class="field">
                            <img style="cursor: pointer" class="captcha" src="{{$src}}" width="100%" height="38">
                        </div>
                    </div>
                    @if($errors->first('captcha'))
                        <div class="ui visible error message">
                            {{$errors->first('captcha')}}
                        </div>
                    @endif
                </div>
                <button class="ui fluid large teal button" type="submit">{{trans('auth.login')}}</button>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>

<script>
    $('.captcha').click(function () {
        $.get("{{route('get_captcha')}}", function (data, status) {
            $('.captcha').attr('src', data);
        });
    })
    $('form.loadable button').on('click', function () {
        return $(this).closest('form').addClass('loading');
    });
</script>
</body>
</html>
