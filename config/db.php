<?php
/**
 * 数据库配置
 */
return [
	/*********** 必填配置 *************/
	'database_type' => 'mysql',
	'database_name' => 'lqphp_test',
	'server' => 'localhost',
	'username' => 'root',
	'password' => 'root',
	
	/*********** 可选配置 *************/
	// 字符编码
	'charset' => 'utf8',
	// 端口号
	'port' => 3306,
	// 表前缀
	'prefix' => 'tb_',
	// 日志记录(默认禁用以获得更好的性能)
	'logging' => false,

	// socket方式连接远程数据库
	// 'socket' => '/path/to/mysql.sock',
	
	// pdo连接选项(参考http://www.php.net/manual/zh/pdo.setattribute.php)
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	],
	// 连接数据库前执行的命令
	'command' => [
		'SET SQL_MODE=ANSI_QUOTES'
	]
];
