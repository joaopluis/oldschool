@extends('app')

@section('content')
    <main class="lesson">

        <main class="lesson__main">
            <h1 class="lesson__name">
                {{$lesson->name}}
            </h1>

            <div class="lesson__top">
                @if(count($lesson->recommendedToUser()))
                    <div class="lesson__recommended">
                        <h2>Lições que pode fazer antes desta</h2>

                        @foreach($lesson->recommendedToUser() as $rec)

                            <a href="{{ action('LessonController@show', [$rec->course->slug, $rec->slug]) }}"
                               class="lesson__recommended__lesson">
                                <div class="lesson__recommended__lesson__image">
                                    {!! Html::image('courses/mini/'.$rec->course->slug.'.svg', $rec->course->name) !!}
                                </div>
                                <div class="lesson__recommended__lesson__data">
                                    <p class="lesson__recommended__lesson__name">
                                        {{$rec->name}}
                                    </p>

                                    <p class="lesson__recommended__lesson__course">
                                        {{$rec->course->name}}
                                    </p>
                                </div>
                            </a>

                        @endforeach
                    </div>
                @endif
                @if(!$notes->isEmpty() || (Auth::check() && Auth::user()->accompanies->count() > 0 ))
                    <div class="lesson__notes">
                        @unless($notes->isEmpty())
                            @foreach($notes as $note)
                                <div class="lesson__note">
                                    <div class="lesson__note__photo">
                                        {!! Html::image($note->companion->photo) !!}
                                    </div>
                                    <div class="lesson__note__content">
                                        <p class="lesson__note__author"><strong>{{$note->companion->name}}</strong>
                                            disse:
                                        </p>

                                        <p class="lesson__note__text">{{$note->note}}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endunless
                        @if(Auth::check() && Auth::user()->accompanies->count() > 0)
                            <div class="lesson__note self">
                                <div class="lesson__note__photo">
                                    {!! Html::image(Auth::user()->photo) !!}
                                </div>
                                <div class="lesson__note__content">
                                    <p class="lesson__note__author">Deixar nota para:</p>
                                    <p class="lesson__note__text">
                                        @foreach(Auth::user()->accompanies as $accompany)
                                            <a data-modal="#modal{{$accompany->id}}"
                                               class="btn btn-default btn-sm">{{ $accompany->name }}</a>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="lesson__video">
                {!! $lesson->video !!}
            </div>

            <div class="lesson__text">
                {!! $lesson->text_content !!}
            </div>

            @unless($lesson->earnedAchievements()->isEmpty())
                <div class="lesson__achievements">
                    <p>Com esta lição ganhou:</p>

                    @foreach($lesson->earnedAchievements() as $a)
                        {!! Html::image('courses/achievements/achievement-'.$a->id.'.png', $a->name) !!}
                    @endforeach
                </div>
            @endunless

            <div class="lesson__bottom">

                <div class="lesson__ratings">
                    <h2>Avaliações</h2>

                    <p class="lesson__score">
                        @include('components.stars', ['stars' => $lesson->rating])
                    </p>

                    @if(Auth::check())
                        @if($lesson->canRate())
                            <article class="lesson__rating">
                                <div class="lesson__rating__photo">
                                    {!! Html::image(Auth::user()->photo) !!}
                                </div>
                                <form action="{{action('LessonController@rate', [$lesson->course->slug, $lesson->slug])}}"
                                      method="POST" class="lesson__rating__form">
                                    {{ csrf_field() }}
                                    <div class="os__radio__group">
                                        <span class="mdi mdi-star"></span>

                                        <label><input type="radio" class="os__radio" name="rating" value="1"/> 1</label>
                                        <label><input type="radio" class="os__radio" name="rating" value="2"/> 2</label>
                                        <label><input type="radio" class="os__radio" name="rating" value="3"/> 3</label>
                                        <label><input type="radio" class="os__radio" name="rating" value="4"/> 4</label>
                                        <label><input type="radio" class="os__radio" name="rating" value="5"/> 5</label>
                                    </div>
                                <textarea class="os__field" name="comment"
                                          placeholder="Escreva a sua avaliação"></textarea>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Avaliar</button>
                                    </div>
                                </form>
                            </article>
                        @else
                            <div class="alert alert-info">Já avaliou esta lição.</div>
                        @endif
                    @else
                        <div class="alert alert-info">Tem de entrar com a sua conta para poder avaliar uma lição.</div>
                    @endif

                    @if($lesson->ratings->count() > 0)

                        <div>

                            @for($chunks = $lesson->ratings->chunk(4), $p = 1; $p <= $chunks->count(); $p++)
                                <div class="lesson__ratings__page" data-num="{{$p}}">
                                    @foreach($chunks->all()[$p - 1] as $rating)
                                        <article class="lesson__rating">
                                            <div class="lesson__rating__photo">
                                                {!! Html::image($rating->user->photo) !!}
                                            </div>
                                            <div class="lesson__rating__data">
                                                <p class="lesson__rating__author">
                                                    {{$rating->user->name}}
                                                    @if($rating->user->role == 'teacher')
                                                        <span class="badge">Professor</span>
                                                    @endif
                                                </p>

                                                <p class="lesson__rating__score">
                                                    @include('components.stars', ['stars' => $rating->rating])
                                                </p>

                                                <p class="lesson__rating__text">
                                                    {{$rating->comment}}
                                                </p>
                                            </div>
                                        </article>
                                    @endforeach
                                    <nav class="lesson__rating__pagination pagination">
                                        <a class="pagination__btn btn btn-default{!! $p == 1 ? ' disabled' : '" data-goto="'.($p-1) !!}"><span
                                                    class="mdi mdi-arrow-left"></span></a>
                                        <span class="number">Página {{$p}} de {{$chunks->count()}}</span>
                                        <a class="pagination__btn btn btn-default{!! $p == $chunks->count() ? ' disabled' : '" data-goto="'.($p+1) !!}"><span
                                                    class="mdi mdi-arrow-right"></span></a>
                                    </nav>
                                </div>
                            @endfor

                        </div>

                    @else
                        <div class="alert alert-info">Ainda não há avaliações para esta lição.</div>
                    @endif

                </div>

                <div class="lesson__qanda">
                    <h2>Dúvidas</h2>

                    <div class="lesson__qanda__tabs">
                        <a href="#" class="lqt_ans active">Respondidas</a>
                        <a href="#" class="lqt_notans">Por responder</a>
                    </div>

                    <div class="lesson__qanda__answered">
                        @if($lesson->answeredQuestions->count() > 0)

                            <div>
                                @for($chunks = $lesson->answeredQuestions->chunk(3), $p = 1; $p <= $chunks->count(); $p++)
                                    <div class="lesson__qanda__page" data-num="{{$p}}">
                                        @foreach($chunks->all()[$p - 1] as $doubt)
                                            <section class="lesson__doubt">
                                                <article class="lesson__question">
                                                    <div class="lesson__question__photo">
                                                        {!! Html::image($doubt->questioner->photo) !!}
                                                    </div>
                                                    <div class="lesson__question__data">
                                                        <p class="lesson__question__author">
                                                            {{$doubt->questioner->name}}
                                                            @if($doubt->questioner->role == 'teacher')
                                                                <span class="badge">Professor</span>
                                                            @endif
                                                        </p>

                                                        <p class="lesson__question__question">
                                                            {{$doubt->question}}
                                                        </p>
                                                    </div>
                                                </article>

                                                <article class="lesson__answer">
                                                    <div class="lesson__answer__photo">
                                                        {!! Html::image($doubt->answerer->photo) !!}
                                                    </div>
                                                    <div class="lesson__answer__data">
                                                        <p class="lesson__answer__author">
                                                            {{$doubt->answerer->name}}
                                                            @if($doubt->answerer->role == 'teacher')
                                                                <span class="badge">Professor</span>
                                                            @endif
                                                        </p>

                                                        <p class="lesson__answer__answer">
                                                            {{ $doubt->answer }}
                                                        </p>
                                                    </div>
                                                </article>
                                            </section>
                                        @endforeach

                                        @if($chunks->count() > 1 && $p == 1)
                                            <div class="lesson__qanda__not-here alert alert-info">

                                                <div class="lesson__qanda__not-here__icon">
                                                    <span class="mdi mdi-information"></span>
                                                </div>

                                                <p class="lesson__qanda__not-here__top">A sua pergunta não está
                                                    aqui?</p>

                                                <p class="lesson__qanda__not-here__bottom">Veja nas próximas
                                                    páginas!</p>
                                            </div>
                                        @endif

                                        <nav class="lesson__qanda__pagination pagination">
                                            <a class="pagination__btn btn btn-default{!! $p == 1 ? ' disabled' : '" data-goto="'.($p-1) !!}"><span
                                                        class="mdi mdi-arrow-left"></span></a>
                                            <span class="number">Página {{$p}} de {{$chunks->count()}}</span>
                                            <a class="pagination__btn btn btn-default{!! $p == $chunks->count() ? ' inactive' : '" data-goto="'.($p+1) !!}"><span
                                                        class="mdi mdi-arrow-right"></span></a>
                                        </nav>
                                    </div>

                                @endfor
                            </div>

                        @else
                            <div class="alert alert-info">Ainda não há perguntas para esta lição.</div>
                        @endif

                        @if(Auth::check())
                            <article class="lesson__question">
                                <div class="lesson__question__photo">
                                    {!! Html::image(Auth::user()->photo) !!}
                                </div>
                                <form method="post"
                                      action="{{action('LessonController@ask', [$lesson->course->slug, $lesson->slug])}}"
                                      class="lesson__question__form">
                                    {{ csrf_field() }}
                                    <textarea class="os__field" name="question"
                                              placeholder="Escreva a sua dúvida"></textarea>

                                    <p class="os__hint"><strong>Atenção</strong>: antes de colocar a sua dúvida, por
                                        favor
                                        certifique-se que não está já respondida acima ou numa das outras páginas.</p>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Perguntar</button>
                                    </div>
                                </form>
                            </article>
                        @else
                            <div class="alert alert-info">Tem de entrar com a sua conta para poder fazer uma pergunta.
                            </div>
                        @endif
                    </div>
                    <div class="lesson__qanda__not-answered">
                        @if($lesson->unansweredQuestions->count() > 0)

                            <div>
                                @foreach($lesson->unansweredQuestions as $doubt)
                                    <section class="lesson__doubt" data-question="{{$doubt->id}}">
                                        <article class="lesson__question">
                                            <div class="lesson__question__photo">
                                                {!! Html::image($doubt->questioner->photo) !!}
                                            </div>
                                            <div class="lesson__question__data">
                                                <p class="lesson__question__author">
                                                    {{$doubt->questioner->name}}
                                                    @if($doubt->questioner->role == 'teacher')
                                                        <span class="badge">Professor</span>
                                                    @endif
                                                </p>

                                                <p class="lesson__question__question">
                                                    {{$doubt->question}}
                                                </p>
                                            </div>
                                        </article>

                                        @if(Auth::check() && $doubt->answer == null)

                                            <div class="lesson__answer__btn">
                                                <a class="toggle-answer btn btn-default btn-sm">
                                                    <span class="mdi mdi-reply"></span>
                                                    Responder
                                                </a>
                                            </div>

                                            <article class="lesson__answer answer-form" style="display: none;">
                                                <div class="lesson__answer__photo">
                                                    {!! Html::image(Auth::user()->photo) !!}
                                                </div>
                                                <div class="lesson__answer__data">
                                                    <form method="post"
                                                          action="{{action('LessonController@answer', $doubt->id)}}"
                                                          class="lesson__question__form">
                                                        {{ csrf_field() }}
                                                        <textarea class="os__field" name="answer"
                                                                  placeholder="Escreva a sua resposta"></textarea>

                                                        <p class="os__hint">A sua resposta terá primeiro de ser
                                                            aprovada.</p>

                                                        <div class="text-right">
                                                            <button type="submit" class="btn btn-primary">
                                                                Responder
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </article>

                                        @endif

                                        @if($doubt->answer)
                                            <p class="os__hint" style="text-align: right;">A resposta a esta
                                                pergunta está pendente de moderação.</p>
                                        @endif
                                    </section>
                                @endforeach
                            </div>

                        @else
                            <div class="alert alert-info">Não há perguntas por responder para esta lição.</div>
                        @endif
                    </div>
                </div>
            </div>

        </main>

        <aside class="lesson__chat">
            Chat
        </aside>

    </main>

    @if(Auth::check() && Auth::user()->accompanies->count() > 0)
        @foreach(Auth::user()->accompanies as $accompany)
            <div class="modal" id="modal{{$accompany->id}}">
                <header class="modal__header">
                    <h1 class="modal__title">Deixar nota para <b>{{$accompany->name}}</b></h1>
                    <div class="modal__dismiss dismiss-modal">
                        <div class="mdi mdi-close"></div>
                    </div>
                </header>
                <form method="post"
                      action="{{action('LessonController@note', [$lesson->course->slug, $lesson->slug])}}"
                      class="lesson__question__form">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{$accompany->id}}">
                    <main class="modal__body">
                        <textarea class="os__field" name="message"
                                  placeholder="Escreva a sua nota">{{--
                            --}}{{ $lesson->notes()->where('user_id', $accompany->id)->where('companion_id', Auth::user()->id)->firstOrNew([])->note }}{{--
                    --}}</textarea>
                    </main>
                    <footer class="modal__footer text-right">
                        <button type="submit" class="btn btn-primary">Deixar nota</button>
                    </footer>
                </form>
            </div>
        @endforeach
    @endif

@endsection

@section('scripts')
    $('.lesson__rating__pagination .pagination__btn[data-goto]').click(function (e) {
    e.preventDefault();
    var obj = $(this);
    $('.lesson__ratings__page').hide();
    $('.lesson__ratings__page[data-num=' + obj.attr('data-goto') + ']').show();
    });

    $('.lesson__qanda__pagination .pagination__btn[data-goto]').click(function (e) {
    e.preventDefault();
    var obj = $(this);
    $('.lesson__qanda__page').hide();
    $('.lesson__qanda__page[data-num=' + obj.attr('data-goto') + ']').show();
    });

    $('.lqt_ans').click(function (e) {
    e.preventDefault();
    $('.lqt_notans').removeClass('active');
    $('.lqt_ans').addClass('active');
    $('.lesson__qanda__not-answered').hide();
    $('.lesson__qanda__answered').show();
    $('.lesson__qanda__page').hide();
    $('.lesson__qanda__page[data-num=1]').show();
    });

    $('.lqt_notans').click(function (e) {
    e.preventDefault();
    $('.lqt_notans').addClass('active');
    $('.lqt_ans').removeClass('active');
    $('.lesson__qanda__not-answered').show();
    $('.lesson__qanda__answered').hide();
    $('.lesson__qanda__page').hide();
    $('.lesson__qanda__page[data-num=1]').show();
    });

    $('.toggle-answer').click(function (e) {
    e.preventDefault();
    var parent = $(this).parents('.lesson__doubt');
    parent.find('.answer-form').toggle();
    });

    $('textarea').autogrow();

    /** TRIGGER MODALS **/
    $.fn.modal = function() {
    return this.bPopup({
    closeClass: 'dismiss-modal',
    zIndex: 100005
    });
    };

    $(document).on( 'click', '*[data-modal]', function(){
    var modalName = $(this).attr('data-modal');
    var modal = $(modalName).modal();
    });
@endsection
