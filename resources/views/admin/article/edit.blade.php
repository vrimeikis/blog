@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Article Edit') }}
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.articles.update', ['article' => $article->id]) }}" method="post" enctype="multipart/form-data">

                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" id="title" name="title" class="form-control"
                                       value="{{ old('title', $article->title) }}">
                            </div>

                            <div class="form-group">
                                <label for="content">{{ __('Content') }}</label>
                                <textarea class="form-control" id="content" name="content">{{ old('content', $article->content) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="cover">{{ __('Cover') }}</label>
                                @if ($article->cover)
                                    <img width="50" src="{{ asset('storage/'.$article->cover) }}">
                                    <input type="checkbox" name="deleteCover" value="1"> Delete cover
                                @endif
                                <input class="form-control-file" type="file" id="cover" name="cover" value="">
                            </div>

                            <div class="form-group">
                                <label for="categories">{{ __('Categories') }}</label>
                                @foreach($categories as $catId => $catName)
                                    <input id="categories" class="form-check" type="checkbox"
                                           name="categories[]" value="{{ $catId }}"
                                            {{ in_array($catId, old(
                                            'categories',
                                             ($errors->any() && old('categories') === null) ? [] : $article->categories->pluck('id')->toArray()
                                             )) ? 'checked="checked"' : '' }}> {{ $catName }}
                                @endforeach
                            </div>

                            <div class="form-group">
                                <input class="btn btn-outline-primary" type="submit" name="submit"
                                       value="{{ __('Save') }}">
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
