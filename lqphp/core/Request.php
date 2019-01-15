<?php
/**
 * @description 客户端请求类
 * @author      luoluolzb
 */
namespace lqphp;

class Request
{
	/**
	 * @var object 对象实例
	 */
	protected static $instance;

	/**
	 * 请求信息
	 * @var array
	 */
	protected $info;

	/**
	 * 请求方法和路由变量
	 * @var array 
	 */
	protected $vars;

	/**
	 * 请求地址：模块/控制器/方法
	 * @var string
	 */
	protected $module;
	protected $controller;
	protected $action;

	/**
	 * 构造函数
	 */
	protected function __construct()
	{
		$url = rawurldecode($_SERVER['REQUEST_URI']);
		$this->info           = parse_url($url);
		$this->info['method'] = $_SERVER['REQUEST_METHOD'];
		$this->info['url']    = $url;
		$this->vars = [
			'param'  => [],
			'server' => &$_SERVER,
			'get'    => &$_GET,
			'post'   => &$_POST,
			'files'  => &$_FILES,
		];

		if (!Config::get('app.single_module')) {
			$this->module = Config::get('app.default.module');
		} else {
			$this->module = '';
		}
		$this->controller = Config::get('app.default.controller');
		$this->action     = Config::get('app.default.action');
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
	 * 魔术方法：获取 请求信息或请求变量
	 * @param  string $name  请求信息名称或请求变量名称
	 * @param  array  $args  
	 * @return string
	 */
	public function __call($name, $args)
	{
		//获取请求变量
		if(isset($this->vars[$name])) {
			$var = &$this->vars[$name];
			if (!isset($args[0])) {
				return $var;
			} else if(isset($args[1])) {
				return isset($var[$args[0]]) ? $var[$args[0]] : $args[1];
			} else {
				return isset($var[$args[0]]) ? $var[$args[0]] : null;
			}
		}
		//获取请求信息
		if (isset($this->info[$name])) {
			return $this->info[$name];
		}
	}

	/**
	 * 获取请求方法 或 判断是否为预期方法
	 * @param  string $target 预期方法(忽略大小写)
	 * @return mixed
	 */
	public function method($target = null)
	{
		if (isset($target)) {
			return 0 == strcasecmp($this->info['method'], $target);
		}
		return $this->info['method'];
	}

	/**
	 * 获取请求信息
	 * @return array
	 */
	public function info($name = null)
	{
		if (is_null($name)) {
			return $this->info;
		} else {
			return @$this->info[$name];
		}
	}

	/**
	 * 获取请求module
	 * @return string
	 */
	public function module()
	{
		return $this->module;
	}

	/**
	 * 获取请求controller
	 * @return string
	 */
	public function controller()
	{
		return $this->controller;
	}

	/**
	 * 获取请求action
	 * @return string
	 */
	public function action()
	{
		return $this->action;
	}

	/**
	 * 设置路由解析的参数
	 * @param array $data
	 */
	public function set($data)
	{
		if(isset($data['module']))  {
			$this->module = $data['module'];
		}
		if(isset($data['controller']))  {
			$this->controller = $data['controller'];
		}
		if(isset($data['action']))  {
			$this->action = $data['action'];
		}
		if(isset($data['param']))  {
			$this->vars['param'] = $data['param'];
		}
	}
}
