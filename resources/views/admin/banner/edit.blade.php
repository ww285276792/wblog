@extends('admin.layout.app')

@section('content')
    <div id="content">
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
                    <div class="active section">{{trans('banner.edit_banner')}}</div>
                </div>
            </div>
        </div>
        <div class="ui hidden divider"></div>
        <div class="ui segment">
            <form method="post" action="{{route('admin_setting_banner.update',['id'=>$banner->id])}}"
                  class="ui loadable form" enctype="multipart/form-data">
                <div class="field">
                    <label class="required">
                        {{trans('banner.table.image')}}（{{trans('common.image_type')}}）
                    </label>
                    <div class="ui segment">
                        <label id="image-button" class="ui icon labeled button">
                            <i class="cloud upload icon"></i>
                            {{trans('common.chose_image')}}
                        </label>
                        <div style="display: none;">
                            <input id="image" type="file" name="image">
                        </div>
                        <div class="image-div">
                            <img src="{{asset('storage/'.$banner->image->path)}}"
                                 class="ui small bordered image"/>
                        </div>
                    </div>
                    @if($errors->first('image'))
                        <div class="ui visible error message">
                            {{$errors->first('image')}}
                        </div>
                    @endif
                </div>
                <div class="field">
                    <label class="required">{{trans('banner.table.sort')}}</label>
                    <input type="text" name="sort" value="{{old('sort')?old('sort'):$banner->sort}}"
                           placeholder="{{trans('banner.placeholder.input_sort')}}">
                    @if($errors->first('sort'))
                        <div class="ui visible error message">
                            {{$errors->first('sort')}}
                        </div>
                    @endif
                </div>
                <div class="field">
                    <label class="required">{{trans('common.enabled')}}</label>
                    <div class="inline field">
                        <div class="ui toggle checkbox">
                            <input {{$banner->visible==1?'checked':''}} type="checkbox" tabindex="0" name="visible"
                                   value="1" class="hidden">
                        </div>
                    </div>
                    @if($errors->first('visible'))
                        <div class="ui visible error message">
                            {{$errors->first('visible')}}
                        </div>
                    @endif
                </div>
                <div class="ui basic segment">
                    <button class="ui primary button" type="submit">
                        {{trans('common.button.submit')}}
                    </button>
                    <a href="{{route('admin_setting_banner.index')}}" class="ui button">
                        {{trans('common.button.cancle')}}
                    </a>
                </div>
                {{csrf_field()}}
                {{method_field('PUT')}}
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        $('.ui.checkbox')
            .checkbox()
        ;

        $(function () {
            $('#image-button').click(function () {
                $('#image').click();
            });
            $('#image').change(function () {
                displayUploadedImage(this);
            });
        });

        function displayUploadedImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var image = $(input).parent().siblings('.image');

                    if (image.length > 0) {
                        image.attr('src', e.target.result);
                    } else {
                        var img = $('<img class="ui small bordered image"/>');
                        img.attr('src', e.target.result);
                        $(input).parent().parent().children('.image-div').html(img);
                    }
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
