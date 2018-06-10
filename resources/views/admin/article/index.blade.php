@extends('admin.layout.app')

@section('style')
    <style>
        .ui.label{
            margin-top: .5em;
        }
    </style>
@endsection

@section('content')
    <div id="content">
        @include('admin.common.message')
        <div class="ui stackable two column grid">
            <div class="column">
                @include('admin.article.header')
                <div class="ui breadcrumb">
                    <a href="{{route('admin.dash')}}" class="section">{{trans('common.breadcrumb.console')}}</a>
                    <i class="right chevron icon divider"></i>
                    <a href="{{route('admin_article.index')}}" class="section">{{trans('article.manage')}}</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section">{{trans('article.name')}}</div>
                </div>
            </div>
            <div class="middle aligned column">
                <a href="{{route('admin_article.create')}}" class="ui right floated primary button">
                    <i class="icon plus"></i>
                    {{trans('article.add_article')}}
                </a>
            </div>
        </div>
        <div class="ui hidden divider"></div>
        @include('admin.article.filter')
        <div class="ui hidden divider"></div>
        <div class="ui segment overflow-x-auto">
            <div class="ui two column fluid stackable grid">
                <div class="fourteen wide column">
                    {{$articles->links('vendor.pagination.semantic-ui-admin')}}
                </div>
                @include('admin.common.limit',['url'=>route('admin_article.index')])
            </div>
            <table class="ui sortable selectable stackable celled table">
                <thead>
                <tr>
                    <th>{{trans('common.table.number')}}</th>
                    <th width="25%">{{trans('article.table.title')}}</th>
                    <th>{{trans('article.table.tag')}}</th>
                    <th>{{trans('article.table.view_account')}}</th>
                    <th>{{trans('article.table.comment_account')}}</th>
                    <th>{{trans('common.table.created_at')}}</th>
                    <th>{{trans('common.table.manage')}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($articles as $article)
                    <tr class="item">
                        <td>{{$article->id}}</td>
                        <td>{{$article->title}}</td>
                        <td>
                            @forelse ($article->tags as $tag)
                                <span class="ui {{$tag->color}} label">{{$tag->name}}</span>
                            @empty
                            @endforelse
                        </td>
                        <td>{{$article->view_account}}</td>
                        <td>{{$article->comments_count}}</td>
                        <td>{{$article->created_at}}</td>
                        <td>
                            @include('admin.common.action',
                            ['data' => $article,'actions'=>['edit','delete'],'route'=>'admin_article'])
                        </td>
                    </tr>
                @empty
                    <tr class="item">
                        <td colspan="7"> {{trans('common.null_data')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{$articles->links('vendor.pagination.semantic-ui-admin')}}
        </div>
    </div>
    <div class="ui modal">
        <div class="header">
            <i class="icon warning red sign"></i>
            {{trans('article.delete_tag')}}
        </div>
        <div class="content">
            <p>{{trans('article.confirm_delete_tag')}}</p>
        </div>
        <div class="actions">
            <div class="ui negative button">{{trans('common.button.cancle')}}</div>
            <div class="ui positive button">{{trans('common.button.confirm')}}</div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function del(id) {
            $('.modal')
                .modal({
                    closable: true,
                    onDeny: function () {
                    },
                    onApprove: function () {
                        document.getElementById('delete-form-' + id).submit();
                    }
                })
                .modal('show')
            ;
        }
        $('table').tablesort()
    </script>
@endsection
