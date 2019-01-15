<?php
namespace app\test\controller;

class Route extends \lqphp\Controller
{
	public function index()
	{
		return 'Route ok';
	}

	public function age($age = null)
	{
		if (isset($age)) {
			return sprintf('your are %d years old.', $age);
		} else {
			return sprintf('please input your age.');
		}
	}

	public function page($index = 1)
	{
		return format($index);
	}

	public function time()
	{
		$t = microtime(true) - LQPHP_START_TIME;
        $mem = (memory_get_usage() - LQPHP_START_MEM) / 1024;
		return sprintf("Memeory = %lfK, Time = %fms", $mem, $t / 1000);
	}

	//测试后缀，请先配置 app.url_suffix
	public function suffix($arg = 'no argument')
	{
		return $arg;
	}
}
