@extends('app')

@section('content')
    <main class="login form-page">

        <h1 class="title">Entrar</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="errors">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ action('Auth\AuthController@postLogin') }}">
            {!! csrf_field() !!}

            <div class="os__form-group">
                <label for="username">Nome de utilizador</label>
                <input type="text" name="username" value="{{ old('username') }}" class="os__field">
            </div>

            <div class="os__form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="os__field">
            </div>

            <div class="os__form-group">
                <label><input type="checkbox" name="remember" class="os__checkbox"> Lembrar-me</label>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
        </form>
    </main>
@endsection