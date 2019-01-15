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
		if (!$upFile->save('myfile')) {
			return format($upFile->info());
		}
		return format($upFile->info());
	}

	public function image()
	{
		if (method('GET')) {
			return view('file.tpl');
		}
		$upFile = uploadfile('image');
		$upFile->addPath('image/');
		if (!$upFile->save('myfile')) {
			return format($upFile->info());
		}
		return format($upFile->info());
	}
}
