<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests;
use App\Lesson;
use App\Note;
use App\Question;
use App\Rating;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller {

	public function show( $courseSlug, $lessonSlug ) {

		$lesson = Course::where( 'slug', $courseSlug )->firstOrFail()->lessons->where( 'slug', $lessonSlug )->first();

		if ( Auth::check() ) {
			if ( !Auth::user()->lessons->contains( $lesson ) ) {
				Auth::user()->lessons()->attach( $lesson->id );
			}
			$notes = $lesson->notes()->where( 'user_id', Auth::user()->id )->get();

			$own_notes = $lesson->notes()->where( 'companion_id', Auth::user()->id )->get();
		} else {
			$notes = new Collection();
		}

		$breadcrumbs = array(
			action( 'HomeController@show' ) => 'Início',
			action( 'CourseController@all' ) => 'Cursos',
			action( 'CourseController@show', $courseSlug ) => $lesson->course->name,
			action( 'LessonController@show', [ $courseSlug, $lessonSlug ] ) => $lesson->name,
		);

		$previous = action( 'CourseController@show', $courseSlug );

		return view( 'lesson', compact( 'breadcrumbs', 'previous', 'lesson', 'notes' ) );

	}

	public function rate( Request $request, $courseSlug, $lessonSlug ) {
		$this->validate( $request, [
			'rating' => 'required|numeric|between:1,5',
			'comment' => 'required',
		] );

		$course = Course::where('slug', $courseSlug)->firstOrFail();

		$lesson = Lesson::where('slug', $lessonSlug)->where('course_id', $course->id)->firstOrFail();

		$rating = new Rating();
		$rating->lesson_id = $lesson->id;
		$rating->user_id = Auth::user()->id;
		$rating->rating = $request->rating;
		$rating->comment = $request->comment;

		$rating->save();

		return redirect(action('LessonController@show', [$courseSlug, $lessonSlug]));
	}

	public function ask(Request $request, $courseSlug, $lessonSlug ) {
		$this->validate( $request, [
				'question' => 'required',
		] );

		$course = Course::where('slug', $courseSlug)->firstOrFail();

		$lesson = Lesson::where('slug', $lessonSlug)->where('course_id', $course->id)->firstOrFail();

		$question = new Question();
		$question->questioner_id = Auth::user()->id;
		$question->lesson_id = $lesson->id;
		$question->question = $request->question;

		$question->save();

		return redirect(action('LessonController@show', [$courseSlug, $lessonSlug]));
	}

	public function answer(Request $request, $questionId){
		$this->validate( $request, [
				'answer' => 'required',
		] );

		$question = Question::where('id', $questionId)->firstOrFail();

		if(empty($question->answer)){
			$question->answerer_id = Auth::user()->id;
			$question->answer = $request->answer;

			if(Auth::user()->role == 'teacher'){
				$question->approved = true;
			}

			$question->save();
		}

		return redirect(action('LessonController@show', [$question->lesson->course->slug, $question->lesson->slug]));
	}

	public function note(Request $request, $courseSlug, $lessonSlug){

		$course = Course::where('slug', $courseSlug)->firstOrFail();

		$lesson = Lesson::where('slug', $lessonSlug)->where('course_id', $course->id)->firstOrFail();

		$user = User::findOrFail($request->user_id);

		if(!Auth::user()->accompanies->contains($user)){
			abort(403);
		}

		$note = $lesson->notes()->firstOrNew(['user_id' => $user->id, 'companion_id' => Auth::user()->id]);

		if(empty($request->message)){
			$note->delete();
		} else {
			$note->note = $request->message;
			$note->save();
		}

		return back();

	}

}
