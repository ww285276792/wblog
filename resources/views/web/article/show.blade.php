@extends('web.layout.app')

@section('title')
    {{$article->title}}
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <style>
        img {
            max-width: 100% !important;
        }
    </style>
@endsection

@section('content')
    <div class="article-detail">
        <div class="ui container main-content">
            <div class="ui stackable grid">
                <div class="twelve wide column">
                    <div class="ui segment">
                        <h4 class="ui center aligned header article-header">{{$article->title}}</h4>
                        <p class="ui center aligned text container date-segment">
                            <i class="fa fa-clock-o"></i>
                            <span>{{$article->created_at->format('Y-m-d')}}</span>&nbsp;
                            <i class="fa fa-eye"></i>
                            <span>{{$article->view_account}}</span>&nbsp;
                            <i class="fa fa-comment-o"></i>
                            <span>{{$article->comments_count}}</span>
                        </p>
                        <div class="ui basic segment desc-segment">
                            <blockquote style="" class="layui-elem-quote">
                                {{$article->description}}
                            </blockquote>
                            <div class="ui divider"></div>
                        </div>
                        <div class="ui container basic segment content-segment">
                            <p>{!! $article->content !!}</p>
                            @if($article->url)
                                <div class="url">
                                    {{trans('article.table.url')}}：
                                    <a target="_blank" href="{{$article->url}}">{{$article->url}}</a>
                                </div>
                            @endif
                            <div class="tag">
                                @forelse ($article->tags as $tag)
                                    <a href="{{route('article.index',['tag'=>$tag->name])}}"
                                       class="ui {{$tag->color}} label">
                                        {{$tag->name}}
                                    </a>
                                @empty
                                @endforelse
                            </div>
                            <textarea id="content" style="display: none;"></textarea>

                            @if($comment == 1)
                                @guest
                                <div style="margin-top: 1em;">
                                    <a href="{{route('login')}}" style="color: #00b5ad;">
                                        ({{trans('auth.login')}})
                                    </a>
                                    {{trans('article.add_comment')}}
                                </div>
                            @else
                                <div class="ui mini error message hidden error-message form-error"></div>
                                <button id="sub-btn" class="ui teal button comment-btn">
                                    {{trans('article.add_comment')}}
                                </button>
                                @endguest
                                @else
                                    <div class="ui mini error visible message error-message">
                                        {{trans('article.comment_closed')}}
                                    </div>
                                @endif

                                <div class="comment-list"></div>

                                <input style="display: none;margin-top: 1em;" type="button"
                                       class="ui fluid basic button" id="comment-btn"
                                       value="{{trans('common.show_more')}}"/>
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

        $('#sub-btn').click(function () {
            var $btn = $(this);
            var layedit = layui.layedit;
            var data = {
                "_token": "{{csrf_token()}}",
                "content": layedit.getContent(1)
            };
            $.ajax({
                type: "POST",
                url: "{{route('comment.store',['id'=>$article->id])}}",
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

        $("#comment-btn").click(function () {
            getComments(page + 1);
            page = page + 1;
            var $btn = $("#comment-btn");
        });

        function getComments(page) {
            var data = {
                "_token": "{{csrf_token()}}",
                "page": page
            };

            $.ajax({
                type: "POST",
                url: "{{route('comment.index',['id'=>$article->id])}}",
                data: data,
                datatype: "json",
                success: function (data) {
                    var html = '';
                    var info = data.data.data;
                    console.log(info);
                    for (var i = 0; i < info.length; i++) {
                        html += '<div class="ui divider"></div>' +
                            ' <div class="ui divided items">' +
                            '<div class="item">' +
                            '<div>' +
                            '<img class="ui circular mini image" src="' + info[i]['user']['avatar'] + '">' +
                            '</div>' +
                            '<div style="padding-left: 1em;" class="content">' +
                            '<span class="header">' + info[i]['user']['name'] + '</span>' +
                            '（' + info[i]['created_at'] + '）' +
                            '<div class="description">' + info[i]['content'] +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }

                    $('.comment-list').append(html);
                    page = data.data.current_page;

                    if (page == data.data.last_page) {
                        $("#comment-btn").hide();
                    } else {
                        $("#comment-btn").show();
                    }
                },
                //调用出错执行的函数
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("{{trans('common.system_exception')}}");
                }
            });
        }

        getComments(page);
    </script>
@endsection
