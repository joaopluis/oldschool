<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests;

class HomeController extends Controller {
	//
	public function show() {

		// TODO: Replace with actual
		$popular = new \stdClass();
		$popular->name = "Populares";
		$popular->courses = Course::whereIn( 'slug', [ 'netflix', 'email', 'homebanking-caixa' ] )->get();

		$best_rated = new \stdClass();
		$best_rated->name = "Melhor avaliados";
		$best_rated->courses = Course::whereIn( 'slug', [ 'google-maps', 'conheca-televisao-meo', 'email' ] )->get();

		$courses = [ $popular, $best_rated ];

		$breadcrumbs = array(
			action( 'HomeController@show' ) => 'Início',
		);

		return view( 'home', compact( 'breadcrumbs', 'courses' ) );

	}
}
