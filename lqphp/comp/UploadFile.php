<?php
/**
 * @description 上传文件处理类
 * @author      luoluolzb
 */
namespace lqphp\comp;
use \lqphp\library\File;

class UploadFile extends AbstractComp
{
	/**
	 * 上传文件的信息
	 * @var array
	 */
	public $file = [
		// 'orig' => string,      //上传时的原文件名
		// 'temp' => string,      //临时文件
		// 'path' => string,      //保存位置
		// 'name' => string,      //保存文件名
		// 'full' => string,      //完整文件路径
		// 'ext'  => string,      //原文扩展名
		// 'size' => integer,     //文件大小(byte)
		// 'mime' => string,      //文件mime
		// 'type' => string,      //文件类型
		// 'size_com' => integer, //图片压缩后的大小(byte)
	];

	/**
	 * 错误信息
	 * @var string
	 */
	protected $error = '';
    
    /**
     * 构造函数
     * 从配置文件加载配置数据
     */
    public function __construct($name)
    {
        parent::__construct();
        $this->conf = $this->conf[$name];
    }

	/**
	 * 追加保存路径
	 * @param string $path
	 */
	public function addPath($path)
	{
		$this->conf['save_path'] .= $path;
	}

	/**
	 * 保存上传文件(只能保存一次)
	 * @param string $field 表单文件字段
	 * @param string $name  自定义模式下, 保存的文件名(无需后缀)
	 * @return bool
	 */
	public function save($field, $name = [])
	{
		if (!file_exists($this->conf['save_path'])) {
			if (!mkdir($this->conf['save_path'])) {
				$this->error = '文件保存失败(创建保存目录失败)！';
				return false;
			}
		}

		if (!$this->validate($field)) {
			return false;
		}
		switch ($this->conf['save_mode']) {
			case 'random':
				$this->file['name'] = md5(uniqid('lqphp_', true)) . '.' . $this->file['ext'];
				break;
			
			case 'original':
				$this->file['name'] = $this->file['orig'];
				break;

			case 'custom':
				$this->file['name'] = $name . '.' . $this->file['ext'];
				break;
			
			default:
				break;
		}
		$this->file['full'] = $this->file['path'] . $this->file['name'];
		if (!@move_uploaded_file($this->file['temp'], $this->file['full'])) {
			$this->error = '文件保存失败！';
			return false;
		}
		if ($this->file['type'] == 'image' && $this->conf['compress']) {
			$this->compress();
		}
		return true;
	}

	/**
	 * 获取错误信息
	 * @return string
	 */
	public function error()
	{
		return $this->error;
	}

	/**
	 * 获取上传文件信息
	 * @param  string $name 名称
	 * @return mixed
	 */
	public function info($name = null)
	{
		if (isset($name)) {
			if (isset($this->file[$name])) {
				return $this->file[$name];
			} else {
				return null;
			}
		} else {
			return $this->file;
		}
	}

	/**
	 * 验证文件
	 * @param  string $field   表单中文件字段名
	 * @return bool
	 */
	protected function validate($field)
	{
		$file = $_FILES[$field];
		if (isset($file) && $file['error'] != 0) {
			$this->error = '文件加载失败(errcode = ' . @$file['error'] . ')!';
			return false;
		}
		$this->file['orig'] = mb_convert_encoding($file['name'], 'GBK', 'UTF-8');
		$this->file['temp'] = mb_convert_encoding($file['tmp_name'], 'GBK', 'UTF-8');

		$fileObj = new File($this->file['orig']);
		$this->file['ext']  = $fileObj->exten();

		$fileObj = new File($this->file['temp']);
		$this->file['size'] = $fileObj->size();
		$this->file['mime'] = $fileObj->mime();
		$this->file['type'] = $fileObj->type();
		$this->file['path'] = $this->conf['save_path'];

		/* 验证文件 */
		if (isset($this->conf)) {
			if (isset($this->conf['size'])) {
				if ($this->file['size'] < $this->conf['size'][0] || $this->file['size'] > $this->conf['size'][1]) {
					$this->error = '文件大小必须在[' . $this->conf['size'][0] . ', ' . $this->conf['size'][1] . ']之间!';
					return false;
				}
			}
			if (isset($this->conf['type'])) {
				if($this->file['type'] != $this->conf['type']) {
					$this->error = '文件非' . $this->conf['type'] . '类型!';
					return false;
				}
			}
			if (isset($this->conf['mime'])) {
				if (array_search($this->file['mime'], $this->conf['mime']) === false) {
					$this->error = '文件mime类型验证失败！';
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * 压缩图片品质
	 * @return boolean
	 */
	protected function compress()
	{
		$file = & $this->file['full'];
		$temp = explode('/', $this->file['mime']);
		$type = end($temp);
		$fun = 'imagecreatefrom' . $type;
		$srcImage = $fun($this->file['full']);
		if (!$srcImage) {
			return false;
		}
		list($srcWidth, $srcHeight) = getimagesize($file);
		$dstImage = imagecreatetruecolor($srcWidth, $srcHeight);
		if (!imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0,
			                    $srcWidth, $srcHeight, $srcWidth, $srcHeight)
			) {
			return false;
		}
		$fun = 'image' . $type;
		if ($fun($dstImage, $file)) {
			$this->file['size_com'] = filesize($file);
			return true;
		}
		return false;
	}
}
