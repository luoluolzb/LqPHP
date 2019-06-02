<?php
/**
 * 日志配置
 */
return [
	// 日志文件存放位置
	'save_path' => RUNTIME_PATH . 'log' . DS,
	// 保存的日志等级
	'save_level' => \Psr\Log\LogLevel::ERROR,
	// 在调试模式下记录系统发生的错误信息到日志
	'log_exception' => true,
];
