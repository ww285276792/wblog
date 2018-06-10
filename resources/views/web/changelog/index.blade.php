@extends('web.layout.app')

@section('title')
    {{trans('changelog.title')}}
@endsection

@section('content')
    <div class="changelog">
        <div class="ui container main-content">
            <div class="ui stackable grid">
                <div class="twelve wide column">
                    <div class="ui fluid styled accordion">
                        @forelse ($changelogs as $changelog)
                            <div class="title @if($loop->first) active @endif">
                                <i class="dropdown icon"></i>
                                {{$changelog->version}}
                                <div style="margin: 0;padding: 0;" class="ui basic right floated compact segment">
                                    {{$changelog->date}}
                                </div>
                            </div>
                            <div class="content @if($loop->first) active @endif">
                                <p>
                                    {!!$changelog->content!!}
                                </p>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="four wide column">
                    @include('web.common.tags_news')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('.ui.accordion').accordion();
    </script>
@endsection
