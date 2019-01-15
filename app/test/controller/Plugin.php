<?php
namespace app\test\controller;
use lqphp\library\Hook;

class Plugin extends \lqphp\Controller
{
	public function index()
	{
		return 'Plugin ok';
	}

	//插件操作
	public function stack()
	{
		//安装插件
		app()->plugin('Stack', function($data = null) {
			return new \util\Stack($data);
		});
		//获取插件
		$stack = app()->Stack([10, 8, 6, 4]);
		
		$stack->push(2);
		$stack->push(0);
		while (!$stack->empty()) {
			echo $stack->pop() . ' ';
		}
	}

	//测试Hook
	public function testAction()
	{
		Hook::trigger('test_action', ['name' => 'test_action']);
	}

	//测试自定义函数
	public function myfun()
	{
		return myabs(-10);
	}
}
