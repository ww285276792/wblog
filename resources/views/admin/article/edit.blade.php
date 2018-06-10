@extends('admin.layout.app')

@include('vendor.ueditor.assets')

@section('content')
    <div id="content">
        <div class="ui stackable two column grid">
            <div class="column">
                @include('admin.article.header')
                <div class="ui breadcrumb">
                    <a href="{{route('admin.dash')}}" class="section">{{trans('common.breadcrumb.console')}}</a>
                    <i class="right chevron icon divider"></i>
                    <a href="{{route('admin_article.index')}}" class="section">{{trans('article.manage')}}</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section">{{trans('article.edit_article')}}</div>
                </div>
            </div>
        </div>
        <div class="ui hidden divider"></div>
        <div class="ui segment">
            <form method="post" action="{{route('admin_article.update',['id'=>$article->id])}}"
                  class="ui loadable form" enctype="multipart/form-data">
                <div class="required field">
                    <label class="required">{{trans('article.table.title')}}</label>
                    <input type="text" name="title" value="{{old('title')?old('title'):$article->title}}"
                           placeholder="{{trans('article.placeholder.input_title')}}">
                    @if($errors->first('title'))
                        <div class="ui visible error message">
                            {{$errors->first('title')}}
                        </div>
                    @endif
                </div>
                <div class="field">
                    <label class="required">
                        {{trans('article.table.image')}}（{{trans('common.image_type')}}）
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
                            @if ($article->image)
                                <img src="{{asset('storage/'.$article->image->path)}}"
                                     class="ui small bordered image"/>
                            @endif
                        </div>
                    </div>
                    @if($errors->first('image'))
                        <div class="ui visible error message">
                            {{$errors->first('image')}}
                        </div>
                    @endif
                </div>
                <div class="required field">
                    <label class="required">{{trans('article.table.description')}}</label>
                    <textarea name="description" placeholder="{{trans('article.placeholder.input_description')}}"
                              rows="2">{{old('description')?old('description'):$article->description}}</textarea>
                    @if($errors->first('description'))
                        <div class="ui visible error message">
                            {{$errors->first('description')}}
                        </div>
                    @endif
                </div>
                <div class="required field">
                    <label class="required">{{trans('article.table.content')}}</label>
                    <script id="container" name="content" type="text/plain">
                        @if (old('content'))
                            {!! old('content') !!}
                        @else
                            {!! $article->content !!}
                        @endif
                    </script>
                    @if($errors->first('content'))
                        <div class="ui visible error message">
                            {{$errors->first('content')}}
                        </div>
                    @endif
                </div>
                <div class="field">
                    <label class="required">{{trans('article.table.url')}}</label>
                    <input type="text" name="url" value="{{old('url')?old('url'):$article->url}}"
                           placeholder="{{trans('article.placeholder.input_url')}}">
                    @if($errors->first('url'))
                        <div class="ui visible error message">
                            {{$errors->first('url')}}
                        </div>
                    @endif
                </div>
                <div class="field">
                    <label class="required">{{trans('tag.name')}}</label>
                    @foreach ($tags as $key=>$tag)
                        <div class="ui checkbox segment">
                            @if(count($article->tags)>0)
                                <input {{count($article->tags)>0&&in_array($tag->id,$tgs)?'checked':''}}
                                       name="tag[]" type="checkbox" value="{{$tag->id}}">
                            @else
                                <input name="tag[]" value="{{$tag->id}}" type="checkbox" class="hidden"
                                        {{count(old('tag'))>0&&in_array($tag->id,old('tag'))?'checked':''}}>
                            @endif
                            <label>{{$tag->name}}</label>
                        </div>
                    @endforeach
                    @if($errors->first('tag'))
                        <div class="ui visible error message">
                            {{$errors->first('tag')}}
                        </div>
                    @endif
                </div>
                <div class="ui basic segment">
                    <button class="ui primary button" type="submit">
                        {{trans('common.button.submit')}}
                    </button>
                    <a href="{{route('admin_article.index')}}" class="ui button">
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
        var ue = UE.getEditor('container',{
            initialFrameHeight:400,//设置编辑器高度
            scaleEnabled:true
        });

        ue.ready(function () {
            ue.setHeight(400);
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });

        $('.ui.checkbox')
            .checkbox()
        ;

        $(function () {
            $('#image-button').click(function () {
                $('#image').click();
            })
            $('#image').change(function () {
                displayUploadedImage(this);
            })
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
