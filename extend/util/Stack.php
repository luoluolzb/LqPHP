<?php
/**
 * 栈操作类
 * @author luoluolzb
 */
namespace util;

class Stack
{
	/**
	 * 数据
	 * @var array
	 */
	protected $data;

	/**
	 * 构造函数
	 * @param array $data 初始栈内数据
	 */
	public function __construct($data = null)
	{
		$this->data = is_null($data) ? [] : $data;
	}

	/**
	 * 数据入栈
	 * @param  mixed $value 数据值
	 */
	public function push($value)
	{
		$this->data[] = $value;
	}

	/**
	 * 出栈
	 * @return mixed 栈顶数据
	 */
	public function pop()
	{
		return array_pop($this->data);
	}

	/**
	 * 获取栈顶数据
	 * @return mixed
	 */
	public function top()
	{
		return end($this->data);
	}

	/**
	 * 栈数据长度
	 * @return integer
	 */
	public function size()
	{
		return count($this->data);
	}

	/**
	 * 判断栈是否为空
	 * @return bool
	 */
	public function empty()
	{
		return false == (bool)$this->data;
	}
}
