@extends('app')

@section('content')
    <main class="profile">

        <h1>Perfil</h1>

        <div class="profile__top">
            <header class="profile__header">
                <div class="profile__header__photo">
                    {!! Html::image(Auth::user()->photo, Auth::user()->name) !!}
                </div>
                <div class="profile__header__data">
                    <p class="profile__header__name">{{Auth::user()->name}}</p>
                    <p class="profile__header__details">
                        {{Auth::user()->username}}
                        @if(Auth::user()->email)
                        &middot;
                        {{ Auth::user()->email }}
                        @endif
                    </p>
                    <p class="profile__header__created">
                        Conta criada a {{Auth::user()->created_at->formatLocalized("%e de %B de %Y")}}
                    </p>
                </div>
                <div class="profile__header__buttons">
                    <p>
                        <a href="{{action('ProfileController@edit')}}" class="btn btn-default btn-sm">Editar</a>
                    </p>
                    <p>
                        <a href="{{action('ProfileController@decreaseSize')}}" class="btn btn-default btn-xs">A-</a>
                        <a href="{{action('ProfileController@increaseSize')}}" class="btn btn-default btn-xs">A+</a>
                    </p>
                </div>
            </header>

            <div class="profile__achievements">
                <h2>Conquistas</h2>
                @if(Auth::user()->achievements->count() > 0)
                    <div class="profile__achievements__strip">
                        @foreach(Auth::user()->achievements as $achievement)
                            {!! Html::image('courses/achievements/achievement-'.$achievement->id.'.png', $achievement->name) !!}
                        @endforeach
                    </div>
                @else
                    <div class="profile__achievements__empty">
                        Ainda não ganhou nenhuma conquista!
                    </div>
                @endif
            </div>
        </div>


        <div class="profile__connections">

            <div class="profile__friends">
                <h3>Amigos</h3>
                @if(Auth::user()->friends->count() > 0)
                    <div class="profile__connections__list">
                        @foreach(Auth::user()->friends as $person)
                            <div class="profile__connections__person">
                                <div class="profile__connections__person__photo">
                                    {!! Html::image($person->photo) !!}
                                </div>
                                <div class="profile__connections__person__data">
                                    <p class="profile__connections__person__name">{{$person->name}}</p>
                                    <div class="profile__connections__person__details">{{$person->username}}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="profile__connections__empty">
                        Ainda não encontrou nenhum amigo no OldSchool.
                    </div>
                @endif
            </div>

            <div class="profile__accompanies">
                <h3>Acompanha</h3>
                @if(Auth::user()->accompanies->count() > 0)
                    <div class="profile__connections__list">
                        @foreach(Auth::user()->accompanies as $person)
                            <div class="profile__connections__person">
                                <div class="profile__connections__person__photo">
                                    {!! Html::image($person->photo) !!}
                                </div>
                                <div class="profile__connections__person__data">
                                    <p class="profile__connections__person__name">{{$person->name}}</p>
                                    <div class="profile__connections__person__details">{{$person->username}}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="profile__connections__empty">
                        Ainda não acompanha ninguém no OldSchool.
                    </div>
                @endif
            </div>

            <div class="profile__companions">
                <h3>Acompanhado por</h3>
                @if(Auth::user()->companions->count() > 0)
                    <div class="profile__connections__list">
                        @foreach(Auth::user()->companions as $person)
                            <div class="profile__connections__person">
                                <div class="profile__connections__person__photo">
                                    {!! Html::image($person->photo) !!}
                                </div>
                                <div class="profile__connections__person__data">
                                    <p class="profile__connections__person__name">{{$person->name}}</p>
                                    <div class="profile__connections__person__details">{{$person->username}}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="profile__connections__empty">
                        Ainda ninguém o acompanha no OldSchool.
                    </div>
                @endif
            </div>

        </div>


    </main>
@endsection