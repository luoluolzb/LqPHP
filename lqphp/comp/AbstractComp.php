<?php
/**
 * @description 组件抽象父类
 * @author      luoluolzb
 */
namespace lqphp\comp;
use \lqphp\Config;
use \lqphp\library\ArrayAccess;

abstract class AbstractComp
{
	/**
	 * 配置参数
	 * @var array
	 */
	protected $conf = [];

	/**
	 * 构造函数
	 * @param array $conf 配置参数
	 */
	public function __construct($conf = null)
	{
		//获取配置名
		$class = implode('', array_slice(explode('\\',  get_class($this)), -1));
		$fileConf = Config::get(strtolower($class));
		if (isset($fileConf)) {
			$this->conf = $fileConf;
		}
		if (isset($conf)) {
			$this->conf = array_merge($this->conf, $conf);
		}
	}

	/**
	 * 获取配置参数
	 * @param  string $name  参数名
	 */
	public function conf($name = null)
	{
		return ArrayAccess::get($this->conf, $name);
	}
}
