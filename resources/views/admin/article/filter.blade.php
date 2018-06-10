<div class="ui styled fluid accordion">
    <div class="title active">
        <i class="dropdown icon"></i>
        {{trans('common.filter')}}
    </div>
    <div class="content active">
        <form id="search-form" method="get" action="{{route('admin_article.index')}}" class="ui loadable form">
            <div class="two fields">
                <div class="field">
                    <label>{{trans('article.table.title')}}</label>
                    <input type="text" name="title" value="{{Request::get('title')}}">
                </div>
                <div class="field">
                    <label>{{trans('article.table.description')}}</label>
                    <input type="text" name="description" value="{{Request::get('description')}}">
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>{{trans('article.table.created_at_from')}}</label>
                    <input value="{{Request::get('created_at_from')}}" type="date" name="created_at_from">
                </div>
                <div class="field">
                    <label>{{trans('article.table.created_at_to')}}</label>
                    <input value="{{Request::get('created_at_to')}}" type="date" name="created_at_to">
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>{{trans('tag.name')}}</label>
                    <div class="ui fluid multiple search selection dropdown">
                        <input type="hidden" name="tags" value="{{Request::get('tags')}}">
                        <i class="dropdown icon"></i>
                        <div class="default text"></div>
                        <div class="menu">
                            @forelse ($tags as $tag)
                                <div class="item" data-value="{{$tag->id}}" data-text="{{$tag->name}}">
                                    {{$tag->name}}
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="event.preventDefault(); document.getElementById('search-form').submit();"
                    class="ui blue button" type="submit">
                <i class="icon search"></i>
                {{trans('common.button.search')}}
            </button>
            <a class="ui button" href="{{route('admin_article.index')}}">
                <i class="icon remove"></i>
                {{trans('common.button.clear_search')}}
            </a>
        </form>
    </div>
</div>
