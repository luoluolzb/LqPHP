<?php
/**
* @description 日志类
* @author      luoluolzb
*/
namespace lqphp;
use \Psr\Log\LogLevel;

class Logger extends \Psr\Log\AbstractLogger
{
	/**
	 * @var object 对象实例
	 */
	protected static $instance;

	/**
	 * 日志文件存放位置
	 * @var string
	 */
	protected $savePath;

	/**
	 * 日志保存等级
	 * @var \Psr\Log\LogLevel
	 */
	protected $saveLevel;

	/**
	 * 日志列表
	 * @var array(
		[
			'level' => string,
			'message' => string,
			'time' => integer,
		],
		...
	 )
	 */
	protected $list = [];

	/**
	 * 日志对应等级
	 * @var array
	 */
	protected $index = [
		'emergency' => 1,
		'alert' => 2,
		'critical' => 3,
		'error' => 4,
		'warning' => 5,
		'notice' => 6,
		'info' => 7,
		'debug' => 8,
	];

	/**
	 * 构造函数
	 */
	protected function __construct()
	{
		$this->savePath = Config::get('logger.save_path');
		$this->saveLevel = Config::get('logger.save_level');
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
	 * 保存日志，并清空日志列表
	 * @return void
	 */
	public function save()
	{
		foreach ($this->list as $key => $info) {
			if ($this->isSave($info['level'])) {
				$file = $this->getSavePath($info['time']);
				error_log($info['message'], 3, $file);
			}
		}
		$this->list = [];
	}

	/**
	 * 记录日志到日志列表(不会直接保存)
	 * @param \Psr\Log\LogLevel  $level    日志级别
	 * @param string             $message  信息
	 * @param array              $context  上下文信息
	 * @return void
	 */
	public function log($level, $message, array $context = [])
	{
		$time = time();
		$msgText = $this->interpolate($message, $context);
		$text = sprintf("[%s %s]\r\n%s\r\n\r\n", $level, strftime('%Y-%m-%d %X', $time), $msgText);
		$info = [
			'level' => $level,
			'message' => $text,
			'time' => $time,
		];
		$this->list[] = $info;
	}

	/**
	 * 用上下文信息替换记录信息中的占位符
	 * @return string
	 */
	protected function interpolate($message, array $context = [])
	{
		$replace = array();
		foreach ($context as $key => $val) {
		if (is_array($val)) {
				$value = print_r($val, true);
			} else {
				$value = $val;
			}
			$replace['{' . $key . '}'] = $value;
		}
		return strtr($message, $replace);
	}

	/**
	 * 获取日志文件保存路径
	 * @param  string  $time  时间戳
	 */
	public function getSavePath($time)
	{
		return $this->savePath . strftime('%Y-%m-%d.log', $time);
	}

	/**
	 * 比较日志等级比否需要保存
	 * @param \Psr\Log\LogLevel  $level  日志级别
	 * @return boolean
	 */
	public function isSave($level)
	{
		return $this->index[$level] <= $this->index[$this->saveLevel];
	}
}
