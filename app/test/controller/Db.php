<?php
namespace app\test\controller;
use app\test\model\User as User;
use app\test\model\Book as Book;
use app\test\model\Role as Role;
use app\test\model\UserRole as UserRole;

class Db extends \lqphp\Controller
{
	public function index()
	{
		return 'Db ok';
	}

	//模型保存数据
	public function data()
	{
		$user = new User();
		$user->data([
			'name' => 'luoluolzb',
			'age' => 18,
		]);
		return format($user->data());
	}

	//原生SQL查询测试
	public function query()
	{
		//query() 返回 PDOStatement 实例
		$users = db()->query("select * from tb_user")->fetchAll(\PDO::FETCH_ASSOC);
		return format($users);
	}

	//使用查询器
	public function db()
	{
		$users = db()->select("user", ['id', 'name']);
		return format($users);
	}

	/* 使用模型操作数据库 */


	//查询单个记录
	public function get($id)
	{
		$user = User::get($id);
		if (!$user) {
			return '用户不存在!';
		}
		return format($user->data());
	}

	//查询多个记录
	public function gets()
	{
		$users = User::gets();
		if (!$users) {
			return '查询失败';
		}
		return format($users);
	}

	//保存一个记录
	public function save()
	{
		$user = new User();
		$user->name = 'lisi';
		$user->age = 18;
		if ($id = $user->save()) {
			return '增加用户(' . $id . ', ' . $user->name . ')成功！';
		}
		return format($user->error());
	}

	//保存多个记录
	public function saveList()
	{
		$user = new User;
		$users = [
			[
				'name' => '洛洛',
				'age' => 21,
			], [
				'name' => '倩倩',
				'age' => 21,
			]
		];
		if ($count = $user->save($users)) {
			return '成功增加'.$count.'个用户！';
		}
		return format($user->error());
	}

	//修改记录
	public function update()
	{
		$user = new User;
		$user->name = '李四';
		if ($user->update(['name' => 'lisi'])) {
			return '更新信息成功！';
		} else {
			return format($user->error());
		}
	}

	//查询记录并指定格式
	public function book()
	{
		$data = db()->select('user', [
			'[>]book' => ['id' => 'user_id'],
		], [
			'user.id (user_id)',
			'user.name (user_name)',
			'user.age (user_age)',
			'book.id (book_id)',
			'book.name (book_name)'
		]);
		return format($data);
	}

	/* 关联查询 */

	//查询用户的一本书
	public function hasOne()
	{
		$book = User::get(1)->book();
		return format($book->data());
	}

	//查询用户的多本书
	public function hasMany()
	{
		return format(User::get(1)->books());
	}

	//查询书的拥有者
	public function belongsTo()
	{
		$user = Book::get(1001)->user();
		return format($user->data());
	}

	//查询用户的角色
	public function userrole()
	{
		return format(User::get(['name' => '洛洛'])->role());
	}

	//查询角色的用户
	public function roleuser()
	{
		return format(Role::get(1000)->user());
	}

	//删除记录
	public function delete()
	{
		echo format(User::delete(2005));
	}

	//聚合查询
	public function count()
	{
		$user = new User();
		echo format($user->count());
	}
}
