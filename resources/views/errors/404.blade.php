@extends('app')

@section('content')
<main class="not-found">
  <h1>Página não encontrada!</h1>
  <p>Pedimos desculpa, mas não conseguimos encontrar a página que procura.</p>
  <p>Tente <a href="{{ action('HomeController@show') }}">voltar à página inicial</a> e procurar a partir daí.</p>
</main>
@endsection
