<?php
/**
 * @description 视图类
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
		$this->engine = new Smarty();
		$request = Request::instance();
		if (Config::get('app.multi_module')) {
			$this->engine->setTemplateDir(sprintf(
				APP_PATH . '%s/view/%s',
				$request->module(),
				$request->controller()
			));
		} else {
			$this->engine->setTemplateDir(sprintf(
				APP_PATH . 'view/%s',
				$request->controller()
			));
		}
		$this->engine->setCompileDir(RUNTIME_PATH . 'smarty/templates_c/');
		$this->engine->setConfigDir(RUNTIME_PATH . 'smarty/configs/');
		$this->engine->setCacheDir(RUNTIME_PATH . 'smarty/cache/');
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
	 * 魔术方法：让view可以调用模板引擎方法
	 * @param  string $method    方法名
	 * @param  array  $arguments 参数列表
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		if (method_exists($this->engine, $method)) {
			return call_user_func_array([$this->engine, $method], $arguments);
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
	 * 设置/获取数据
	 * @param  string $data
	 * @return mixed
	 */
	public function data($data = null)
	{
	}

	/**
	 * 视图渲染输出
	 */
	public function send()
	{
		$this->engine->display($this->tpl);
	}

	/**
	 * 获取渲染结果
	 * @return string
	 */
	public function fetch()
	{
		return $this->fetch($this->tpl);
	}
}
