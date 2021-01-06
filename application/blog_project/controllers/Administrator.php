<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Application.php';

class Administrator extends Application {

	public function __construct() {
		parent::__construct();

		// 로그인 체크
		$this->loginSessionCheck();

		$this->load->helper('text');
        $this->load->model('administrator_model');

		$this->projectInfo = $this->projectInfo();
        $this->projectId = $this->sessionInfo()['project_id'];
		$this->headerArr = array('projectInfo' => $this->projectInfo, 'page' => 'administrator');
	}
	
	public function logincheck() {
        $ret = array('result' => 'NG');
        
        if(empty($this->input->post('login_id'))) {
            $ret['message'] = "아이디를 입력해 주세요.";
            $this->returnJson($ret);
            return;
        }
        if(empty($this->input->post('login_pw'))) {
            $ret['message'] = "비밀번호를 입력해 주세요.";
            $this->returnJson($ret);
            return;
        }
        
		$ret = $this->administrator_model->administrator_login($this->input->post('login_id'), $this->input->post('login_pw'));

        // 로그인정보를 세션에 저장
        if($ret['result'] == "OK") {
            $newSession = array(
                'no' => $ret['no'],
                'project_id' => $ret['project_id'],
                'admin_id' => $ret['admin_id'],
                'admin_level' => $ret['admin_level'],
                'member_login' => TRUE
            );
  
            $this->session->set_userdata($newSession);
        }
        
        $this->returnJson($ret);
        return;
	}
	
	public function administrator() {
		$adminInfo = array (
			'adminList' => $this->administrator_model->administrator_list($this->projectId)
		);
		$this->render('administrator/index.php', $this->headerArr, $adminInfo);
	}

	public function administrator_modify() {
		$adminInfo = array (
			'adminDetail' => $this->administrator_model->administrator_detail($this->projectId)
		);
		$this->render('administrator/administrator_modify.php', $this->headerArr, $adminInfo);
	}

	public function administrator_save() {
	}
}
