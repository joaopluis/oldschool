<?php

namespace App;

use Embera\Embera;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Lesson extends Model {
	//
	const RATING_PRECISION = 1;

	public function course() {
		return $this->belongsTo( Course::class );
	}

	public function recommended() {
		return $this->belongsToMany( Lesson::class, 'recommendations', 'parent_id', 'child_id' )->orderBy( 'order' );
	}

	public function recommendedToUser() {
		if ( Auth::check() ) {
			return $this->recommended()->whereNotIn( 'id', Auth::user()->lessons->pluck( 'id' ) )->get();
		} else {
			return $this->recommended;
		}
	}

	public function notes() {
		return $this->hasMany( Note::class );
	}

	public function ratings() {
		return $this->hasMany( Rating::class );
	}

	public function getRatingAttribute() {
		$avg = $this->ratings()->avg( 'rating' );
		if ( !is_numeric( $avg ) ) {
			$avg = 0;
		}
		return round( $avg, self::RATING_PRECISION );
	}

	public function canRate() {
		return $this->ratings()->where( 'user_id', Auth::user()->id )->count() < 1;
	}

	public function questions() {
		return $this->hasMany( Question::class );
	}

	public function answeredQuestions() {
		return $this->questions()->where( 'approved', true );
	}

	public function unansweredQuestions() {
		return $this->questions()->where( 'approved', false );
	}

	public function getVideoAttribute() {
		$embera = new Embera( array(
			'params' => array(
				'width' => 800,
				'height' => 420
			)
		) );

		return $embera->autoEmbed( $this->video_url );
	}

	public function earnedAchievements() {

		if ( empty( $this->earned ) ) {

			if ( Auth::check() ) {

				$from_lesson = $this->course->achievements()->where( 'lesson_id', $this->id )->get();

				$from_num_lessons = [ ];

				$fnl = $this->course->achievements()->whereNotNull( 'num_lessons' )->get();

				foreach ( $fnl as $a ) {
					if ( Auth::user()->lessons()->where( 'course_id', $this->course->id )->count() >= $a->num_lessons ) {
						$from_num_lessons[] = $a;
					}
				}


				$achievements = array_merge( $from_lesson->all(), $from_num_lessons );

				//$own_achievements = Auth::user()->achievements;

				$earned = [ ];

				foreach ( $achievements as $a ) {
					if ( Auth::user()->achievements()->where( 'achievement_id', $a->id )->count() == 0 ) {
						$earned[] = $a;
					}
				}

				foreach ( $earned as $a ) {
					Auth::user()->achievements()->attach( $a->id );
				}
				$this->earned = $earned;
				return collect( $earned );

			} else {
				return collect( [ ] );
			}
		} else {
			return collect( $this->earned );
		}
	}
}
