<?php
/**
* @description 配置类
* @author      luoluolzb
*/
namespace lqphp;
use lqphp\library\ArrayAccess;

class Config
{
	/**
	 * 配置数据
	 * @var array
	 */
	protected static $data = [];

	/**
	 * 获取一个配置
	 * @param  string $name  键名
	 * @return mixed
	 */
	public static function get($name = null)
	{
		return ArrayAccess::get(self::$data, $name);
	}

	/**
	 * 设置一个配置
	 * @param  string $name  键名
	 * @param  string $value 值
	 * @return boolean
	 */
	public static function set($name, $value, $merge = false)
	{
		return ArrayAccess::set(self::$data, $name, $value, $merge);
	}

	/**
	 * 数据访问
	 * @param  string $name  键名
	 * @param  string $value 值
	 * @return mixed
	 */
	public static function access($name = null, $value = null, $merge = false)
	{
		return ArrayAccess::access(self::$data, $name, $value, $merge);
	}

	/**
	 * 加载配置文件并合并到现有配置
	 * @param  $path   导入目录
	 * @return boolean 导入成功与否
	 */
	public static function load($file)
	{
		if (!is_file($file)) {
			return false;
		}
		$path_parts = pathinfo($file);
		if (is_null($path_parts['extension']) || 'php' != $path_parts['extension']) {
			return false;
		}
		$key = $path_parts['filename'];
		if (isset(self::$data[$key])) {
			self::$data[$key] = array_merge(self::$data[$key], require($file));
		} else {
			self::$data[$key] = require($file);
		}
		return true;
	}

	/**
	 * 导入配置目录
	 * @param  $path   导入目录
	 * @return boolean 导入成功与否
	 */
	public static function import($path)
	{ 
		if (!file_exists($path) || !($handle = opendir($path))) {
			return false;
		}
		while (false !== ($filename = readdir($handle))) {
			if ($filename === '.' || $filename === '..') {
				continue;
			}
			self::load($path . $filename);
		}
		return true;
	}
}
