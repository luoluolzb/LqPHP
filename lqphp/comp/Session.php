<?php
/**
 * @description Session操作类
 * @author      luoluolzb
 */
namespace lqphp\comp;

class Session extends AbstractComp
{
	/**
	 * @var object 对象实例
	 */
	protected static $instance;

	/**
	 * 构造函数
	 * 请使用 instance 方法获取实例
	 */
	public function __construct($conf = null)
	{
		parent::__construct($conf);
		session_start($this->conf);
	}

	/**
	 * 获取实例
	 * @access public
	 */
	public static function instance($conf = null)
	{
		if (is_null(self::$instance)) {
			self::$instance = new static($conf);
		}
		return self::$instance;
	}

	/**
	 * 设置一个session
	 * @param string $name  名称
	 * @param mixed  $value 值
	 */
	public function set($name, $value)
	{
		$_SESSION[$name] = $value;
		return true;
	}

	/**
	 * 获取一个session值
	 * @param  string $name 名称
	 * @return mixed        值
	 */
	public function get($name)
	{
		if (isset($_SESSION[$name])) {
			return $_SESSION[$name];
		} else {
			return null;
		}
	}

	/**
	 * 判断是否存在某个session
	 * @param  string $name 名称
	 * @return boolean
	 */
	public function has($name)
	{
		return isset($_SESSION[$name]);
	}

	/**
	 * 删除一个session
	 * @param  string $name 名称
	 * @return bool
	 */
	public function delete($name)
	{
		if (isset($_SESSION[$name])) {
			unset($_SESSION[$name]);
		}
	}

	/**
	 * 清除当前会话所有数据
	 */
	public function clear()
	{
		$_SESSION = [];
	}
}
