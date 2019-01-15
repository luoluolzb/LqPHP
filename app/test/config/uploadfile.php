<?php
/**
 * 文件上传配置
 */
return [
	'file' => [
		'size' => [0, 1024*1024*10],
		'type' => 'text',
		'save_mode' => 'random',
		'save_path' => PUBLIC_PATH . 'uploads'. DS,
	],
	'image' => [
		'size' => [0, 1024*1024*10],
		'type' => 'image',
		'save_mode' => 'original',
		'save_path' => PUBLIC_PATH . 'uploads'. DS,
		'compress' => true,
	],
];
