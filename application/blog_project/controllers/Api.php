<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Application.php';

class Api extends Application {

	public function __construct() {
		parent::__construct();

		$this->load->model('api_model');
    }

    private function getPaging($total, $page, $limit) {
		$list = CONST_LIST_PAGE_MAX;
		$block_cnt = CONST_PAGE_MAX;
		$block_num = ceil($page / $block_cnt);
		$block_start = (($block_num - 1) * $block_cnt) + 1;
		$block_end = $block_start + $block_cnt - 1;

		$total_page = ceil($total / $list);
		if ($block_end > $total_page) {
			$block_end = $total_page;
		}
		$total_block = ceil($total_page / $block_cnt);
		$page_start = ($page - 1) * $list;

		$thispage = ($page < 1 ? 1 : $page - 1) * $limit;

		$ret = array(
			'total' => $total_page,
			'start' => $block_start,
			'end' => $block_end,
			'thispage' => $thispage
		);
		return $ret;
	}

    public function category_list() {
		$ret = array();

		$projectId = "";
		$thispage = 0;
		$limitpage = 0;
		$catpage = 0;
		$catquery = "";
		$keyword = "";
		if (!empty($this->input->get('projectid')) && $this->input->get('projectid')) {
			$projectId = $this->input->get('projectid');
		}
		if (!empty($this->input->get('page')) && $this->input->get('page')) {
			$thispage = $this->input->get('page');
		}
		if (!empty($this->input->get('limitpage')) && $this->input->get('limitpage')) {
			$limitpage = $this->input->get('limitpage');
			if (!$limitpage) {
				$limitpage = CONST_LIST_PAGE_MAX;
			}
		}
		if (!empty($this->input->get('catpage')) && $this->input->get('catpage')) {
			$catpage = $this->input->get('catpage');
		}
		if (!empty($this->input->get('keyword')) && $this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
		}

		$catPageArr = unserialize(CONST_CATEGORY_PAGE);
		if ($catpage > 0) {
			foreach ($catPageArr as $key => $value) {
				if ($key == $catpage) {
					$catquery = $value;
				}
			}
		}

		$cnt = $this->api_model->getAllTotal($catquery, $keyword);
		$paging = $this->getPaging($projectId, $cnt['cnt'], $thispage < 1 ? 1 : $thispage, $limitpage);
		$ret = $this->api_model->getPage($projectId, $paging['thispage'], $limitpage, $catquery, $keyword);

		$ret['paging'] = $paging;
		$this->returnJson($ret);
	}

    public function detail_page() {
		$ret = array();

		$ret = $this->api_model->getDetail($this->input->get('projectid'), $this->input->get('id'));

		$this->returnJson($ret);
	}
}
