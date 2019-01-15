<?php
/**
 * @description 数组快速访问类
 * @author      luoluolzb
 */
namespace lqphp\library;

class ArrayAccess
{
	/**
	 * 设置或获取值
	 * @param  array  $arr   要访问的数组
	 * @param  string $name  键名
	 * @param  mixed  $value 值
	 * @return mixed
	 */
	public static function access(&$arr, $name = null, $value = null, $merge = false)
	{
		if (isset($value)) {
			return self::set($arr, $name, $value, $merge);
		} else {
			return self::get($arr, $name);
		}
	}

	/**
	 * 获取一个值
	 * @param  array  $arr  要访问的数组
	 * @param  string $name 键名
	 * @return mixed
	 */
	public static function get(&$arr, $name = null)
	{
		$data = & $arr;
		if (!isset($name)) {
			return $data;
		}
		$keys = explode('.', $name);
		if (is_array($keys)) {
			foreach ($keys as $i => $key) {
				if (isset($data[$key])) {
					$data = & $data[$key];
				} else {
					return null;
				}
			}
			return $data;
		} else {
			return @$arr[$name];
		}
	}

	/**
	 * 设置一个值
	 * @param  array  $arr   要访问的数组
	 * @param  string $name  键名
	 * @param  mixed  $value 值
	 * @return boolean
	 */
	public static function set(&$arr, $name, $value, $merge = false)
	{
		$data = & $arr;
		$keys = explode('.', $name);
		if (is_array($keys)) {
			foreach ($keys as $i => $key) {
				if (!isset($data[$key])) {
					$data[$key] = [];
				}
				$data = & $data[$key];
			}
			if (!$merge) {
				$data = $value;
			} else {
				$data = array_merge($data, $value);
			}
			return true;
		} else {
			$data[$name] = $value;
			return true;
		}
	}
}
