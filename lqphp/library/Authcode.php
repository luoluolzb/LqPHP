<?php
/**
 * @description 字符串加密/解密类
 * @author      luoluolzb
 */
namespace lqphp\library;

class Authcode
{
	/**
	 * 默认密匙
	 * @var string
	 */
	protected static $_securekey = 'da2a9004405454d00c6d38f66d9cce8d';

	/**
	 * 字符串加密
	 * @param  string $str       原文
	 * @param  string $key       密匙
	 * @return string            密文
	 */
	public static function encode($str, $key = null)
	{
		return self::authcode($str, 'encode', $key);
	}

	/**
	 * 字符串解密
	 * @param  string $str       密文 
	 * @param  string $key       密匙
	 * @return string            原文
	 */
	public static function decode($str, $key = null)
	{
		return self::authcode($str, 'decode', $key);
	}

	/**
	 * 加密/解密数据 
	 * @param  string $str       原文或密文 
	 * @param  string $operation 'encode' or 'decode' 
	 * @param  string $key       密匙
	 * @return string            密文或原文
	 */
	protected static function authcode($string, $operation, $key = null)
	{
		$ckey_length = 4;   // 随机密钥长度 取值 0-32;  
		$key = isset($key) ? $key : self::$_securekey;
		$key = md5($key);  
		$keya = md5(substr($key, 0, 16));  
		$keyb = md5(substr($key, 16, 16));  
		$keyc = $ckey_length ? ($operation == 'decode' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';  

		$cryptkey = $keya.md5($keya.$keyc);  
		$key_length = strlen($cryptkey);  

		$string = $operation == 'decode' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', 0).substr(md5($string.$keyb), 0, 16).$string;  
		$string_length = strlen($string);  

		$result = '';  
		$box = range(0, 255);  

		$rndkey = array();  
		for($i = 0; $i <= 255; $i++) {  
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);  
		}  

		for($j = $i = 0; $i < 256; $i++) {  
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;  
			$tmp = $box[$i];  
			$box[$i] = $box[$j];  
			$box[$j] = $tmp;  
		}  

		for($a = $j = $i = 0; $i < $string_length; $i++) {  
			$a = ($a + 1) % 256;  
			$j = ($j + $box[$a]) % 256;  
			$tmp = $box[$a];  
			$box[$a] = $box[$j];  
			$box[$j] = $tmp;  
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));  
		}  

		if($operation == 'decode') {  
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {  
				return substr($result, 26);  
			} else {  
				return '';  
			}  
		} else {  
			return $keyc.str_replace('=', '', base64_encode($result));  
		}
	}
}
