<?php
/**
* @description 应用类
* @author      luoluolzb
*/
namespace lqphp;
use lqphp\library\Hook;
use lqphp\exception\ClassNotFound;

class App
{
	/**
	 * @var object 对象实例
	 */
	protected static $instance;

	/**
	 * 插件类列表
	 * @var array
	 */
	protected $plugins = [];

	/**
	 * 构造函数
	 */
	protected function __construct()
	{
		// 读取应用配置文件
		Config::import(CONFIG_PATH);
		
		// 时区设置
		date_default_timezone_set(Config::get('app.timezone'));

		// 注册错误处理
		Error::register();

		// 导入hook
		Hook::import(Config::get('hook'));

		// 触发应用初始化钩子
		Hook::trigger('app_init');

		// 加载助手函数库
		if (Config::get('app.helper_fun')) {
			Loader::file(LQPHP_PATH . 'helper.php');
		}
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
	 * 析构函数
	 */
	public function __destruct()
	{
		// 保存日志
		Logger::instance()->save();

		// 触发应用结束钩子
		Hook::trigger('app_end');
	}

	/**
	 * 运行应用
	 */
	public function run()
	{
		// 实例化路由
		$route = Route::instance();

		// 导入配置路由
		$route->import(Config::get('route'));

		// 加载应用自定义文件
		Loader::file(APP_PATH . 'handle.php');

		// 路由调度
		$route->dispatch();

		// 发送数据
		Response::instance()->send();
	}

	/**
	 * 注册一个插件
	 * @param  string $name    插件名称
	 * @param  object $fun     插件类实例化函数
	 */
	public function plugin($name, $fun)
	{
		$this->plugins[$name] = $fun;
	}

	/**
	 * 魔术方法：获取插件类实例
	 * @param  string $name      插件名称
	 * @return mixed
	 */
	public function __call($name, $args)
	{
		if (isset($this->plugins[$name])) {
			return call_user_func_array($this->plugins[$name], $args);
		} else {
			throw new ClassNotFound("插件 '{$name}' 不存在");
		}
	}
}
