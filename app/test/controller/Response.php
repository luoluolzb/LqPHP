<?php
namespace app\test\controller;

class Response extends \lqphp\Controller
{
	public function index()
	{
		return 'Response ok';
	}

	//重定向测试
	public function direct()
	{
		redirect('index');
	}

	//返回上级页面测试
	public function page()
	{
		repage();
	}

	//返回错误页面
	public function error($code = 404)
	{
		$this->response->error($code);
	}

	//设置http响应码
	public function httpCode($code = 404)
	{
		$this->response->httpCode($code);
	}
}
