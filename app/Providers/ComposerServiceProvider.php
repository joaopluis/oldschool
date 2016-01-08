<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		view()->composer( 'auth/login', function ( $view ) {
			$breadcrumbs = array(
				action( 'HomeController@show' ) => 'Início',
				action( 'Auth\AuthController@getLogin' ) => 'Entrar',
			);

			$previous = action( 'HomeController@show' );

			$view->with( compact( 'breadcrumbs', 'previous' ) );
		} );

		view()->composer( 'auth/register', function ( $view ) {
			$breadcrumbs = array(
				action( 'HomeController@show' ) => 'Início',
				action( 'Auth\AuthController@getRegister' ) => 'Registo',
			);

			$previous = action( 'HomeController@show' );

			$view->with( compact( 'breadcrumbs', 'previous' ) );
		} );

		view()->composer( 'errors/404', function ( $view ) {
			$breadcrumbs = array(
				action( 'HomeController@show' ) => 'Início',
				'#' => 'Página não encontrada',
			);

			$previous = action( 'HomeController@show' );

			$view->with( compact( 'breadcrumbs', 'previous' ) );
		} );
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
