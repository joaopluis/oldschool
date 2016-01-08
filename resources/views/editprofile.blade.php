@extends('app')

@section('content')
    <main class="profile-edit form-page">

        <h1 class="title">Editar Perfil</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="errors">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ action('ProfileController@update') }}">
            {!! csrf_field() !!}

            <div class="os__form-group">
                <label for="username">Nome <span class="required">(obrigatório)</span></label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" class="os__field">
            </div>

            <div class="os__form-group">
                <label for="email">Endereço de e-mail</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" class="os__field">
            </div>

            <hr>

            <p class="os__hint">Deixe os campos abaixo vazios se não quer alterar a sua password.</p>

            <div class="os__form-group">
                <label for="password">Password atual</label>
                <input type="password" name="current_password" class="os__field">
            </div>

            <div class="os__form-group">
                <label for="password">Nova password</label>
                <input type="password" name="new_password" class="os__field">
            </div>

            <div class="os__form-group">
                <label for="password_confirmation">Confirmar Password</label>
                <input type="password" name="confirm_password_confirmation" class="os__field">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Gravar</button>
            </div>
        </form>
    </main>
@endsection