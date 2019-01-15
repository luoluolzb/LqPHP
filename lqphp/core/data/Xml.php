<?php
/**
 * @description xml数据类
 * @author      luoluolzb
 */
namespace lqphp\data;
use \lqphp\Config;

class Xml implements DataInterface
{
	/**
	 * 数据
	 * @var mixed
	 */
	protected $data;

	/**
	 * 构造函数
	 * @param mixed  $data
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}
	
	/**
	 * 设置/获取数据
	 * @param  string $data
	 * @return mixed
	 */
	public function data($data = null)
	{
		if (isset($data)) {
			$this->data = $data;
		} else {
			return $this->data;
		}
	}

	/**
	 * 发送数据到客户端
	 * @return bool
	 */
	public function send()
	{
		header('Content-Type: text/xml');
		echo $this->fetch();
	}

	/**
	 * 获取渲染结果
	 * @return string
	 */
	public function fetch()
	{
		$root = Config::get('app.default.xml_root');
		$result  = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
		$result .=  '<'. $root . ">\n";
		$result .= $this->_formatXML($this->data);
		$result .=  '</'. $root . ">";
		return $result;
	}

	/**
	 * 递归生成xml格式
	 *
	 * @access private
	 * @param  mixed $data 数据
	 */
	private function _formatXML(&$data)
	{
		$result = '';
		if (is_array($data)) {
			foreach ($data as $key => &$value) {
				$attr = "";
				if (is_numeric($key)) {
					$attr = " key='{$key}'";
					$key = 'item';
				}
				$result .= "<{$key}{$attr}>";
				if (is_array($value)) {
					$result .= "\n";
					$result .= $this->_formatXML($value);
				} else {
					$result .= $value;
				}
				$result .= "</{$key}>\n";
			}
		} else {
			$result .= $data;
		}
		return $result;
	}
}
