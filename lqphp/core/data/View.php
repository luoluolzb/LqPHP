<?php
/**
 * @description 视图类
 * 可以使用模板引擎（smarty）中的变量和方法
 * @author      luoluolzb
 */
namespace lqphp\data;
use \Smarty;
use \lqphp\Config;
use \lqphp\Request;

class View implements DataInterface
{
	/**
	 * Smarty模板类
	 * @var Smartj object
	 */
	protected $engine;

	/**
	 * 模板文件
	 * @var string
	 */
	protected $tpl;

	/**
	 * 构造函数
	 */
	public function __construct($tpl = null)
	{
		$this->engine = new Smarty;
		// 加载配置文件中的配置
		$confs = Config::get('smarty');
		foreach ($confs['vars'] as $name => $value) {
			$this->engine->$name = $value;
		}
		foreach ($confs['dirs'] as $method => $value) {
			if (method_exists($this->engine, $method)) {
				call_user_func([$this->engine, $method], $value);
			}
		}

		// 配置模板目录
		$request = Request::instance();
		if (Config::get('app.multi_module')) {
			$templateDir = sprintf(
				APP_PATH . '%s/view/%s',
				$request->module(),
				$request->controller()
			);
		} else {
			$templateDir = sprintf(
				APP_PATH . 'view/%s',
				$request->controller()
			);
		}
		$this->engine->setTemplateDir($templateDir);
		
		if (is_null($tpl)) {
			$this->tpl = sprintf('%s.tpl', $request->action());
		} else {
			$this->tpl = $tpl;
		}
	}

	/**
	 * 获取模板引擎对象
	 * @return object
	 */
	public function engine()
	{
		return $this->engine;
	}

	/**
	 * 获取模板引擎变量
	 * @param  string $name  变量名
	 * @param  mixed  $value 值
	 * @return void
	 */
	public function __set($name, $value)
	{
		$this->engine->$name = $value;
	}

	/**
	 * 设置模板引擎变量
	 * @param  string $name  变量名
	 * @return mixed
	 */
	public function __get($name)
	{
		return $this->engine->$name;
	}

	/**
	 * 魔术方法：让view可以调用模板引擎方法
	 * @param  string $method  方法名
	 * @param  array  $args    参数列表
	 * @return mixed
	 */
	public function __call($method, $args)
	{
		if (method_exists($this->engine, $method)) {
			return call_user_func_array([$this->engine, $method], $args);
		}
	}

	/**
	 * 获取或设置模板文件
	 * @param  string $tpl
	 */
	public function template($tpl = null)
	{
		if (is_null($tpl)) {
			return $this->tpl;
		} else {
			$this->tpl = $tpl;
		}
	}

	/**
	 * 获取或者设置数据
	 * smarty中没有方法实现该接口
	 * @param  string $data
	 * @return void
	 */
	public function data($data = null)
	{
	}

	/**
	 * 获取渲染结果
	 * @return string
	 */
	public function fetch()
	{
		return $this->fetch($this->tpl);
	}

	/**
	 * 视图渲染输出
	 */
	public function send()
	{
		$this->engine->display($this->tpl);
	}
}
