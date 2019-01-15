<?php
/**
 * @description Hook行为接口
 * @author      luoluolzb
 */
namespace lqphp\library;

interface ActionInterface
{
	/**
	 * 执行行为
	 * 实现者在此函数中实现行为的具体操作
	 */
	public function exec();
}
