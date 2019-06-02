<?php
namespace app\test\controller;

class Request extends \lqphp\Controller
{
	public function index()
	{
		return 'Request ok';
	}

	// 获取请求方法
	public function method()
	{
		return method();
	}

	// 获取请求地址
	public function address()
	{
		return module() . '\\' . controller() . '@' . action();
	}

	// 获取请求信息
	public function info()
	{
		return format($this->request->info());
	}
}
