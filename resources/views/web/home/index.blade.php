@extends('web.layout.app')

@section('title')
    {{trans('common.homepage')}}
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('swiper/dist/css/swiper.min.css')}}">
@endsection

@section('banner')
    <div class="ui container banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @forelse ($banners as $banner)
                    <div class="swiper-slide">
                        <img class="ui image" src="{{asset('storage/'.$banner->image->path)}}">
                    </div>
                @empty
                @endforelse
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Arrows -->
            <i class="chevron circle right large icon swiper-button-next"></i>
            <i class="chevron circle left large icon swiper-button-prev"></i>
        </div>
    </div>
@endsection

@section('content')
    <div class="home">
        <div class="ui container content">
            <div class="ui stackable grid">
                <div class="twelve wide column">
                    <div class="ui segment">
                        <div class="ui divided items lists">
                            @forelse ($articles as $article)
                                <div class="item">
                                    <a href="{{route('article.show',['id'=>$article->id])}}" class="image">
                                        @if($article->image)
                                            <img src="{{asset('storage/'.$article->image->path)}}" class="am-u-sm-12">
                                        @else
                                            <img src="{{asset('images/default.png')}}" class="am-u-sm-12">
                                        @endif
                                    </a>
                                    <div class="content">
                                        <a href="{{route('article.show',['id'=>$article->id])}}"
                                           class="header article-title">
                                            {{$article->title}}
                                        </a>
                                        <div class="meta">
                                            <p class="article-desc">{{$article->description}}</p>
                                        </div>
                                        <div class="meta">
                                            <p class="ui right floated">
                                                {{$article->created_at->format('Y-m-d')}}
                                            </p>
                                            @forelse ($article->tags as $tag)
                                                <a href="{{route('article.index',['tag'=>$tag->name])}}"
                                                   class="ui {{$tag->color}} label">
                                                    {{$tag->name}}
                                                </a>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                            <div class="ui right aligned basic segment">
                                {{$articles->links('vendor.pagination.semantic-ui')}}
                            </div>
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
    <script src="{{asset('swiper/dist/js/swiper.min.js')}}"></script>

    <script type="text/javascript">
        var swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            on: {
                slideChange: function () {
                    if (this.isEnd) {
                        this.navigation.$nextEl.css('display', 'none');
                    } else {
                        this.navigation.$nextEl.css('display', 'block');
                    }
                    if (this.isBeginning) {
                        this.navigation.$prevEl.css('display', 'none');
                    } else {
                        this.navigation.$prevEl.css('display', 'block');
                    }
                }
            },
            autoplay: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        });
    </script>
@endsection
