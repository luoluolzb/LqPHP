<?php
/**
 * @description 数据抽象接口
 * @author      luoluolzb
 */
namespace lqphp\data;

interface DataInterface
{
	/**
	 * 获取或者设置数据
	 * @param  string $data
	 * @return mixed
	 */
	public function data($data = null);

	/**
	 * 获取渲染结果
	 * @return string
	 */
	public function fetch();

	/**
	 * 渲染并发送到客户端
	 * 可以用 echo $this->fetch(); 实现
	 * @return boolean
	 */
	public function send();
}
