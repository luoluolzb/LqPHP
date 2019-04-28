<?php
/**
 * 邮箱配置
 */
return [
	//发送人
	'from' => 'luoluolzb@163.com',
	//邮件服务器
	'server' => [
		//服务器地址
		'address' => 'smtp.163.com',
		//用户邮箱
		'user' => 'luoluolzb@163.com',
		//认证密码
		'passwd' => 'passwd',
		//连接端口
		'port' => 465,
		//使用安全ssl连接
		'security' => true,
	],
];
