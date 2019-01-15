<?php
/**
 * @description 错误处理类
 * @author      luoluolzb
 */
namespace lqphp;
use \Whoops\Run as Whoops;
use \Whoops\Handler\PrettyPageHandler;

class Error
{
	/**
	 * @var whoops\Run
	 */
	protected static $whoops;

	/**
	 * 注册错误处理
	 */
	public static function register()
	{
		self::$whoops = new Whoops();
		if (Config::get('app.debug')) {
			$handler = self::PrettyPageHandler();
		} else {
			$handler = function($exception, $inspector, $run) {
				return self::ExceptionHandler($exception);
			};
		}
		self::$whoops->pushHandler($handler);
		self::$whoops->register();
	}

	/**
	 * 错误页面处理
	 */
	protected static function PrettyPageHandler()
	{
		$handler = new PrettyPageHandler();
		$handler->setPageTitle('发生了点错误！- LqPHP');
		return $handler;
	}

	/**
	 * 异常处理函数
	 */
	protected static function ExceptionHandler($exception)
	{
		if ($exception instanceof exception\NotFound\NotFound) {
			self::$whoops->sendHttpCode(404);
			Response::error(404);
		} else {
			self::logException($exception);
			self::$whoops->sendHttpCode(500);
			Response::error(500);
		}
		return \Whoops\Handler\Handler::DONE;
	}

	/**
	 * 记录异常信息
	 */
	protected static function logException($exception)
	{
		if (!Config::get('logger.log_exception')) {
			return false;
		}
		$message = sprintf("Fatal error: Uncaught exception %s: %s file in %s:%s\r\nStack trace:\r\n",
			get_class($exception),
			$exception->getMessage(),
			$exception->getFile(),
			$exception->getLine()
		);
		$traces = $exception->getTrace();
		foreach ($traces as $key => &$trace) {
			$message .= "#{$key} ";
			if (isset($trace['file'])) {
				$message .= "{$trace['file']}({$trace['line']}) ";
			}
			if (isset($trace['class'])) {
				$message .= "{$trace['class']}{$trace['type']}";
			}
			if (isset($trace['function'])) {
				$list = '';
				for ($i = 0, $count = count($trace['args']); $i < $count; ++ $i) {
					$value = &$trace['args'][$i];
					if (is_scalar($value)) {
						$list .= var_export($value, true);
					} else if (is_object($value)) {
						$list .= gettype($value) . '(' . get_class($value) . ')';
					} else {
						$list .= gettype($value);
					}
					if ($i + 1 < $count) {
						$list .= ', ';
					}
				}
				$message .= "{$trace['function']}({$list})";
			}
			$message .= "\r\n";
		}
		Logger::instance()->error($message);
	}
}
