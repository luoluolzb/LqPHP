<?php
/**
 * 应用配置
 */
return [
	// 应用环境
	'env' => 'dev',
	// 调试模式
	'debug' => true,
	// 应用KEY(数据加密KEY,可用'md5(uniqid())'生成)
	'key' => '60f7AGH16C649f0e9f50737d57Ybb862',
	// 默认值配置
	'default' => [
		// 默认访问模块
		'module' => 'index',
		// 默认访问控制器
		'controller' => 'Index',
		// 默认访问方法
		'action' => 'index',
		// 默认jsonp返回函数
		'jsonp_callback' => 'lqphp_jsonp_callback',
		// xml数据根标签名称
		'xml_root' => 'lqphp_xml',
		// 默认数据类型(支持：json, jsonp, xml)
		'return_type' => 'json',
	],
	// 多模块模式
	'multi_module' => true,
	// 多控制器模式(单控制器使用默认控制器,单模块模式开启时有效)
	'multi_controller' => true,
	// url后缀(如'.html',不需要时取空)
	'url_suffix' => '',
	// 加载辅助函数库
	'helper_fun' => true,
	// 时区(PRC: People's Republic of China)
	'timezone' => 'PRC',
];
