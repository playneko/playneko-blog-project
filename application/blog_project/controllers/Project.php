<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Application.php';

class Project extends Application {

	public function __construct() {
		parent::__construct();

		// 로그인 체크
		$this->loginSessionCheck();

		$this->projectInfo = $this->projectInfo();
        $this->projectId = $this->sessionInfo()['project_id'];

		$this->load->helper('text');
		$this->load->model('project_model');
	}

	public function index() {
		$this->render('index.php', array('projectInfo' => $this->projectInfo), array());
	}

	public function register() {
        $ret = array('result' => 'NG');

        $data = array(
            'user_id' => $this->input->post('user_id'),
            'user_pw' => $this->input->post('user_pw'),
            'user_email' => $this->input->post('user_email'),
            'builder_title' => $this->input->post('builder_title'),
            'builder_description' => $this->input->post('builder_description')
        );
        
        if(empty($this->input->post('user_id'))) {
            $ret['message'] = "아이디를 입력해 주세요.";
            $this->returnJson($ret);
            return;
        }
        if(empty($this->input->post('user_pw'))) {
            $ret['message'] = "비밀번호를 입력해 주세요.";
            $this->returnJson($ret);
            return;
        }
        if(empty($this->input->post('user_email'))) {
            $ret['message'] = "이메일을 입력해 주세요.";
            $this->returnJson($ret);
            return;
        }
        if(empty($this->input->post('builder_title'))) {
            $ret['message'] = "프로젝트명을 입력해 주세요.";
            $this->returnJson($ret);
            return;
        }

        if(empty($ret['message'])) {
            $ret = $this->project_model->project_register($data);
        }
        
        $this->returnJson($ret);
        return;
    }
}
