@extends('admin.layout.app')

@section('content')
    <div id="content">
        @include('admin.common.message')
        <div class="ui stackable two column grid">
            <div class="column">
                @include('admin.comment.header')
                <div class="ui breadcrumb">
                    <a href="{{route('admin.dash')}}" class="section">{{trans('common.breadcrumb.console')}}</a>
                    <i class="right chevron icon divider"></i>
                    <a href="{{route('admin_article_comment.index')}}" class="section">
                        {{trans('comment.manage')}}
                    </a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section">{{trans('comment.name')}}</div>
                </div>
            </div>
        </div>
        <div class="ui hidden divider"></div>
        @include('admin.comment.filter')
        <div class="ui hidden divider"></div>
        <div class="ui segment overflow-x-auto">
            <div class="ui two column fluid stackable grid">
                <div class="fourteen wide column">
                    {{$comments->links('vendor.pagination.semantic-ui-admin')}}
                </div>
                @include('admin.common.limit',['url'=>route('admin_article_comment.index')])
            </div>
            <table class="ui sortable selectable stackable celled table">
                <thead>
                <tr>
                    <th>{{trans('common.table.number')}}</th>
                    <th>{{trans('comment.table.name')}}</th>
                    <th>{{trans('comment.table.article')}}</th>
                    <th>{{trans('comment.table.content')}}</th>
                    <th>{{trans('common.table.created_at')}}</th>
                    <th>{{trans('common.table.manage')}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($comments as $comment)
                    <tr class="item">
                        <td>{{$comment->id}}</td>
                        <td>{{$comment->user->name}}</td>
                        <td>{{$comment->article->title}}</td>
                        <td>{{$comment->content}}</td>
                        <td>{{$comment->created_at}}</td>
                        <td>
                            @include('admin.common.action', ['data' => $comment,'actions'=>['delete'],'route'=>'admin_article_comment'])
                        </td>
                    </tr>
                @empty
                    <tr class="item">
                        <td colspan="6"> {{trans('common.null_data')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{$comments->links('vendor.pagination.semantic-ui-admin')}}
        </div>
    </div>
    <div class="ui modal">
        <div class="header">
            <i class="icon warning red sign"></i>
            {{trans('comment.delete_comment')}}
        </div>
        <div class="content">
            <p>{{trans('comment.confirm_delete_comment')}}</p>
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
    </script>
@endsection
