@extends('app')

@section('content')

    <main class="all-courses">

        <h1>Todos os cursos</h1>

        <section class="all-courses__list">

            @foreach($courses as $course)
                <a href="{{ action('CourseController@show', $course->slug) }}" class="all-courses__course">
                    <div class="all-courses__course__image">
                        {!! Html::image('courses/'.$course->slug.'.png') !!}
                    </div>
                    <div class="all-courses__course__data">
                        <h2 class="all-courses__course__name">
                            {{ $course->name }}
                            @if($course->edition)
                                <small>{{$course->edition}}</small>
                            @endif
                        </h2>
                        <p class="all-courses__course__desc">
                            {{$course->description}}
                        </p>

                        <p class="all-courses__course__details">
                            <span class="course-lessons">{{count($course->lessons)}} {{(count($course->lessons) == 1) ? "lição" : "lições"}}</span>
                            {{--<span class="course-time">1:30 horas</span>--}}
                        </p>
                    </div>
                </a>
            @endforeach

        </section>

        <section class="all-courses__back-to-top">
            <a href="#" class="btn btn-primary">Voltar ao topo <span class="mdi mdi-arrow-up"></span></a>
        </section>

    </main>

@endsection