@extends('admin.layout.app')

@section('content')
    <div id="content">
        @include('admin.common.message')
        <div class="ui stackable two column grid">
            <div class="column">
                @include('admin.banner.header')
                <div class="ui breadcrumb">
                    <a href="{{route('admin.dash')}}" class="section">{{trans('common.breadcrumb.console')}}</a>
                    <i class="right chevron icon divider"></i>
                    <a href="{{route('admin_setting_banner.index')}}" class="section">
                        {{trans('banner.manage')}}
                    </a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section">{{trans('banner.name')}}</div>
                </div>
            </div>
            <div class="middle aligned column">
                <a href="{{route('admin_setting_banner.create')}}" class="ui right floated primary button">
                    <i class="icon plus"></i>
                    {{trans('banner.add_banner')}}
                </a>
            </div>
        </div>
        <div class="ui hidden divider"></div>
        <div class="ui segment overflow-x-auto">
            <div class="ui two column fluid stackable grid">
                <div class="fourteen wide column">
                    {{$banners->links('vendor.pagination.semantic-ui-admin')}}
                </div>
                @include('admin.common.limit',['url'=>route('admin_setting_banner.index')])
            </div>
            <table class="ui sortable selectable stackable celled table">
                <thead>
                <tr>
                    <th>{{trans('common.table.number')}}</th>
                    <th>{{trans('banner.table.image')}}</th>
                    <th>{{trans('common.table.created_at')}}</th>
                    <th>{{trans('banner.table.sort')}}</th>
                    <th>{{trans('banner.table.visible')}}</th>
                    <th>{{trans('common.table.manage')}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($banners as $banner)
                    <tr class="item">
                        <td>{{$banner->id}}</td>
                        <td>
                            <img class="ui small image" src="{{asset('storage/'.$banner->image->path)}}">
                        </td>
                        <td>
                            {{$banner->created_at}}
                        </td>
                        <td>{{$banner->sort}}</td>
                        <td>
                            @if($banner->visible==1)
                                <span class="ui teal label">
                                    <i class="checkmark icon"></i>
                                    {{trans('common.enabled')}}
                                </span>
                            @else
                                <span class="ui red label">
                                    <i class="remove icon"></i>
                                    {{trans('common.disabled')}}
                                </span>
                            @endif
                        </td>
                        <td>
                            @include('admin.common.action', ['data' => $banner,'actions'=>['edit','delete'],'route'=>'admin_setting_banner'])
                        </td>
                    </tr>
                @empty
                    <tr class="item">
                        <td colspan="6"> {{trans('common.null_data')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{$banners->links('vendor.pagination.semantic-ui-admin')}}
        </div>
    </div>
    <div class="ui modal">
        <div class="header">
            <i class="icon warning red sign"></i>
            {{trans('banner.delete_banner')}}
        </div>
        <div class="content">
            <p>{{trans('banner.confirm_delete_banner')}}</p>
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
