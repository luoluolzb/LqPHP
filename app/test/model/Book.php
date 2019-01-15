<?php
namespace app\test\model;

class Book extends \lqphp\model
{
	public function user()
	{
		return $this->belongsTo('User');
	}
}
