<?php
namespace app\test\controller;

class Upload extends \lqphp\Controller
{
	public function index()
	{
		return 'Upload ok';
	}

	public function file()
	{
		if (method('GET')) {
			return view();
		}
		$upFile = uploadfile('file');
		if ($upFile->save('myfile')) {
			return format($upFile->info());
		} else {
			echo $upFile->error();
		}
	}

	public function image()
	{
		if (method('GET')) {
			return view('file.tpl');
		}
		$upFile = uploadfile('image');
		$upFile->addPath('image' . DS);
		if ($upFile->save('myfile')) {
			return format($upFile->info());
		} else {
			echo $upFile->error();
		}
	}
}
