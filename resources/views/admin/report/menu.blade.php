<div class="ui vertical pointing menu" style="width: auto;">
    <a href="{{route('admin_report_user.index')}}"
       class="item {{Route::currentRouteName()=='admin_report_user.index'?'active':''}}">
        {{trans('report.menu.user')}}
    </a>
    <a href="{{route('admin_report_tag.index')}}"
       class="item {{Route::currentRouteName()=='admin_report_tag.index'?'active':''}}">
        {{trans('report.menu.tag')}}
    </a>
</div>
