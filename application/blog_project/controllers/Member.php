<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Application.php';

class Member extends Application {

	public function __construct() {
		parent::__construct();

		// 로그인 체크
		$this->loginSessionCheck();

		$this->load->helper('text');

		$this->projectInfo = $this->projectInfo();
        $this->projectId = $this->sessionInfo()['project_id'];
		$this->headerArr = array('projectInfo' => $this->projectInfo, 'page' => 'member');
	}
	
	public function index() {
		$this->load->view('login');
	}
}
