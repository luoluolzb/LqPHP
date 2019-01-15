<?php
/**
 * @description 分页器(原版来自网络)
 * @author      luoluolzb
 */
namespace lqphp\comp;

class Pager extends AbstractComp
{
	private $url;            //当前的url
	private $page;           //当前页
	private $total;          //总记录数
	private $page_count;     //总页数
	private $beg;            //起头页数
	private $end;            //结尾页数

	/**
	 * 构造函数
	 * @param string  $url     页面url
	 * @param integer $page    当前页码
	 * @param integer $total   记录总数
	 * @param array   $configs 配置参数[可选]
	 */
	public function __construct($url, $page, $total, $conf = [])
	{
		parent::__construct($conf);
		$this->url = $url;
		$this->page = $page;
		$this->total = $total;
		$this->page_count = ceil($this->total / $this->conf['size']);
		if ($this->total < 0) {
			$this->total = 0;
		}
		if ($this->page < 1) {
			$this->page = 1;
		}
		if ($this->page_count < 1) {
			$this->page_count = 1;
		}
		if ($this->page > $this->page_count) {
			$this->page = $this->page_count;
		}
		$this->limit = ($this->page - 1) * $this->conf['size'];
		$this->beg = $this->page - $this->conf['pager_count'];
		$this->end = $this->page + $this->conf['pager_count'];
		if ($this->beg < 1) {
			$this->end = $this->end + (1 - $this->beg);
			$this->beg = 1;
		}
		if ($this->end > $this->page_count) {
			$this->beg = $this->beg - ($this->end - $this->page_count);
			$this->end = $this->page_count;
		}
		if ($this->beg < 1) {
			$this->beg = 1;
		}
	}

	/**
	 * 获取html
	 * @return string
	 */
	public function html()
	{
		if ($this->conf['auto_hidden'] && $this->page_count == 1) {
			return '';
		} else {
			$str  = "<nav class='lqphp-pager' role='navigation'>\n";
			$str .= "<ul>\n";

			//首页
			if ($this->page != 1) {
				$str .= "<li><a href='" . $this->url_replace(1) . "'>首页</a></li>\n";
			}
			//上一页
			if ($this->page != 1) {
				$str .= "<li><a href='" . $this->url_replace($this->page - 1) . "'>«</a></li>\n";
			}
			for ($i = $this->beg; $i <= $this->end; ++ $i) {
				if ($i == $this->page) {
					$str .= "<li class='active'><a href='" . $this->url_replace($i) . "'>$i</a></li>\n";
				} else {
					$str .= "<li><a href='" . $this->url_replace($i) . "'>$i</a></li>\n";
				}
			}

			//下一页
			if ($this->page != $this->page_count) {
				$str .= "<li><a href='" . $this->url_replace($this->page + 1) . "'>»</a></li>\n";
			}
			//尾页
			if ($this->page != $this->page_count) {
				$str .= "<li><a href='" . $this->url_replace($this->page_count) . "'>末页</a></li>\n";
			}
			if ($this->conf['show_info']) {
				$str .= "<span class='info'>共" . $this->page_count . "页" . $this->total . "条</span>\n";
			}
			$str .= "</ul>\n";
			$str .= "</nav>\n";
				return $str;
		}
	}

	/**
	 * 将地址中的占位符进行替换
	 */
	private function url_replace($page)
	{
		return str_replace("{page}", $page, $this->url);
	}
}
