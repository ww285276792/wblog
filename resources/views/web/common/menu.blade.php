<div class="ui teal borderless inverted menu nav">
    <div class="ui container">
        <a href="{{route('home')}}" class="item">
            {{trans('menu.home')}}
            @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'home')
                <span class="border"></span>
            @endif
        </a>
        <a href="{{route('article.index')}}" class="item">
            @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'article.index')
                <span class="border"></span>
            @endif
            {{trans('menu.article')}}
        </a>
        <a href="{{route('message.index')}}" class="item">
            {{trans('menu.message')}}
            @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'message.index')
                <span class="border"></span>
            @endif
        </a>
        <a href="{{route('changelog.index')}}" class="item">
            {{trans('menu.changelog')}}
            @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'changelog.index')
                <span class="border"></span>
            @endif
        </a>
        <a href="{{route('about.index')}}" class="item">
            {{trans('menu.about')}}
            @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'about.index')
                <span class="border"></span>
            @endif
        </a>
        <div class="right menu">
            <div class="item" style="padding-right: 0;">
                <form method="get" action="{{route('article.index')}}">
                    <div class="ui mini right icon input">
                        <i class="search icon"></i>
                        <input name="keyword" value="{{Request::get('keyword')}}" type="text"
                               placeholder="{{trans('menu.search.keyword')}}">
                    </div>
                </form>
            </div>
            @guest
            <a href="{{route('login')}}" class="item">{{trans('auth.login')}}</a>
            @else
                <div class="ui dropdown item">
                    @if(Auth::user()->avatar)
                        <img width="35" class="ui circular  image" src="{{Auth::user()->avatar}}">
                    @else
                        <img src="{{asset('static/images/user.png')}}">
                    @endif
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a onclick="logout()" class="item">{{trans('auth.logout')}}</a>
                    </div>
                    <form class="logoutform" action="{{ route('logout') }}" method="POST"
                          style="">
                        {{ csrf_field() }}
                    </form>
                </div>
                @endguest
        </div>
    </div>
</div>
