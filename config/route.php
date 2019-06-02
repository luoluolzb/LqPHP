<?php
/**
 * 路由配置
 */
use lqphp\Route;
use lqphp\Comp\Captcha;
use lqphp\Comp\Session;

/**
 * Route 类注册路由
 */
Route::get('user/index/register', 'user/index/getRegister');
Route::post('user/index/register', 'user/index/postRegister');

/**
 * 数组快速注册
 */
return [
	// 全局验证码
	'captcha' => function() { 
		$captcha = new Captcha();
		$session = Session::instance();
		$session->set('captcha', $captcha->code());
		$captcha->output();
	},

	// 测试
	'hello/{name:\w+}' => function($name) {
		return sprintf('hello, %s!', $name);
	},
];
