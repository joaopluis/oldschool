<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OldSchool</title>

    {!! Html::style('fonts/fonts.css') !!}
    {!! Html::style('fonts/materialdesignicons.css') !!}
    {!! Html::style('css/style.css') !!}

    <style>
        body, .btn, .os__field{
            font-size: {{ ceil(16 * ((Auth::check())?(Auth::user()->font_size):1) ) }}px;
        }
    </style>
</head>
<body>

<header class="page-header">

    <div class="page-header__logo">
        <a href="{{ action('HomeController@show') }}">
            {!! Html::image('images/logo-white.png', 'OldSchool') !!}
        </a>
    </div>

    <div class="page-header__profile">
        @if(Auth::check())
            <div class="page-header__profile__photo">
                {!! Html::image(Auth::user()->photo) !!}
            </div>
            <div class="page-header__profile__data">
                <p class="page-header__profile__data__welcome">
                    Bem-vindo ao OldSchool, <strong>{{ Auth::user()->name }}</strong>!
                </p>
                <ul class="page-header__profile__data__nav">
                    <li><a href="{{ url('perfil') }}" class="btn btn-default btn-sm">O meu perfil</a></li>
                    <li><a href="{{ action('Auth\AuthController@getLogout') }}" class="btn btn-default btn-sm">Sair</a></li>
                </ul>
            </div>
        @else
            <div class="page-header__profile__photo">
                {!! Html::image('images/profile.png') !!}
            </div>
            <div class="page-header__profile__data">
                <p class="page-header__profile__data__welcome">
                    Bem-vindo ao OldSchool!
                </p>
                <ul class="page-header__profile__data__nav">
                    <li>Já tem conta? <a href="{{ action('Auth\AuthController@getLogin') }}">Entrar</a></li>
                    <li>Ainda não? <a href="{{ action('Auth\AuthController@getRegister') }}">Criar</a></li>
                </ul>
            </div>
        @endif
    </div>

</header>

<nav class="nav-panel">
    <ul class="breadcrumbs">
        @if(isset($previous))
            <li class="icon"><a href="{{$previous}}"><span class="mdi mdi-arrow-left"></span></a></li>
        @else
            <li class="icon"><span class="mdi mdi-home"></span></li>
        @endif
        @foreach($breadcrumbs as $url => $name)
            <li><a href="{{$url}}">{{$name}}</a></li>
        @endforeach
    </ul>

    <div class="search">
        <span class="icon"><span class="mdi mdi-magnify"></span></span>
        <input type="search" class="os__field" placeholder="Pesquisar..."/>
    </div>
</nav>

@yield('content')

<footer class="page-footer">
    <section class="page-footer__logo">
        {!! Html::image('images/logo.png', 'OldSchool') !!}
    </section>
    <section>
        <ul class="page-footer__nav">
            <li><a href="#">Sobre</a></li>
            <li><a href="#">Equipa</a></li>
            <li><a href="#">Termos e Condições</a></li>
            <li><a href="#">Política de Privacidade</a></li>
            <li><a href="#">Contactos</a></li>
        </ul>
    </section>
    <section class="page-footer__help">
        <h2>Ajuda</h2>
        <ul class="page-footer__nav">
            <li><a href="#">Perguntas frequentes</a></li>
            <li><a href="#">Contacte-nos</a></li>
        </ul>
    </section>
    <section class="page-footer__sponsors">
        <h2>Apoios</h2>
        {!! Html::image('images/ist.png', 'Técnico Lisboa') !!}
    </section>
</footer>

{!! Html::script('js/jquery-2.1.4.min.js') !!}
{!! Html::script('js/autogrow.js') !!}
{!! Html::script('js/jquery.bpopup.min.js') !!}

<script>
    $(document).ready(function () {
        @yield('scripts')
    });
</script>

</body>
</html>