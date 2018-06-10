@extends('web.layout.app')

@section('title')
    {{trans('message.title')}}
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
@endsection

@section('content')
    <div class="message">
        <div class="ui container main-content">
            <div class="ui stackable grid">
                <div class="twelve wide column">
                    <div class="ui segment">
                        <div class="ui container basic segment content-segment">
                            <textarea name="content" id="content" style="display: none;"></textarea>
                            @if($message == 1)
                                @guest
                                <div style="margin-top: 1em;">
                                    <a href="{{route('login')}}" style="color: #00b5ad;">
                                        ({{trans('auth.login')}})
                                    </a>
                                    {{trans('message.add_message')}}
                                </div>
                            @else
                                <div class="ui mini error message hidden error-message form-error"></div>
                                <button id="sub-btn" class="ui teal button comment-btn">
                                    {{trans('message.add_message')}}
                                </button>
                                @endguest
                                @else
                                    <div class="ui mini error visible message error-message">
                                        {{trans('message.message_closed')}}
                                    </div>
                                @endif
                                {{csrf_field()}}

                                <div class="ui divided items message-list"></div>
                                <input style="display: none;" type="button" class="ui fluid basic button"
                                       id="message-btn" value="{{trans('common.show_more')}}"/>
                        </div>
                    </div>
                </div>
                <div class="four wide column">
                    @include('web.common.tags_news')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('layui/layui.all.js')}}"></script>

    <script type="text/javascript">
        var page = 1;

        layui.use('layedit', function () {
            var layedit = layui.layedit;
            layedit.build('content', {
                tool: ['left', 'center', 'right', '|', 'face'],
                height: 100
            });
        });

        layui.use('layer', function () {
            var layer = layui.layer;
        });

        $('#sub-btn').click(function () {
            var $btn = $(this);
            var layedit = layui.layedit;
            var data = {
                "_token": "{{csrf_token()}}",
                "content": layedit.getContent(1)
            };
            $.ajax({
                type: "POST",
                url: "{{route('message.store')}}",
                data: data,
                datatype: "json",
                success: function (data) {
                    if (data.code == 1) {
                        layer.msg(data.message, {
                            time: 1000
                        }, function () {
                            window.location.reload();
                        });
                    } else {
                        $('.form-error').removeClass('hidden').text(data.message.content)
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('.form-error').removeClass('hidden').text(errorThrown);
                }
            });
        });

        $("#message-btn").click(function () {
            getMessages(page + 1);
            page = page + 1;
            var $btn = $("#message-btn");
            $btn.button('loading');
        });

        function getMessages(page) {
            var data = {
                "_token": "{{csrf_token()}}",
                "page": page
            };

            $.ajax({
                type: "POST",
                url: "{{route('message.list')}}",
                data: data,
                datatype: "json",
                success: function (data) {
                    var html = '';
                    var info = data.data.data;
                    for (var i = 0; i < info.length; i++) {
                        html += '<div class="item">' +
                            '<div class="">' +
                            '<img class="ui circular mini image" src="' + info[i]['user']['avatar'] + '">' +
                            '</div>' +
                            '<div style="padding-left: 1em;" class="content">' +
                            '<span class="header">' + info[i]['user']['name'] + '</span>  (' +
                            info[i]['created_at'] + ')' +
                            '<div class="description">' + info[i]['content'] +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }

                    $('.message-list').append(html);
                    page = data.data.current_page;

                    if (page == data.data.last_page) {
                        $("#message-btn").hide();
                    } else {
                        $("#message-btn").show();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("{{trans('common.system_exception')}}");
                }
            });
        }

        getMessages(page);
    </script>
@endsection
