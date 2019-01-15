<?php
/**
 * @description 助手函数库
 * @author      luoluolzb
 */

use lqphp\App;
use lqphp\Config;
use lqphp\Controller;
use lqphp\Db;
use lqphp\Request;
use lqphp\Response;
use lqphp\Loader;
use lqphp\Validator;
use lqphp\Logger;

use lqphp\comp\Captcha;
use lqphp\comp\Cookie;
use lqphp\comp\Mailer;
use lqphp\comp\Pager;
use lqphp\comp\Session;
use lqphp\comp\UploadFile;

use lqphp\data\Json;
use lqphp\data\Jsonp;
use lqphp\data\Xml;
use lqphp\data\View;

use lqphp\lib\MultiArrAccess;
use lqphp\lib\Authcode;
use lqphp\lib\File;

/**
 * 获取类实例
 */
if (!function_exists('app')) {
	function app() {
		return App::instance();
	}
}
if (!function_exists('database')) {
	function db() {
		return Db::instance();
	}
}
if (!function_exists('request')) {
	function request() {
		return Request::instance();
	}
}
if (!function_exists('response')) {
	function response() {
		return Response::instance();
	}
}
if (!function_exists('view')) {
	function view($tpl = null) {
		return new View($tpl);
	}
}
if (!function_exists('json')) {
	function json($data) {
		return new Json($data);
	}
}
if (!function_exists('jsonp')) {
	function jsonp($data, $callback = null) {
		return new Jsonp($data, $callback);
	}
}
if (!function_exists('xml')) {
	function xml($data) {
		return new Xml($data);
	}
}
if (!function_exists('captcha')) {
	function captcha($conf = null) {
		return new Captcha($conf);
	}
}
if (!function_exists('mailer')) {
	function mailer($conf = null) {
		return new Mailer($conf);
	}
}
if (!function_exists('uploadfile')) {
	function uploadfile($conf) {
		return new UploadFile($conf);
	}
}
if (!function_exists('validator')) {
	function validator($data = null) {
		return Loader::validator($data);
	}
}
if (!function_exists('logger')) {
	function logger() {
		return Logger::instance();
	}
}

/**
 * 请求类方法快速调用
 */
if (!function_exists('method')) {
	function method($check = null) {
		return Request::instance()->method($check);
	}
}
if (!function_exists('module')) {
	function module() {
		return Request::instance()->module();
	}
}
if (!function_exists('controller')) {
	function controller() {
		return Request::instance()->controller();
	}
}
if (!function_exists('action')) {
	function action() {
		return Request::instance()->action();
	}
}
if (!function_exists('param')) {
	function param($name = null, $default = null) {
		return Request::instance()->param($name, $default);
	}
}
if (!function_exists('server')) {
	function server($name = null, $default = null) {
		return Request::instance()->server($name, $default);
	}
}
if (!function_exists('get')) {
	function get($name = null, $default = null) {
		return Request::instance()->get($name, $default);
	}
}
if (!function_exists('post')) {
	function post($name = null, $default = null) {
		return Request::instance()->post($name, $default);
	}
}
if (!function_exists('files')) {
	function files($name = null, $default = null) {
		return Request::instance()->files($name, $default);
	}
}

/**
 * 响应类方法快速调用
 */
if (!function_exists('redirect')) {
	function redirect($url, $code = 302) {
		Response::redirect($url, $code);
	}
}
if (!function_exists('repage')) {
	function repage($refresh = true) {
		Response::repage($refresh);
	}
}

/**
 * 工具函数
 */
if (!function_exists('format')) {
	function format($data) {
		if (is_array($data)) {
			return '<pre>' . print_r($data, true) . '</pre>';
		} else {
			return '<pre>' . gettype($data) . '(' . var_export($data, true) . ')</pre>';
		}
	}
}
if (!function_exists('config')) {
	function config($name = null, $value = null, $merge = false) {
		return Config::access($name, $value, $merge);
	}
}
if (!function_exists('pager')) {
	function pager($url, $page, $total, $conf = null) {
	$pager = new pager($url, $page, $total, $conf);
		return $pager->html();
	}
}
if (!function_exists('cookie')) {
	function cookie($name, $value = null) {
		$cookie = Cookie::instance();
		$count = func_num_args();
		if ($count == 1) {
			if (is_null($name)) {
				return $cookie->clear($name);
			} else {
				return $cookie->get($name);
			}
		} else {
			if (is_null($value)) {
			return $cookie->delete($name);
			} else {
			return $cookie->set($name, $value);
			}
		}
	}
}
if (!function_exists('session')) {
	function session($name, $value = null) {
		$session = Session::instance();
		$count = func_num_args();
		if ($count == 1) {
			if (is_null($name)) {
				return $session->clear($name);
			} else {
				return $session->get($name);
			}
		} else {
			if (is_null($value)) {
				return $session->delete($name);
			} else {
				return $session->set($name, $value);
			}
		}
	}
}
if (!function_exists('array_access')) {
	function array_access(&$arr, $name = null, $value = null, $merge = false) {
		return MultiArrAccess::access($arr, $name, $value, $merge);
	}
}
if (!function_exists('str_encrypt')) {
	function str_encrypt($str) {
		return Authcode::encode($str);
	}
}
if (!function_exists('str_decrypt')) {
	function str_decrypt($str) {
		return Authcode::decode($str);
	}
}
