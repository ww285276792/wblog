<div class="ui styled fluid accordion">
    <div class="title active">
        <i class="dropdown icon"></i>
        {{trans('common.filter')}}
    </div>
    <div class="content active">
        <form method="get" id="search-form" action="{{route('admin_report_user.index')}}" class="ui loadable form">
            <div class="two fields">
                <div class="field">
                    <label>{{trans('report.user.filter.created_at_from')}}</label>
                    <input value="{{Request::get('created_at_from')}}" type="date" name="created_at_from">
                </div>
                <div class="field">
                    <label>{{trans('report.user.filter.created_at_to')}}</label>
                    <input value="{{Request::get('created_at_to')}}" type="date" name="created_at_to">
                </div>
            </div>
            <button onclick="event.preventDefault(); document.getElementById('search-form').submit();"
                    class="ui blue button" type="submit">
                <i class="icon search"></i>
                {{trans('common.button.search')}}
            </button>
            <a class="ui button" href="{{route('admin_report_user.index')}}">
                <i class="icon remove"></i>
                {{trans('common.button.clear_search')}}
            </a>
        </form>
    </div>
</div>
