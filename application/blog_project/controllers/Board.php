<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Application.php';

class Board extends Application {

	public function __construct() {
		parent::__construct();

		// 로그인 체크
		$this->loginSessionCheck();

		$this->load->helper('text');
		$this->load->model('board_model');
        $this->load->library('pagination');

		$this->projectInfo = $this->projectInfo();
        $this->projectId = $this->sessionInfo()['project_id'];
		$this->headerArr = array('projectInfo' => $this->projectInfo, 'page' => 'board');
	}

	private function paging() {
        $config['base_url']       = CONST_SITE_DIR."project/board/";
        $config['total_rows']     = $this->board_model->board_total($this->projectId);
        $config['per_page']       = CONST_LIST_PAGE_MAX;
        $config["num_links"]      = 5;

        $config['prev_tag_open']  = '<li class="page-item page-link">';
        $config["prev_link"]      = '<';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open']   = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close']  = '</a></li>';

        $config['num_tag_open']   = '<li class="page-item page-link">';
        $config['num_tag_close']  = '</li>';

        $config['next_tag_open']  = '<li class="page-item page-link">';
        $config["next_link"]      = '>';
        $config['next_tag_close'] = '</li>';

        $config['first_tag_open']  = '<li class="page-item page-link">';
        $config["first_link"]      = '처음';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open']  = '<li class="page-item page-link">';
        $config["last_link"]      = '마지막';
        $config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);
	}

	public function board() {
		$this->paging();

		$dataArr = array (
            'pageing' => $this->pagination->create_links(),
			'dataList' => $this->board_model->board_list($this->projectId, $this->getUrlDataNo())
		);

		$this->render('board/index.php', $this->headerArr, $dataArr);
	}

	public function board_add() {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        if (!empty($this->input->post('mode'))) {
			if (empty($this->input->post('board_category'))) {
				$ret['message'] = "카테고리를 입력해 주세요.";
				$this->returnJson($ret);
				return;
			}
			if (empty($this->input->post('board_thumnail'))) {
				$ret['message'] = "썸네일을 입력해 주세요.";
				$this->returnJson($ret);
				return;
			}
			if (empty($this->input->post('board_title'))) {
				$ret['message'] = "제목을 입력해 주세요.";
				$this->returnJson($ret);
				return;
			}
			if (empty($this->input->post('board_article'))) {
				$ret['message'] = "내용을 입력해 주세요.";
				$this->returnJson($ret);
				return;
			}
			if (empty($this->input->post('board_date'))) {
				$ret['message'] = "날짜를 입력해 주세요.";
				$this->returnJson($ret);
				return;
			}

			$paramData = array(
				'board_title' => $this->input->post('board_title'),
				'board_comment' => $this->input->post('board_comment'),
				'board_article' => $this->input->post('board_article'),
				'board_thumnail' => $this->input->post('board_thumnail'),
				'board_date' => $this->input->post('board_date')
			);

			$ret = $this->board_model->board_add($this->projectId, $paramData);

			if ($ret['result'] == CONST_QUERY_RESULT_OK) {
				$getNo = $this->board_model->getLastBoard($this->projectId);

				if ($getNo['no'] > 0) {
					// 카테고리 등록
					$this->board_model->board_add_category($this->projectId, $getNo['no'], $this->input->post('board_category'));
					// 태그 등록
					$this->board_model->board_add_tag($this->projectId, $getNo['no'], $this->input->post('board_tag'));
				}
			}

			$this->returnJson($ret);
		} else {
			$this->render('board/board_add.php', $this->headerArr, array());
		}
	}

	public function board_modify() {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        if (!empty($this->input->post('mode'))) {
			if (empty($this->input->post('board_no')) || $this->input->post('board_no') < 1) {
				$ret['message'] = "데이터에 오류가 있습니다.";
				$this->returnJson($ret);
				return;
			}
			if (empty($this->input->post('board_category'))) {
				$ret['message'] = "카테고리를 입력해 주세요.";
				$this->returnJson($ret);
				return;
			}
			if (empty($this->input->post('board_title'))) {
				$ret['message'] = "제목을 입력해 주세요.";
				$this->returnJson($ret);
				return;
			}
			if (empty($this->input->post('board_article'))) {
				$ret['message'] = "내용을 입력해 주세요.";
				$this->returnJson($ret);
				return;
			}
			if (empty($this->input->post('board_date'))) {
				$ret['message'] = "날짜를 입력해 주세요.";
				$this->returnJson($ret);
				return;
			}

			$paramData = array(
				'board_no' => $this->input->post('board_no'),
				'board_title' => $this->input->post('board_title'),
				'board_comment' => $this->input->post('board_comment'),
				'board_article' => $this->input->post('board_article'),
				'board_thumnail' => $this->input->post('board_thumnail'),
				'board_date' => $this->input->post('board_date')
			);

			$ret = $this->board_model->board_update($this->projectId, $paramData);

			if ($ret['result'] == CONST_QUERY_RESULT_OK) {
				$this->board_model->board_delete_category($this->projectId, $paramData['board_no']);
				$this->board_model->board_delete_tag($this->projectId, $paramData['board_no']);

				// 카테고리 등록
				$this->board_model->board_add_category($this->projectId, $paramData['board_no'], $this->input->post('board_category'));
				// 태그 등록
				$this->board_model->board_add_tag($this->projectId, $paramData['board_no'], $this->input->post('board_tag'));
			}

			$this->returnJson($ret);
		} else {
			$dataArr = array (
				'dataInfo' => $this->board_model->board_detail($this->projectId, $this->getUrlDataNo())
			);
			$this->render('board/board_modify.php', $this->headerArr, $dataArr);
		}
	}

	public function board_delete() {
		$ret = array('result' => CONST_QUERY_RESULT_NG);

		if (empty($this->input->post('board_no'))) {
			$ret['message'] = "데이터에 오류가 있습니다.";
			$this->returnJson($ret);
			return;
		}

		$paramData = array(
			'board_no' => $this->input->post('board_no')
		);

		$ret = $this->board_model->board_delete($this->projectId, $paramData['board_no']);
		if ($ret['result'] == CONST_QUERY_RESULT_OK) {
			$this->board_model->board_delete_category($this->projectId, $paramData['board_no']);
			$this->board_model->board_delete_tag($this->projectId, $paramData['board_no']);
		}

		$this->returnJson($ret);
	}
}
