@extends('admin.layout.app')

@section('content')
    <div id="content">
        <div class="ui stackable grid">
            <div class="twelve wide column">
                @include('admin.dashboard.header')
            </div>
            <div class="four wide middle aligned column">
            </div>
        </div>
        <div class="ui fluid labeled four icon item menu">
            <a href="{{route('admin_user.index')}}" class="item">
                <i class="users icon"></i>
                {{trans('dashboard.register_users')}}
            </a>
            <a href="{{route('admin_article.index')}}" class="item">
                <i class="book icon"></i>
                {{trans('dashboard.article')}}
            </a>
            <a href="{{route('admin_article_comment.index')}}" class="item">
                <i class="comment icon"></i>
                {{trans('dashboard.comment')}}
            </a>
            <a href="{{route('admin_message.index')}}" class="item">
                <i class="mail icon"></i>
                {{trans('dashboard.message')}}
            </a>
        </div>
        <div class="ui two column stackable grid">
            <div class="column">
                <div class="ui segment">
                    <h4 class="ui dividing header">{{trans('dashboard.latest_users')}}</h4>
                    <table class="ui stackable table" id="customers">
                        <thead>
                        <th>{{trans('auth.name')}}</th>
                        <th></th>
                        <th></th>
                        </thead>
                        <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <strong>{{$user->name}}</strong><br>
                                    {{$user->created_at->format('Y-m-d H:i')}}
                                </td>
                                <td>
                                </td>
                                <td>
                                    <div class="ui right floated buttons">
                                        <a class="ui button" href="">
                                            <i class="icon search"></i>
                                            {{trans('common.button.show')}}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="column">
                <div class="ui segment">
                    <h4 class="ui dividing header">{{trans('dashboard.latest_articles')}}</h4>
                    <table class="ui stackable table" id="orders">
                        <thead>
                        <th>{{trans('article.table.title')}}</th>
                        <th>{{trans('article.table.comment_account')}}</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @forelse ($articles as $article)
                            <tr>
                                <td width="60%">
                                    {{$article->title}}
                                </td>
                                <td>
                                    {{$article->comments_count}}
                                </td>
                                <td>
                                    <div class="ui right floated buttons">
                                        <a class="ui button"
                                           href="{{route('admin_article.edit',['id'=>$article->id])}}">
                                            <i class="icon search"></i>
                                            {{trans('common.button.show')}}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="column">
                <div class="ui segment">
                    <h4 class="ui dividing header">{{trans('dashboard.latest_messages')}}</h4>
                    <table class="ui stackable table" id="customers">
                        <thead>
                        <th width="30%">{{trans('message.table.user')}}</th>
                        <th>{{trans('message.table.content')}}</th>
                        </thead>
                        <tbody>
                        @forelse ($messages as $message)
                            <tr>
                                <td>
                                    <strong>{{$message->user->name}}</strong><br>
                                    {{$user->created_at->format('Y-m-d H:i')}}
                                </td>
                                <td>
                                    {!! $message->content !!}
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="column">
                <div class="ui segment">
                    <h4 class="ui dividing header">{{trans('dashboard.latest_changelogs')}}</h4>
                    <table class="ui stackable table" id="customers">
                        <thead>
                        <th>{{trans('changelog.table.version')}}</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @forelse ($changelogs as $changelog)
                            <tr>
                                <td>
                                    <strong>{{$changelog->version}}</strong><br>
                                    {{$changelog->created_at->format('Y-m-d H:i')}}
                                </td>
                                <td>
                                    <div class="ui right floated buttons">
                                        <a class="ui button"
                                           href="{{route('admin_changelog.edit',['id'=>$changelog->id])}}">
                                            <i class="icon search"></i>
                                            {{trans('common.button.show')}}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
