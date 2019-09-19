<div>
    <h3>
        <a href="{{ route('article.show', ['slug' => $article->slug]) }}">{{ $article->title }}</a>
        <em>{{ $article->created_at->format('Y-m-d H:i:s') }}</em>
    </h3>
    @if ($article->cover)
        <img src="{{ asset('storage/'.$article->cover) }}" class="img-thumbnail" style="width: 200px;">
    @endif
    <p>{{ Str::words($article->content, 50, '...') }}</p>
</div>