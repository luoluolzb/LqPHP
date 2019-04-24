<?php
/**
 * @description json数据类
 * @author      luoluolzb
 */
namespace lqphp\data;

class Json implements DataInterface
{
	/**
	 * 数据
	 * @var mixed
	 */
	protected $data;

	/**
	 * 构造函数
	 * @param mixed $data
	 */
	public function __construct($data = null)
	{
		$this->data = $data;
	}

	/**
	 * 获取或者设置数据
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
	 * 获取渲染结果
	 * @return string
	 */
	public function fetch()
	{
		return json_encode($this->data);
	}

	/**
	 * 发送数据到客户端
	 * @return boolean
	 */
	public function send()
	{
		header('Content-Type: application/json');
		echo $this->fetch();
	}
}
