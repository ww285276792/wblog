@inject('tags', 'App\Repositories\Eloquent\TagRepositoryEloquent')
@inject('articles', 'App\Services\ArticleService')

<div class="ui segment tag-segment">
    <h4 style="margin:.8em 0;" class="ui horizontal header divider">
        <i class="mini teal fitted tag icon"></i>
        {{trans('tag.name')}}
    </h4>
    <p class="tags">
        @forelse ($tags->getTags() as $tag)
            <a href="{{route('article.index',['tag'=>$tag->name])}}" class="ui {{$tag->color}} label">
                {{$tag->name}}
            </a>
        @empty
        @endforelse
    </p>
</div>
<div class="ui segment article-segment">
    <h4 style="margin:.8em 0;" class="ui horizontal header divider">
        <i class="mini teal fitted book icon"></i>
        {{trans('article.hot_articles')}}
    </h4>
    <div class="ui list">
        @forelse ($articles->getMostCountArticles() as $article)
            <a href="{{route('article.show',['id'=>$article->id])}}" class="item">
                <i class="caret right teal icon"></i>
                <div class="content">
                    {{$article->title}}
                </div>
            </a>
        @empty
        @endforelse
    </div>
</div>
