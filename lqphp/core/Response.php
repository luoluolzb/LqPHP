<?php
/**
 * @description 客户端相应类
 * @author      luoluolzb
 */
namespace lqphp;

class Response
{
	/**
	 * @var object 对象实例
	 */
	protected static $instance;

	/**
	 * 要发送的数据
	 * @var mixed
	 */
	protected $data;

	/**
	 * 构造方法
	 */
	protected function __construct()
	{
		$this->data = null;
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
	 * 获取或设置响应数据
	 * @param  mixed  $data  数据
	 * @return mixed
	 */
	public function data($data = null)
	{
		if (isset($data)) {
			$this->data = $data;
		} else {
			return $this->data;
		}
	}

	/**
	 * 发送数据给客户端
	 */
	public function send()
	{
		if (is_null($this->data)) {
			;
		} else if (is_string($this->data)) {
			echo $this->data;
		} else if ($this->data instanceof data\DataInterface) {
			$this->data->send();
		} else {
			$type = Config::get('app.default.return_type');
			$class = '\lqphp\data\\' . ucfirst($type);
			if (class_exists($class)) {
				$obj = new $class($this->data);
				$obj->send();
			} else {
				throw new exception\TypeException("默认数据返回类型 app.default.return_type => '{$type}' 不支持");
			}
		}
	}

	/**
	 * 获取/设置http响应码
	 * @param  integer $code 
	 * @return string | bool
	 */
	public static function httpCode($code = null)
	{
		if (is_null($code)) {
			return http_response_code();
		} else {
			return http_response_code($code);
		}
	}

	/**
	 * 显示一个异常页面
	 */
	public static function error($code)
	{
		$tpl = LQPHP_PATH . 'tpl/'. $code . '.tpl';
		if (file_exists($tpl)) {
			self::httpCode($code);
			echo file_get_contents($tpl);
		}
	}

	/**
	 * 页面跳转(重定向)
	 * @param  string  $url  要跳转的url
	 * @param  integer $code 跳转码
	 */
	public static function redirect($url, $code = 302)
	{
		header('Location: '. $url, true, $code);
		exit();
	}

	/**
	 * 返回上级页面，并刷新[可选]
	 * @param  boolean $data 是否保留上页表单数据
	 */
	public static function repage($data = true)
	{
		if ($data) {
			echo "<script>window.history.go(-1);</script>";
		} else {
			echo '<script>window.history.back();</script>';
		}
		exit();
	}
}
