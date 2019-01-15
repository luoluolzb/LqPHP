<?php
namespace app\test\model;

class User extends \lqphp\model
{
	public function book()
	{
		return $this->hasOne('Book');
	}

	public function books()
	{
		return $this->hasMany('Book', 'id', 'user_id');
	}

	public function role()
	{
		return $this->belongsToMany('Role', 'UserRole');
	}
}
