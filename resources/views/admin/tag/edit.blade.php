@extends('admin.layout.app')

@section('content')
    <div id="content">
        <div class="ui stackable two column grid">
            <div class="column">
                @include('admin.tag.header')
                <div class="ui breadcrumb">
                    <a href="{{route('admin.dash')}}" class="section">{{trans('common.breadcrumb.console')}}</a>
                    <i class="right chevron icon divider"></i>
                    <a href="{{route('admin_tag.index')}}" class="section">{{trans('tag.manage')}}</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section">{{trans('tag.edit_tag')}}</div>
                </div>
            </div>
        </div>
        <div class="ui hidden divider"></div>
        <div class="ui segment">
            <form method="post" action="{{route('admin_tag.update',['id'=>$tag->id])}}" class="ui loadable form">
                <div class="required field">
                    <label class="required">{{trans('tag.tag_name')}}</label>
                    <input type="text" name="name" value="{{old('name')?old('name'):$tag->name}}"
                           placeholder="{{trans('tag.placeholder.input_tag')}}">
                    @if($errors->first('name'))
                        <div class="ui visible error message">
                            {{$errors->first('name')}}
                        </div>
                    @endif
                </div>
                <div class="required field">
                    <label class="">{{trans('tag.table.color')}}</label>
                    <div class="ui segment inline fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="color" value="teal" class="hidden">
                                <label><span class="ui teal label"></span></label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="color" value="green" class="hidden">
                                <label><span class="ui green label"></span></label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="color" value="blue" class="hidden">
                                <label><span class="ui blue label"></span></label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="color" value="purple" class="hidden">
                                <label><span class="ui purple label"></span></label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="color" value="orange" class="hidden">
                                <label><span class="ui orange label"></span></label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="color" value="pink" class="hidden">
                                <label><span class="ui pink label"></span></label>
                            </div>
                        </div>
                    </div>
                    @if($errors->first('color'))
                        <div class="ui visible error message">
                            {{$errors->first('color')}}
                        </div>
                    @endif
                </div>
                <div class="ui basic segment">
                    <button class="ui primary button" type="submit">
                        {{trans('common.button.submit')}}
                    </button>
                    <a href="{{route('admin_tag.index')}}" class="ui button">
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
    <script type="text/javascript">
        $('.ui.checkbox')
            .checkbox()
        ;

        var color = '{{$tag->color}}';
        $("input:radio[name=color][value=" + color + "]").attr("checked", true);
    </script>
@endsection
