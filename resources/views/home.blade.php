@extends('app')

@section('content')
    <main class="homepage">

        @foreach($courses as $category)
            <section class="homepage__course-strip">
                <h2>{{ $category->name }}</h2>

                <div class="homepage__course-strip__courses">

                    @foreach($category->courses as $course)

                    <a href="{{ action('CourseController@show', $course->slug) }}" class="homepage__course-strip__course">
                        <div class="homepage__course-strip__course__image">
                            {!! Html::image('courses/'.$course->slug.'.png') !!}
                        </div>
                        <div class="homepage__course-strip__course__data">
                            <h3 class="homepage__course-strip__course__name">
                                {{ $course->name }}
                            </h3>

                            <p class="homepage__course-strip__course__details">
                                <span class="course-lessons">{{count($course->lessons)}} {{(count($course->lessons) == 1) ? "lição" : "lições"}}</span>
                                {{--<span class="course-time">1:30 horas</span>--}}
                            </p>
                        </div>
                    </a>

                    @endforeach
                </div>
            </section>
        @endforeach

            <section class="homepage__all-courses">
                <a href="{{action('CourseController@all')}}" class="btn btn-primary">
                    Ver todos os cursos <span class="mdi mdi-arrow-right"></span>
                </a>
            </section>

    </main>
@endsection