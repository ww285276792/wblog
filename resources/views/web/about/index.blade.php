@extends('web.layout.app')

@section('title')
    {{trans('about.title')}}
@endsection

@section('content')
    <div class="about" style="min-height: 34em;">
        <div class="ui container main-content">
            <div class="ui stackable grid">
                <div class="ui segment">
                    <div class="sixteen wide column">
                        <div class="ui center aligned container">
                            <img class="ui centered circular small image"
                                 src="{{asset('storage/'.$site->image->path)}}">
                        </div>
                        <div class="ui center aligned header">{{$site->author}}</div>
                        <div class="ui container">
                            <p>{!! $site->site_description !!}</p>
                            <p>{!! $site->author_description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
