<?php
/**
 * @description 路由类
 * @author      luoluolzb
 */
namespace lqphp;
use \FastRoute\RouteCollector;
use \FastRoute\Dispatcher as RouteDispatcher;
use lqphp\exception\ControllerNotFound;
use lqphp\exception\ModuleNotFound;
use lqphp\exception\ActionNotFound;

class Route
{
	/**
	 * @var object 对象实例
	 */
	protected static $instance;

	/**
	 * 请求对象
	 * @var Request
	 */
	protected $request;

	/**
	* 响应对象
	* @var Response
	*/
	protected $response;

	/**
	 * fast-route调度器
	 * @var \FastRoute\simpleDispatcher
	 */
	protected $dispatcher;

	/**
	 * 路由规则
	 * @var array
	 */
	protected static $rules = [
	// 'pattern1' => [
	//     'method1' => 'handler1',
	//     'method1' => 'handler2',
	// ],
	];

	/**
	 * 支持的请求方法
	 * @var string
	 */
	protected static $support_methods = [
		'GET', 'POST', 'PUT',
		'PATCH', 'DELETE', 'COPY',
		'HEAD', 'OPTIONS', 'LINK',
		'UNLINK', 'PURGE', 'LOCK',
		'UNLOCK', 'PROPFIND', 'VIEW',
	];

	/**
	 * 构造函数
	 */
	protected function __construct()
	{
		$this->request  = Request::instance();
		$this->response = Response::instance();
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
	 * 添加路由规则
	 */
	public static function rule($method, $pattern, $handler)
	{
		$method = strtoupper($method);
		self::$rules[$pattern][$method] = $handler;
	}

	/**
	 * 添加所有方法的路由规则
	 */
	public static function all($pattern, $handler)
	{
		foreach (self::$support_methods as $method) {
			self::rule($method, $pattern, $handler);
		}
	}

	/**
	 * 魔术方法：使之可以用 get,post等方法添加路由规则
	 */
	public static function __callStatic($method, $args)
	{
		$method = strtoupper($method);
		if (in_array($method, self::$support_methods)) {
			self::rule($method, $args[0], $args[1]);
		}
	}

	/**
	 * 批量导入路由规则
	 * @param  array $configs 路由配置
	 */
	public function import($data)
	{
		foreach ($data as $pattern => $val) {
			if (is_string($val) || is_callable($val)) {
				self::all($pattern, $val);
			} else if (is_array($val)) {
				self::rule($val[0], $pattern, $val[1]);
			}
		}
	}

	/**
	 * 路由调度
	 */
	public function dispatch()
	{
		$rules = &self::$rules;
		$allMethod = &self::$support_methods;
		$multi_module = Config::get('app.multi_module');
		$multi_controller = Config::get('app.multi_controller');
		$url_suffix = Config::get('app.url_suffix');

		$this->dispatcher = \FastRoute\simpleDispatcher(
		function(RouteCollector $r) use ($rules, $allMethod) {
			foreach ($rules as $pattern => &$vals) {
				if (!empty($url_suffix)) {
					$pattern = '/' . $pattern . $url_suffix;
				} else {
					$pattern = '/' . $pattern;
				}
				foreach ($vals as $method => $handler) {
					$r->addRoute($method, $pattern, $handler);
				}
			}
		});

		$info = $this->dispatcher->dispatch(
			$this->request->method(),
			$this->request->path()
		);

		switch ($info[0]) {
			case RouteDispatcher::NOT_FOUND:
				$pathinfo = $this->request->path();
				if (!empty($url_suffix)) {
					$len = strlen($pathinfo) - strlen($url_suffix);
					$pathinfo = substr($pathinfo, 0, $len);
				}
				if ($pathinfo != '/') {
						$args = array_slice(explode('/', $pathinfo), 1);
						$count = count($args);
						if (!$multi_module && !$multi_controller) {
							if ($count >= 1) {
								$this->request->set([
									'action' => $this->toMethodName($args[0]),
									'param' => array_slice($args, 1),
								]);
							}
						} else if (!$multi_module && $multi_controller) {
						if ($count == 1) {
							$this->request->set([
								'action' => $this->toMethodName($args[0]),
							]);
						} else if ($count >= 2) {
							$this->request->set([
								'controller' => $this->toControllerName($args[0]),
								'action' => $this->toMethodName($args[1]),
								'param' => array_slice($args, 2),
							]);
						}
					} else {
						if ($count == 1) {
							$this->request->set([
								'action' => $this->toMethodName($args[0]),
							]);
						} else if ($count == 2) {
							$this->request->set([
								'controller' => $this->toControllerName($args[0]),
								'action' => $this->toMethodName($args[1]),
							]);
						} else if($count >= 3) {
							$this->request->set([
								'module' => $args[0],
								'controller' => $this->toControllerName($args[1]),
								'action' => $this->toMethodName($args[2]),
								'param' => array_slice($args, 3),
							]);
						}
					}
				}
				$this->controllerResponse();
			break;

			case RouteDispatcher::METHOD_NOT_ALLOWED:
				$this->response->error(405);
				break;

			case RouteDispatcher::FOUND:
				$handler = $info[1];
				$this->request->set(['param' => $info[2]]);
				if (is_callable($handler)) {
					$this->handlerResponse($handler);
				} else {
					$pathinfo = $info[1];
					$args = explode('/', $pathinfo);
					$count = count($args);
					if ($count == 1) {
						$this->request->set([
							'action' => $this->toMethodName($args[0]),
						]);
					} else if ($count == 2) {
						$this->request->set([
							'controller' => $this->toControllerName($args[0]),
							'action' => $this->toMethodName($args[1]),
						]);
					} else if($count >= 3) {
						$this->request->set([
							'module' => $args[0],
							'controller' => $this->toControllerName($args[1]),
							'action' => $this->toMethodName($args[2]),
						]);
					}
					$this->controllerResponse();
				}
				break;
		}
	}

	/**
	 * 响应客户端请求
	 */
	protected function controllerResponse()
	{
		$module = $this->request->module();
		$controller = $this->request->controller();
		$action = $this->request->action();

		if (Config::get('app.multi_module')) {
			if (!is_dir(APP_PATH . $module)) {
				throw new ModuleNotFound("模块 '{$module}' 不存在");
			}
			$class = sprintf('\app\%s\controller\%s', $module, $controller);
			Config::import(APP_PATH . $module . '/config/');
		} else {
			$class = sprintf('\app\controller\%s', $controller);
			Config::import(APP_PATH . 'config/');
		}
		if (!class_exists($class)) {
			throw new ControllerNotFound("控制器 '{$class}' 不存在");
		}

		$controllerObj = new $class;
		if (!method_exists($controllerObj, $action)) {
			throw new ActionNotFound("行为 '{$class}@{$action}' 不存在");
		}

		//控制器方法调用
		$args = $this->request->param();
		if ($args) {
			$data = call_user_func_array([$controllerObj, $action], $args);
		} else {
			$data = call_user_func([$controllerObj, $action]);
		}
		$this->response->data($data);
	}

	/**
	 * 调用路由回调函数
	 * @param  callback  $handler
	 */
	protected function handlerResponse($handler)
	{
		$args = array_values($this->request->param());
		if (empty($args)) {
			$data = call_user_func($handler);
		} else {
			$data = call_user_func_array($handler, $args);
		}
		$this->response->data($data);
	}

	/**
	 * 转换控制器类名：小写下划线式转换驼峰式
	 * @param  string $str url控制器名
	 * @return string      控制器类名
	 */
	private function toControllerName($str)
	{
		$ret = '';
		$length = strlen($str);
		if ($length) {
			$ret = strtoupper($str[0]);
			for ($pos = 1; $pos < $length; ++ $pos){
				$ch = $str[$pos];
				if ($ch == '_') {
					if ($pos + 1 < $length) {
					++ $pos;
					$ret .= strtoupper($str[$pos]);
					}
				} else {
					$ret .= $ch;
				}
			}
		}
		return $ret;
	}

	/**
	 * 转行为方法：小写下划线式转换驼峰式
	 * @param  string $str url方法名
	 * @return string      类方法名
	 */
	private function toMethodName($str)
	{
		$ret = '';
		for ($pos = 0, $length = strlen($str); $pos < $length; ++ $pos){
			$ch = $str[$pos];
			if ($ch == '_') {
				if ($pos + 1 < $length) {
					++ $pos;
					$ret .= strtoupper($str[$pos]);
				}
			} else {
				$ret .= $ch;
			}
		}
		return $ret;
	}
}
