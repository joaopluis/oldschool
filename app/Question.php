<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
	public function questioner(){
		return $this->belongsTo(User::class);
	}

	public function answerer(){
		return $this->belongsTo(User::class);
	}

	public function lesson(){
		return $this->belongsTo(Lesson::class);
	}
}
