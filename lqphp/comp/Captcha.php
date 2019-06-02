<?php
/**
 * @description 验证码类
 * @author      luoluolzb
 */
namespace lqphp\comp;
use \lqphp\Config;

class Captcha extends AbstractComp
{
	/**
	 * 图片宽度和高度
	 * @var integer
	 */
	protected $width, $height;

	/**
	 * 验证码串
	 * @var string
	 */
	protected $code;

	/**
	 * 构造函数
	 * @param array $conf [可选]配置参数, 此参数会覆盖配置文件中的配置
	 */
	public function __construct($conf = null)
	{
		parent::__construct($conf);
		$this->width    = $this->conf['length'] * $this->conf['font_size'] + $this->conf['padding_x'] * 2;
		$this->height   = $this->conf['font_size'] + $this->conf['padding_y'] * 2;

		//生成验证码文本
		$this->code = '';
		for($i = 0, $len = strlen($this->conf['range']); $i < $this->conf['length']; ++ $i){    //循环4次，就是有四个随机的字母或者数字   
			$this->code .= $this->conf['range'][mt_rand(0, $len - 1)];
		}
	}

	/**
	 * 输出验证码图像到浏览器 或 文件
	 * @param  string $path 输出文件时的保存路径
	 */
	public function output($path = null)
	{
		// 创建画布
		$img = imagecreatetruecolor($this->width, $this->height);
		// 填充背景
		imagefill($img, 0, 0, imagecolorallocate($img,
			$this->conf['background_color'][0],
			$this->conf['background_color'][1],
			$this->conf['background_color'][2])
		);
		// 前景色
		$clr = imagecolorallocate($img, mt_rand(50, 200), mt_rand(50, 200),  mt_rand(50, 200));

		// 添加干扰曲线
		$sy = mt_rand($this->height/2 - 5, $this->height/2 + 5);
		$rand1 = mt_rand(10, 30);
		$rand2 = mt_rand(0, $this->height / 2);
		$hh = $this->conf['font_size'] / 10;
		$width_2 = $this->width/2;
		for ($px = -$width_2; $px <= $width_2; $px += 1) {
			$x = $px/$rand1;
			$y = sin($x);
			$py = $y*$rand2;
			imageline($img, $px + $width_2, $py + $sy, $px + $width_2 - $hh, $py + $sy + $hh, $clr);
		}

		// 添加验证码字符
		$x = $this->conf['padding_x'];
		$y = $this->height - ($this->height - $this->conf['font_size'])/2;
		for($i = 0; $i < $this->conf['length']; ++ $i){
			imagettftext($img,
				$this->conf['font_size'],
				mt_rand(-30, 30),
				$x, $y,
				$clr,
				$this->conf['font'],
				$this->code[$i]
			);
			$x += $this->conf['font_size'];
		}

		// 输出图像
		$imgFun = 'image' . $this->conf['format'];
		if ($path) {
			$res = $imgFun($img, $path);
		} else {
			header('Content-Type: image/' . $this->conf['format']);
			$res = $imgFun($img);
		}
		imagedestroy($img);
		return $res;
	}

	/**
	 * 获取生成的验证码文本
	 * @return string
	 */
	public function code()
	{
		return $this->code;
	}
}
