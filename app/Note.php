<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

	protected $fillable = ['user_id', 'companion_id'];

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function companion(){
		return $this->belongsTo(User::class, 'companion_id');
	}

	public function lesson(){
		return $this->belongsTo(Lesson::class);
	}

}
