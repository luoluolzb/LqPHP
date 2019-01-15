<?php
/**
 * @description 数据抽象接口
 * @author      luoluolzb
 */
namespace lqphp\data;

interface DataInterface
{
	/**
	 * 设置/获取数据
	 * @param  string $data
	 * @return mixed
	 */
	public function data($data = null);

	/**
	 * 渲染并发送到客户端
	 * @return bool
	 */
	public function send();

	/**
	 * 获取渲染结果
	 * @return string
	 */
	public function fetch();
}
