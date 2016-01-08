<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract {
	use Authenticatable, Authorizable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [ 'name', 'username', 'email', 'password' ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ 'password', 'remember_token' ];

	public function achievements() {
		return $this->belongsToMany( Achievement::class )->orderBy( 'created_at' );
	}

	public function lessons() {
		return $this->belongsToMany( Lesson::class );
	}

	public function getPhotoAttribute() {
		$email = $this->email;
		if ( empty( $email ) ) {
			$email = $this->username . '@oldschool';
		}
		return Gravatar::src( $email, 200 );
	}

	public function setEmailAttribute( $value ) {
		$this->attributes['email'] = empty( $value ) ? null : $value;
	}

	public function accompanies() {
		return $this->belongsToMany( self::class, 'friends', 'user1_id', 'user2_id' )->where( 'companion', true )->orderBy( 'name' );
	}

	public function companions() {
		return $this->belongsToMany( self::class, 'friends', 'user2_id', 'user1_id' )->where( 'companion', true )->orderBy( 'name' );
	}

	protected function friendsOfMine() {
		return $this->belongsToMany( self::class, 'friends', 'user2_id', 'user1_id' );
	}

// friendship that I was invited to
	protected function friendOf() {
		return $this->belongsToMany( self::class, 'friends', 'user1_id', 'user2_id' );
	}

// accessor allowing you call $user->friends
	public function getFriendsAttribute() {
		if ( !array_key_exists( 'friends', $this->relations ) ) {
			$this->loadFriends();
		}

		return $this->getRelation( 'friends' );
	}

	protected function loadFriends() {
		if ( !array_key_exists( 'friends', $this->relations ) ) {
			$friends = $this->mergeFriends();

			$this->setRelation( 'friends', $friends );
		}
	}

	protected function mergeFriends() {
		return $this->friendsOfMine->merge( $this->friendOf )->sortBy('name');
	}

}
