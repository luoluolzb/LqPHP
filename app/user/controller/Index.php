<?php
namespace app\user\controller;
use app\user\model\TestUser as UserModel;

class Index extends \lqphp\Controller
{
	public function test()
	{
		$userModel = UserModel::get([
			'name' => 'luoluo',
			'passwd' => 'luoluo',
		]);
		return format($userModel->data());
	}

	//主页
	public function index()
	{
		$view = view();
		if (!cookie('user')) {
			$view->assign('login', false);
		} else {
			$user = cookie('user');
			$userModel = UserModel::get($user);
			if (!$userModel) {
				$view->assign('login', false);
			} else {
				$view->assign('login', true);
				$view->assign('user', $userModel->data());
			}
		}
		return $view;
	}

	public function getRegister()
	{
		$view = view('register.tpl');
		$view->assign('success', false);
		$view->assign('user_name', '');
		$view->assign('passwd', '');
		$view->assign('errmsg', '');
		return $view;
	}

	//用户注册
	public function postRegister()
	{
		$user_name = $passwd = $errmsg = '';
		$validator = validator('user');
		$data = post();
		$user_name = $data['user_name'];
		$passwd = $data['passwd'];
		$success = false;
		
		$view = view('register.tpl');
		if ($validator->validate($data)) {
			$success = true;
			$user = new UserModel();
			$user->name = $data['user_name'];
			$user->passwd = $data['passwd'];
			$user->checked = 0;
			$user->val_id = md5(uniqid('lqphp'));
			if ($user_id = $user->save() !== false) {
				$success = true;
				$view->assign('val_id', $user->val_id);
			} else {
				$errmsg = '注册失败！';
			}
		} else {
			$errmsg = $validator->error();
		}

		$view->assign('success', $success);
		$view->assign('user_name', $user_name);
		$view->assign('passwd', $passwd);
		$view->assign('errmsg', $errmsg);
		return $view;
	}

	//用户激活
	public function validate($val_id = null)
	{
		$success = false;
		$user = UserModel::get(['val_id' => $val_id]);

		if ($user) {
			if ($user->checked) {
				$success = true;
			} else {
				$user_t = new UserModel;
				$user_t->checked = 1;
				if($user_t->update(['id' => $user->id])) {
					$success = true;
				}
			}
		}

		$view = view();
		$view->assign('user_name', $user->name);
		$view->assign('success', $success);
		return $view;
	}

	//用户登陆
	public function login()
	{
		$user_name = $passwd = $errmsg = '';
		if (method('POST')) {
			$validator = validator('User');
			$data = post();
			$user_name = $data['user_name']; 
			$passwd = $data['passwd'];
			if ($validator->validate($data)) {
				$userModel = UserModel::get([
					'name' => $user_name,
					'passwd' => $passwd,
				]);
				if (!$userModel) {
					$errmsg = '账号或密码错误!';
				} else {
					cookie('user', [
						'name' => $user_name,
						'passwd' => $passwd,
					]);
					redirect('/user/index/index');
				}
			} else {
				$errmsg = $validator->error();
			}
		}

		$view = view();
		$view->assign('user_name', $user_name);
		$view->assign('passwd', $passwd);
		$view->assign('errmsg', $errmsg);
		return $view;
	}

	//登出
	public function logout()
	{
		cookie('user', null);
		redirect('/user/index/index');
	}
}
