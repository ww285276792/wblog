<div class="ui styled fluid accordion">
    <div class="title active">
        <i class="dropdown icon"></i>
        {{trans('common.filter')}}
    </div>
    <div class="content active">
        <form id="search-form" method="get" action="{{route('admin_article_comment.index')}}" class="ui loadable form">
            <div>
                <div class="field">
                    <label>{{trans('comment.table.name')}}</label>
                    <input type="text" name="name" value="{{Request::get('name')}}">
                </div>
            </div>
            <div class="two fields"></div>
            <button onclick="event.preventDefault(); document.getElementById('search-form').submit();"
                    class="ui blue button" type="submit">
                <i class="icon search"></i>
                {{trans('common.button.search')}}
            </button>
            <a class="ui button" href="{{route('admin_article_comment.index')}}">
                <i class="icon remove"></i>
                {{trans('common.button.clear_search')}}
            </a>
        </form>
    </div>
</div>
