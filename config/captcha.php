<?php
/**
 * 验证码配置
 */
return [
	// 背景色
	'background_color' => [245, 245, 245],
	// 字体文件('lqphp/ttf'目录下)
	'font' =>  LQPHP_PATH . 'ttf/Arial.ttf',
	// 图片格式(png/jpeg/gif/webp/xbm/xbmp/gd/gd2)
	'format' => 'png',
	// 字体大小
	'font_size' => 20,
	// 字符个数
	'length' => 4,
	// 验证字符范围
	'range' =>'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
	// 字符x边距
	'padding_x' => 15,
	// 字符y边距
	'padding_y' => 10,
];
