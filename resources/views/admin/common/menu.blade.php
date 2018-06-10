<div class="item">
    <div>{{trans('admin_menu.dash')}}</div>
    <div class="menu">
        <a class="item {{str_contains(Route::currentRouteName(),'admin.dash')?'active':''}}"
           href="{{route('admin.dash')}}">
            <i class="icon dashboard"></i>
            {{trans('admin_menu.dash')}}
        </a>
        <a class="item {{str_contains(Route::currentRouteName(),'admin_report')?'active':''}}"
           href="{{route('admin_report_user.index')}}">
            <i class="icon bar chart"></i>
            {{trans('admin_menu.report')}}
        </a>
    </div>
</div>
<div class="item">
    <div>{{trans('admin_menu.manage_article')}}</div>
    <div class="menu">
        <a class="item {{str_contains(Route::currentRouteName(),'admin_article')&&!str_contains(Route::currentRouteName(),'admin_article_comment')?'active':''}}"
           href="{{route('admin_article.index')}}">
            <i class="icon book"></i>
            {{trans('admin_menu.article')}}
        </a>
        <a class="item {{str_contains(Route::currentRouteName(),'admin_article_comment')?'active':''}}"
           href="{{route('admin_article_comment.index')}}">
            <i class="icon comment"></i>
            {{trans('admin_menu.comment')}}
        </a>
    </div>
</div>
<div class="item">
    <div>{{trans('admin_menu.manage_tag')}}</div>
    <div class="menu">
        <a class="item {{str_contains(Route::currentRouteName(),'admin_tag')?'active':''}}"
           href="{{route('admin_tag.index')}}">
            <i class="icon tags"></i>
            {{trans('admin_menu.tag')}}
        </a>
    </div>
</div>
<div class="item ">
    <div>{{trans('admin_menu.manage_message')}}</div>
    <div class="menu">
        <a class="item {{str_contains(Route::currentRouteName(),'admin_message')?'active':''}}"
           href="{{route('admin_message.index')}}">
            <i class="icon mail"></i>
            {{trans('admin_menu.message')}}
        </a>
    </div>
</div>
<div class="item ">
    <div>{{trans('admin_menu.manage_changelog')}}</div>
    <div class="menu">
        <a class="item {{str_contains(Route::currentRouteName(),'admin_changelog')?'active':''}}"
           href="{{route('admin_changelog.index')}}">
            <i class="icon bookmark"></i>
            {{trans('admin_menu.changelog')}}
        </a>
    </div>
</div>
<div class="item ">
    <div>{{trans('admin_menu.admin_user')}}</div>
    <div class="menu">
        <a class="item {{str_contains(Route::currentRouteName(),'admin_user') && !str_contains(Route::currentRouteName(),'admin_user_role')?'active':''}}"
           href="{{route('admin_user.index')}}">
            <i class="icon users"></i>
            {{trans('admin_menu.admin_user')}}
        </a>
        <a class="item {{str_contains(Route::currentRouteName(),'admin_user_role')?'active':''}}"
           href="{{route('admin_user_role.index')}}">
            <i class="icon archive"></i>
            {{trans('admin_menu.admin_user_role')}}
        </a>
    </div>
</div>
<div class="item ">
    <div>{{trans('admin_menu.site')}}</div>
    <div class="menu">
        <a class="item {{str_contains(Route::currentRouteName(),'admin_setting_banner')?'active':''}}"
           href="{{route('admin_setting_banner.index')}}">
            <i class="icon image"></i>
            {{trans('admin_menu.banner')}}
        </a>
        <a class="item {{str_contains(Route::currentRouteName(),'admin_setting_site')?'active':''}}"
           href="{{route('admin_setting_site.edit')}}">
            <i class="icon settings"></i>
            {{trans('admin_menu.site_info')}}
        </a>
    </div>
</div>
