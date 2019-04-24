<?php
/**
 * Smarty配置
 */
return [
	//变量配置（以下只包含常用的配置项，其他变量或查看介绍请查看smarty手册Chapter13）
	'vars' => [
		//调试控制台的开关
		'debugging' => false,
		//模板的输出缓存开关
		'caching' => Smarty::CACHING_OFF,
		//模板缓存文件的有效时间（秒）
		'cache_lifetime' => 60*60,
		//模板语法中的右限定符（默认为'{'）
		'left_delimiter' => '{',
		//模板语法中的右限定符（默认为'}'）
		'right_delimiter' => '}',
	],
	//目录配置(smarty3.1不允许直接用变量方式访问，因此使用setter方法作为键)
	'dirs' => [
		//缓存文件目录
		'setCacheDir' => RUNTIME_PATH.'smarty/cache',
		//配置文件目录
		'setConfigDir' => RUNTIME_PATH.'smarty/configs',
		//编译文件目录
		'setCompileDir' => RUNTIME_PATH.'smarty/templates_c',
		//插件文件目录
		'addPluginsDir' => RUNTIME_PATH.'smarty/plugins',
		//模板文件目录（系统自动配置）
		//'setTemplateDir' => RUNTIME_PATH.'smarty/templates',
	],
];
