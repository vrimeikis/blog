@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h3>
                                <a href="">{{ $article->title }}</a>
                            </h3>
                            @if ($article->cover)
                                <img src="{{ asset('storage/'.$article->cover) }}" class="img-thumbnail">
                            @endif
                            <p>{{ $article->content }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
