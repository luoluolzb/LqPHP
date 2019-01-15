<?php
/**
 * @description 数据库操作类
 * @author      luoluolzb
 */
namespace lqphp;
use \lqphp\library\Hook;
use \Medoo\Medoo;

class Db
{
	/**
	 * @var object 对象实例
	 */
	protected static $instance;

	/**
	 * 数据库操作引擎
	 * @var object
	 */
	protected $engine;

	protected function __construct()
	{
		//触发数据库初始化钩子
		Hook::trigger('db_init');
		$this->engine = new Medoo(Config::get('db'));
	}

	/**
	 * 获取实例
	 * @access public
	 */
	public static function instance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new static;
		}
		return self::$instance;
	}

	/**
	 * 获取引擎对象
	 * @return object
	 */
	public function engine()
	{
		return $this->engine;
	}

	/**
	 * 魔术方法：让此类可以调用引擎对象方法
	 * @param  string $method    方法名
	 * @param  array  $arguments 参数列表
	 * @return mixed
	 */
	public function __call($method, $arguments) 
	{
		return call_user_func_array([$this->engine, $method], $arguments);
	}
}
