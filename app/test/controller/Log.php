<?php
namespace app\test\controller;
use \Psr\Log\LogLevel;

class Log extends \lqphp\Controller
{
	public function index()
	{
		return 'Log ok';
	}

	//记录日志
	public function log()
	{
		$logger = logger();
		$logger->error('user = {user}, msg = hello!', ['user' => 'luoluolzb']);
	}

	//记录日志
	public function logwith($level)
	{
		$logger = logger();
		$logger->$level('user = {user}, msg = hello!', ['user' => 'luoluolzb']);
	}

	//获取日志文件保存路径
	public function savepath()
	{
		$logger = \lqphp\Logger::instance();
		return $logger->getSavePath(time());
	}
}
