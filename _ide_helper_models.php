<?php
/**
 * An helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Achievement
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $course_id
 * @property integer $num_lessons
 * @property integer $lesson_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Achievement whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Achievement whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Achievement whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Achievement whereCourseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Achievement whereNumLessons($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Achievement whereLessonId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Achievement whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Achievement whereUpdatedAt($value)
 */
	class Achievement {}
}

namespace App{
/**
 * App\Course
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $edition
 * @property string $description
 * @property string $sponsor_name
 * @property string $sponsor_slug
 * @property string $sponsor_url
 * @property-read \Illuminate\Database\Eloquent\Collection|Lesson[] $lessons
 * @property-read \Illuminate\Database\Eloquent\Collection|Achievement[] $achievements
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereEdition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereSponsorName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereSponsorSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereSponsorUrl($value)
 */
	class Course {}
}

namespace App{
/**
 * App\Lesson
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property string $video_url
 * @property string $text_content
 * @property string $difficulty
 * @property integer $course_id
 * @property integer $order
 * @property-read Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection|Lesson[] $recommended
 * @property-read \Illuminate\Database\Eloquent\Collection|Note[] $notes
 * @property-read \Illuminate\Database\Eloquent\Collection|Rating[] $ratings
 * @property-read mixed $rating
 * @property-read \Illuminate\Database\Eloquent\Collection|Question[] $questions
 * @property-read mixed $video
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson whereVideoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson whereTextContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson whereDifficulty($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson whereCourseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson whereOrder($value)
 */
	class Lesson {}
}

namespace App{
/**
 * App\Note
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $companion_id
 * @property integer $lesson_id
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $user
 * @property-read User $companion
 * @property-read Lesson $lesson
 * @method static \Illuminate\Database\Query\Builder|\App\Note whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Note whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Note whereCompanionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Note whereLessonId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Note whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Note whereUpdatedAt($value)
 */
	class Note {}
}

namespace App{
/**
 * App\Question
 *
 * @property integer $id
 * @property string $question
 * @property string $answer
 * @property boolean $approved
 * @property integer $lesson_id
 * @property integer $questioner_id
 * @property integer $answerer_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $questioner
 * @property-read User $answerer
 * @property-read Lesson $lesson
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereAnswer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereApproved($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereLessonId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereQuestionerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereAnswererId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereUpdatedAt($value)
 */
	class Question {}
}

namespace App{
/**
 * App\Rating
 *
 * @property integer $id
 * @property boolean $rating
 * @property string $comment
 * @property integer $lesson_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $user
 * @property-read Lesson $lesson
 * @method static \Illuminate\Database\Query\Builder|\App\Rating whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rating whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rating whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rating whereLessonId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rating whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rating whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rating whereUpdatedAt($value)
 */
	class Rating {}
}

namespace App{
/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $role
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Achievement[] $achievements
 * @property-read \Illuminate\Database\Eloquent\Collection|Lesson[] $lessons
 * @property-read mixed $photo
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 */
	class User {}
}

