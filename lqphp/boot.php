<?php
/**
 * @description 框架启动文件
 * @author      luoluolzb
 */

/**
 * 定义系统常量
 */
define('LQPHP_VERSION', '2.1');
define('LQPHP_START_TIME', microtime(true));
define('LQPHP_START_MEM', memory_get_usage());
define('DS', DIRECTORY_SEPARATOR);

/**
 * 定义框架目录常量
 */
define('WEB_PATH', realpath(__DIR__ . DS . '..') . DS);
define('APP_PATH', WEB_PATH . 'app' . DS);
define('CONFIG_PATH', WEB_PATH . 'config' . DS);
define('EXTEND_PATH', WEB_PATH . 'extend' . DS);
define('LQPHP_PATH', __DIR__ . DS);
define('PUBLIC_PATH', WEB_PATH . 'public' . DS);
define('RUNTIME_PATH', WEB_PATH . 'runtime' . DS);

/**
 * 加载composer自动加载文件
 */
require WEB_PATH . 'vendor/autoload.php';
 
/**
 * 加载psr4自动加载类
 */
require LQPHP_PATH . 'library/AutoLoader.php';

/**
 * 注册框架类自动加载规则
 */
lqphp\library\AutoLoader::import([
	'lqphp' => [
		LQPHP_PATH,
		LQPHP_PATH . 'core' . DS,
	],
	'app' => APP_PATH,
	'' => EXTEND_PATH,
]);
