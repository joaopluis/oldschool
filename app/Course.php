<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //

	public function lessons(){
		return $this->hasMany(Lesson::class)->orderBy('order');
	}

	public function achievements(){
		return $this->hasMany(Achievement::class);
	}
}
