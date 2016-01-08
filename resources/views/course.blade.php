@extends('app')

@section('content')

    <main class="course">

        <div class="course__image">
            {!! Html::image('courses/'.$course->slug.'.png') !!}
        </div>

        <h1 class="course__name">
            {{ $course->name }}
        </h1>

        <div class="course__desc">
            {{ $course->description }}
        </div>

        <div class="course__details">
            <div class="course__achievements">
                <h3>Conquistas</h3>

                <div class="course__achievements__strip">
                    @foreach($course->achievements as $achievement)
                        <div class="course__achievement">
                            <div class="course__achievement__image">
                                {!! Html::image('courses/achievements/achievement-'.$achievement->id.'.png', $achievement->name) !!}
                            </div>
                            <div class="course__achievement__details">
                                <p class="course__achievement__name">{{$achievement->name}}</p>

                                <p class="course__achievement__desc">{{$achievement->description}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            @if($course->sponsor_name)
                <div class="course__sponsor">
                    <h3>Apoio</h3>
                    <a href="{{$course->sponsor_url}}">
                        {!! Html::image('courses/sponsors/'.$course->sponsor_slug.'.svg', $course->sponsor_name) !!}
                    </a>
                </div>
            @endif
        </div>

        <div class="course__lessons">

            @foreach($course->lessons as $lesson)
                <a href="{{action('LessonController@show', [$course->slug, $lesson->slug])}}" class="course__lesson">
                    <div class="course__lesson__image">
                        {!! Html::image('courses/lessons/'.$course->slug.'-'.$lesson->slug.'.png') !!}
                    </div>
                    <div class="course__lesson__data">
                        <h2 class="course__lesson__name">{{$lesson->name}}</h2>

                        <div class="course__lesson__desc">{{$lesson->description}}</div>

                        <div class="course__lesson__details">
                            <div class="lesson-difficulty {{$lesson->difficulty}}">
                                @if($lesson->difficulty == 'easy')
                                    Fácil
                                @elseif($lesson->difficulty == 'medium')
                                    Intermédio
                                @else
                                    Difícil
                                @endif
                            </div>
                            {{--<span class="lesson-time">5 minutos</span>--}}
                            <div class="lesson-score">
                                @include('components.stars', ['stars' => $lesson->rating])
                            </div>
                        </div>
                    </div>
                    @if(Auth::check() and Auth::user()->lessons->contains($lesson))
                        <div class="course__lesson__complete">
                            <span class="mdi mdi-check"></span>
                        </div>
                    @endif
                    <div class="course__lesson__messages">
                        @if(Auth::check() and $lesson->notes()->where( 'user_id', Auth::user()->id )->count() > 0)
                            @foreach($lesson->notes()->where( 'user_id', Auth::user()->id )->get() as $note)
                                <div class="course__lesson__message course__lesson__note">
                                    {!! Html::image($note->companion->photo, $note->companion->name) !!}
                                    <span class="mdi mdi-message-text"></span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </a>
            @endforeach

        </div>

        <section class="course__back-to-top">
            <a href="#" class="btn btn-primary">Voltar ao topo <span class="mdi mdi-arrow-up"></span></a>
        </section>

    </main>

@endsection