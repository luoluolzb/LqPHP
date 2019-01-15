<?php
/**
 * @description 加载器类
 * @author      luoluolzb
 */
namespace lqphp;
use \lqphp\Validator;

class Loader extends \lqphp\library\AutoLoader
{
	/**
	 * 加载一个函数库
	 * @param  string $path
	 * @return boolean 加载成功与否
	 */
	public static function file($path)
	{
		if (file_exists($path)) {
			require($path);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 加载一个已经验证器或者创建一个验证器
	 * @param  mixed $data 已有验证器名 或 验证规则
	 * @return lqphp\Validator
	 */
	public static function validator($data = null)
	{
		if (is_string($data)) {
			$request = Request::instance();
			if (config('app.single_module')) {
				$object = sprintf('app\validator\%s', $data);
			} else {
				$object = sprintf('app\%s\validator\%s', $request->module(), $data);
			}
			return new $object;
		} else {
			return new Validator($data);
		}
	}
}
