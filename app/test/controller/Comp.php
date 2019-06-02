<?php
namespace app\test\controller;

class Comp extends \lqphp\Controller
{
	public function index()
	{
		return 'Comp ok';
	}
	
	// 邮件类测试
	public function mail()
	{
		$mailer = mailer();
		$mailer->receiver("643552878@qq.com");
		$mailer->mail("LqPHP测试邮件主题", "LqPHP发送测试邮件的内容");
		if ($mailer->send()){
			return '发送成功！';
		} else {
			return $mailer->error();
		}
	}

	// 验证码类测试
	public function mycaptcha()
	{
		$captcha = captcha([
			'range'  => 'ABCD1234abcd',
			'format' => 'png',
			'length' => 4,
			'font' => LQPHP_PATH . 'ttf/Consola.ttf',
			'background_color' => [128, 128, 128],
		]);
		session('captcha', $captcha->code());
		$captcha->output();
	}

	// 验证器测试
	public function validate()
	{
		$data = [
			'id' => '1000',
			'name' => 'luoluolzb',
			'sex' => '男',
			'age' => '21',
			'email' => 'luoluolzb@163.com',
			'url' => 'http://www.luoluolzb.cn',
			'ip' => '127.0.0.1',
		];
		$validator = validator([
			'id'    => ['require' => true, 'type' => 'integer'],
			'name'  => ['name' => '用户名', 'require' => true, 'type' => 'alnum','min' => 0, 'max' => 10],
			'sex'   => ['require' => true, 'enum' => ['男', '女']],
			'age'   => ['require' => true, 'range' => [18, 25]],
			'email' => ['require' => true, 'type' => 'email'],
			'url'   => ['require' => false, 'type' => 'url'],
			'ip'    => ['type' => 'ip'],
		]);
		if ($validator->validate($data)) {
			return '验证通过！';
		} else {
			return $validator->error();
		}
	}

	// 验证器测试，验证单个数据
	public function validateOne($age = null)
	{
		$validator = validator();
		if ($validator->validateOne('age', $age, ['range' => [18, 30]])) {
			return '验证通过！';
		} else {
			return $validator->error();
		}

	}

	// cookie类库测试：添加
	public function cookie()
	{
		cookie('user', [
			'name' => 'luoluolzb',
			'pass' => '123456',
		]);
		echo format(cookie('user'));
	}

	// cookie类库测试：删除
	public function delcook()
	{
		cookie('user', null);
		echo format(cookie('user'));
	}

	// session类库测试：添加
	public function session()
	{
		session('user', [
			'name' => 'luoluolzb',
			'pass' => '123456',
		]);
		echo format(session('user'));
	}

	// session类库测试：删除
	public function delsess()
	{
		session('user', null);
		echo format(session('user'));
	}

	// 分页测试
	public function pager($page = 1)
	{
		$count = 100;  //项目数量，每页数量见 config/pager.php
		$view = view();
		$view->assign('pager', pager('/test/comp/pager/{page}', $page, $count));
		return $view;
	}
}
