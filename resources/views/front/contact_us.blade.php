@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Write us') }}
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

                        <form action="{{ route('contact.send') }}" method="post">

                            @csrf

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('E-mail') }}</label>
                                <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>

                            <div class="form-group">
                                <label for="message">{{ __('Message') }}</label>
                                <textarea class="form-control" id="message" name="message">{{ old('message') }}</textarea>
                            </div>

                            <div class="form-group">
                                <input class="btn btn-outline-primary" type="submit" name="submit" value="{{ __('Send') }}">
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
