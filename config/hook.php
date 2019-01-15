<?php
/**
 * Hook配置
 */
return [
	//系统钩子
	'app_init' => [],
	'app_end' => [],
	'db_init' => [],

	//自定义钩子
	'test_action' => ['action\TestAction'],
];
