<?php
namespace app\user\validator;

class User extends \lqphp\Validator
{
	// 验证规则
	protected $rules = [
		'user_name' => [
			'name' => '用户名',
			'require' => true,
			'type' => 'alnum',
			'min' => 6,
			'max' => 10
		],
		'passwd' => [
			'name' => '密码',
			'require' => true,
			'type' => 'alnum',
			'min' => 6,
			'max' => 12
		],
		'captcha' => [
			'name' => '验证码',
			'require' => true,
			'type' => 'captcha',
			'captcha' => ['sessoin_name' => 'captcha', 'ignore_case' => true]
		],
	];
}
