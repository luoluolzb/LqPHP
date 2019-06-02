<?php
namespace app\test\controller;

class Data extends \lqphp\Controller
{
	/**
	 * 测试数据
	 */
	public $testData = [
		'errcode' => 0,
		'list' => [1, 2, 3],
		'str' => 'LqPHP',
	];

	public function index()
	{
		return 'Data ok';
	}
  
	// 不返回数据，直接输出
	public function none()
	{
		echo format($this->testData);
	}
	
	// 返回xml数据测试
	public function xml()
	{
		return xml($this->testData);
	}

	// 返回json数据测试
	public function json()
	{
		return json($this->testData);
	}

	// 返回jsonp数据测试
	public function jsonp()
	{
		return jsonp($this->testData);
	}

	// 返回字符串
	public function string()
	{
		return format($this->testData);
	}

	// 直接返回数据，自动格式化
	public function default()
	{
		return $this->testData;
	}

	// 制定格式进行格式化数据
	public function format($f = 'json')
	{
		return call_user_func([$this, $f]);
	}
}
