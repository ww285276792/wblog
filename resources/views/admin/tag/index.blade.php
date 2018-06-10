@extends('admin.layout.app')

@section('content')
    <div id="content">
        @include('admin.common.message')
        <div class="ui stackable two column grid">
            <div class="column">
                @include('admin.tag.header')
                <div class="ui breadcrumb">
                    <a href="{{route('admin.dash')}}" class="section">{{trans('common.breadcrumb.console')}}</a>
                    <i class="right chevron icon divider"></i>
                    <a href="{{route('admin_tag.index')}}" class="section">{{trans('tag.manage')}}</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section">{{trans('tag.name')}}</div>
                </div>
            </div>
            <div class="middle aligned column">
                <a href="{{route('admin_tag.create')}}" class="ui right floated primary button">
                    <i class="icon plus"></i>
                    {{trans('tag.add_tag')}}
                </a>
            </div>
        </div>
        <div class="ui hidden divider"></div>
        @include('admin.tag.filter')
        <div class="ui hidden divider"></div>
        <div class="ui segment overflow-x-auto">
            <div class="ui two column fluid stackable grid">
                <div class="fourteen wide column">
                    {{$tags->links('vendor.pagination.semantic-ui-admin')}}
                </div>
                @include('admin.common.limit',['url'=>route('admin_tag.index')])
            </div>
            <table class="ui sortable selectable stackable celled table">
                <thead>
                <tr>
                    <th>{{trans('common.table.number')}}</th>
                    <th>{{trans('tag.table.name')}}</th>
                    <th>{{trans('common.table.created_at')}}</th>
                    <th>{{trans('common.table.manage')}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($tags as $tag)
                    <tr class="item">
                        <td>{{$tag->id}}</td>
                        <td><span class="ui {{$tag->color}} label">{{$tag->name}}</span></td>
                        <td>{{$tag->created_at}}</td>
                        <td>
                            @include('admin.common.action',
                            ['data' => $tag,'actions'=>['edit','delete'],'route'=>'admin_tag'])
                        </td>
                    </tr>
                @empty
                    <tr class="item">
                        <td colspan="5"> {{trans('common.null_data')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{$tags->links('vendor.pagination.semantic-ui-admin')}}
        </div>
    </div>
    <div class="ui modal">
        <div class="header">
            <i class="icon warning red sign"></i>
            {{trans('tag.delete_tag')}}
        </div>
        <div class="content">
            <p>{{trans('tag.confirm_delete_tag')}}</p>
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
