<?php
/**
 * @description jsonp数据类
 * @author      luoluolzb
 */
namespace lqphp\data;

class Jsonp implements DataInterface
{
	/**
	 * 数据
	 * @var mixed
	 */
	protected $data;

	/**
	 * jsonp回调函数
	 * @var string
	 */
	protected $callback;

	/**
	 * 构造函数
	 * @param mixed  $data
	 * @param string $callback
	 */
	public function __construct($data = null, $callback = null)
	{
		$this->data = $data;
		if (!isset($callback)) {
			$this->callback = \lqphp\Config::get('app.default.jsonp_callback');
		} else {
			$this->callback = $callback;
		}
	}

	/**
	 * 设置/获取数据
	 * @param  string $data
	 * @return mixed
	 */
	public function data($data = null)
	{
		if (isset($data)) {
			$this->data = $data;
		} else {
			return $this->data;
		}
	}

	/**
	 * 发送数据到客户端
	 * @return bool
	 */
	public function send()
	{
		header('Content-Type: application/json');
		echo $this->fetch();
	}

	/**
	 * 获取渲染结果
	 * @return string
	 */
	public function fetch()
	{
		return $this->callback . '(' . json_encode($this->data) . ')';
	}
}
