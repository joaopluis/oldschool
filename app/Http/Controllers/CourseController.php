<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests;

class CourseController extends Controller {
	//
	public function all() {

		$breadcrumbs = array(
			action( 'HomeController@show' ) => 'Início',
			action( 'CourseController@all' ) => 'Todos os cursos',
		);

		$previous = action( 'HomeController@show' );

		$courses = Course::orderBy( 'name' )->get();

		return view( 'all-courses', compact( 'breadcrumbs', 'previous', 'courses' ) );
	}

	public function show( $slug ) {
		$course = Course::where( 'slug', $slug )->firstOrFail();

		$breadcrumbs = array(
			action( 'HomeController@show' ) => 'Início',
			action( 'CourseController@all' ) => 'Cursos',
			action( 'CourseController@show', $slug ) => $course->name,
		);

		$previous = action( 'CourseController@all' );

		return view( 'course', compact( 'breadcrumbs', 'previous', 'course' ) );
	}
}
