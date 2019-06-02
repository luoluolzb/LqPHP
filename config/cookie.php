<?php
/**
 * cookie配置
 */
return [
	// 开启加密
	'encrypt' => true,
	// 会话结束时过期(单位:秒，设置为0表示在会话结束时过期(关掉浏览器时))
	'expire' => 7200,
	// 有效的服务器路径
	'path' => '/',
	// 有效域名/子域名
	'domain' => '',
	// 仅仅通过安全的 HTTPS 连接传给客户端
	'secure' => false,
	// 仅可通过 HTTP 协议访问
	'httponly' => false,
];
