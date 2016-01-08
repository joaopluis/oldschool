@extends('app')

@section('content')
    <main class="register form-page">

        <h1>Criar conta</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="errors">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ action('Auth\AuthController@postRegister') }}">
            {!! csrf_field() !!}

            <div class="os__form-group">
                <label for="name">Nome <span class="required">(obrigatório)</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="os__field">
            </div>

            <div class="os__form-group">
                <label for="username">Nome de utilizador <span class="required">(obrigatório)</span></label>
                <input type="text" name="username" value="{{ old('username') }}" class="os__field">
            </div>

            <div class="os__form-group">
                <label for="email">Endereço de e-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" class="os__field">
            </div>

            <div class="os__form-group">
                <label for="password">Password <span class="required">(obrigatório)</span></label>
                <input type="password" name="password" class="os__field">
            </div>

            <div class="os__form-group">
                <label for="password_confirmation">Confirmar Password <span class="required">(obrigatório)</span></label>
                <input type="password" name="password_confirmation" class="os__field">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Registar</button>
            </div>
        </form>
    </main>
@endsection