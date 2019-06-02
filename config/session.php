<?php
/**
 * session配置
 */
return [
	// cookie标识名称
	'name' => 'lqphp_session',
	// session文件保存位置
	'save_path' => RUNTIME_PATH . 'session',
	// 会话结束时过期(单位:秒，设置为0表示在会话结束时过期(关掉浏览器时))
	'cookie_lifetime' => 7200,
	// cookie有效的服务器路径
	'cookie_path' => '/',
	// cookie有效域名/子域名
	'cookie_domain' => '',
	// cookie仅仅通过安全的 HTTPS 连接传给客户端
	'cookie_secure' => false,
	// cookie仅可通过 HTTP 协议访问
	'cookie_httponly' => false,
];
