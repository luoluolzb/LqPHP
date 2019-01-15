<?php
namespace app\test\model;

class Role extends \lqphp\model
{
	public function user()
	{
		return $this->belongsToMany('User', 'UserRole');
	}
}
