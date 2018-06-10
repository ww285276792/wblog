@extends('web.layout.app')

@section('title')
    {{trans('article.name')}}
@endsection

@section('content')
    <div class="home articles">
        @if($keyword)
            <div class="ui container filter">
                <span>{{$keyword}}</span>
                {{trans('article.search_articles')}}
            </div>
        @endif
        @if($tag)
            <div class="ui container filter">
                <span>{{$tag}}</span>
                {{trans('article.search_articles')}}
            </div>
        @endif
        <div class="ui container content">
            <div class="ui stackable grid">
                <div class="twelve wide column">
                    <div class="ui segment">
                        <div class="ui divided items lists article-list"></div>
                        <input style="display: none;" type="button" class="ui fluid basic button"
                               id="article-btn" value="{{trans('common.show_more')}}"/>
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
    <script type="text/javascript">
        var page = 1;

        $("#article-btn").click(function () {
            getArticles(page + 1);
            page = page + 1;
        });

        function getArticles(page) {
            var data = {
                "keyword": "{{$keyword}}",
                "tag": "{{$tag}}",
                "_token": "{{csrf_token()}}",
                "page": page
            };

            $.ajax({
                type: "POST",
                url: "{{route('article.list')}}",
                data: data,
                datatype: "json",
                success: function (data) {
                    var html = '';
                    var info = data.data.data;
                    if (info.length == 0) {
                        $('.article-list').html('<div class="item">{{trans('article.no_result_articles')}}</div>');
                    }
                    for (var i = 0; i < info.length; i++) {
                        var image = info[i]['image'];
                        var path = '';
                        if (image == null) {
                            path = 'images/default.png';
                        } else {
                            path = "storage/" + info[i]['image']['path'];
                        }
                        var tagshtml = '';
                        var tags = info[i]['tags'];
                        for (var ti = 0; ti < tags.length; ti++) {
                            tagshtml += '<a href="/article?tag=' + tags[ti]['name'] + '" class="ui ' + tags[ti]['color'] + ' label">' + tags[ti]['name'] + '</a>';
                        }

                        html += '<div class="item">' +
                            ' <a href="article/' + info[i]['id'] + '"class="image">' +
                            ' <img src="' + path + '" class="am-u-sm-12">' +
                            ' </a>' +
                            '<div class="content">' +
                            ' <a href="article/' + info[i]['id'] + '" class="header article-title">'
                            + info[i]['title'] +
                            ' </a>' +
                            '<div class="meta"><p class="article-desc">' + info[i]['description'] + '</p></div>' +
                            ' <div class="meta">' +
                            '<p class="ui  right floated">' + info[i]['created_at'] +
                            '</p>' + tagshtml + '</div>' +
                            '</div>' +
                            '</div>';
                    }

                    $('.article-list').append(html);
                    page = data.data.current_page;

                    if (page == data.data.last_page) {
                        $("#article-btn").hide();
                    } else {
                        $("#article-btn").show();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("{{trans('common.system_exception')}}");
                }
            });
        }

        getArticles(page);
    </script>
@endsection
