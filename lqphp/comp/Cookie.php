<?php
/**
* @description Cookie操作类
* @author      luoluolzb
*/
namespace lqphp\comp;
use \lqphp\Config;
use \lqphp\library\Authcode;

class Cookie extends AbstractComp
{
	/**
	* @var object 对象实例
	*/
	protected static $instance;

	/**
	* 加密密匙
	* @var string
	*/
	protected static $key;

	/**
	* 构造函数
	* 请使用 instance 方法获取实例
	*/
	public function __construct($conf = null)
	{
		parent::__construct($conf);
		self::$key = Config::get('app.key');
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
	* 设置一个cookie
	* @param string $name  名称
	* @param mixed  $value 值
	*/
	public function set($name, $value)
	{
		if ($this->conf['encrypt']) {
			$value = Authcode::encode(json_encode($value), self::$key);
		} else {
			$value = json_encode($value);
		}
		$expire = $this->conf['expire'] != 0 ? time() + $this->conf['expire']: 0;
		setcookie($name, $value, $expire, $this->conf['path'], $this->conf['domain'], $this->conf['secure'], $this->conf['httponly']);
	}

	/**
	* 获取一个cookie值
	* @param  string $name 名称
	* @return mixed        值
	*/
	public function get($name = null)
	{
		if ($this->has($name)) {
			if ($this->conf['encrypt']) {
				return json_decode(Authcode::decode($_COOKIE[$name], self::$key), true);
			} else {
				return json_decode($_COOKIE[$name], true);
			}
		} else {
			return null;
		}
	}

	/**
	* 判断是否存在某个cookie
	* @param  string $name 名称
	* @return boolean
	*/
	public function has($name)
	{
		return isset($_COOKIE[$name]);
	}

	/**
	* 删除一个cookie
	* @param  string $name 名称
	* @return bool
	*/
	public function delete($name)
	{
		setcookie($name, '', time() - 3600,
			$this->conf['path'],
			$this->conf['domain'],
			$this->conf['secure'],
			$this->conf['httponly']
		);
	}

	/**
	* 清除所有cookie
	*/
	public function clear()
	{
		foreach ($_COOKIE as $name => $value) {
			$this->delete($name);
		}
	}
}
