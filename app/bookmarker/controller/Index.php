<?php
namespace app\bookmarker\controller;
use app\bookmarker\model\Bookmarker;

class Index extends \lqphp\Controller
{
	/**
	 * 页面
	 */
	public function index()
	{
		return view();
	}

	/* 一下为API接口 */

	/**
	 * 页面
	 */
	public function gets()
	{
		$data = Bookmarker::gets();
		if (!$data) {
			return ['status' => 'failed'];
		} else {
			return [
				'status' => 'success',
				'list' => $data
			];
		}
	}

	public function add()
	{
		$marker = new Bookmarker;
		$marker->url = $this->request->get('url');
		$marker->name = $this->request->get('name');
		if ($id = $marker->save()) {
			$marker->id = $id;
			return [
				'status' => 'success',
				'marker' => $marker->data(),
			];
		} else {
			return ['status' => 'failed'];
		}
	}

	public function update()
	{
		$marker = new Bookmarker;
		$marker->url = $this->request->get('url');
		$marker->name = $this->request->get('name');
		if($marker->update($this->request->get('id'))) {
			return 'success';
		} else {
			return 'error';
		}
	}

	public function delete()
	{
		$marker = new Bookmarker;
		if($marker->delete($this->request->get('id'))) {
			return 'success';
		} else {
			return 'error';
		}
	}

	public function title()
	{
		$html = file_get_contents($this->request->get('url'));
		if (!$html) {
			return ['status' => 'error'];
		}
		if(preg_match('#<title( data-n-head="true")?>(.*)</title>#i', $html, $title)) {
			$title = end($title);
			$encode = mb_detect_encoding($title, ["ASCII",'UTF-8',"GB2312","GBK",'BIG5']); 
			$title = mb_convert_encoding($title, 'UTF-8', $encode);
			return [
				'status' => 'success',
				'title' => $title,
			];
		} else {
			return ['status' => 'error'];
		}
	}
}
