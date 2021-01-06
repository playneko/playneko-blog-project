<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Controller {

    public function __construct() {
        parent::__construct();
  
        $this->load->helper('url');
		$this->load->model('project_model');

        $segs = $this->uri->segment_array();
        if(empty($segs)) {
            redirect(CONST_LOGIN_DIR, 'location');
        }
    }

    public function __destruct() {
        $this->db->close();
    }
    
    public function returnJson($ret) {
        header('Access-Control-Allow-Origin: *');
        header("Content-Type: application/json");
        echo json_encode($ret);
    }
    
    public function render($viewPage, $headerData, $bodyData) {
        $this->load->view('elements/header', $headerData);
        $this->load->view($viewPage, $bodyData);
        $this->load->view('elements/footer');
    }
    
    public function projectInfo() {
        $projectId = $this->sessionInfo()['project_id'];

        // 기본정보 가져오기
        $ret = array(
            'project' => $this->project_model->getProjectInfo($projectId)
        );

        return $ret;
    }
    
    public function sessionInfo() {
        // 세션정보 가져오기
        $ret = array('member_login' => FALSE);
        $sessionData = $this->session->all_userdata();

        if (!empty($sessionData)) {
            $ret['no'] = $this->session->userdata('no');
            $ret['project_id'] = $this->session->userdata('project_id');
            $ret['admin_id'] = $this->session->userdata('admin_id');
            $ret['admin_level'] = $this->session->userdata('admin_level');
            $ret['member_login'] = $this->session->userdata('member_login');
        }

        return $ret;
    }
    
    public function loginSessionCheck() {
        $arr = array('login', 'logincheck');
        $segs = $this->uri->segment_array();

        if (in_array('login', $segs) || in_array('logincheck', $segs)) {
        } else {
            $sessionInfo = $this->sessionInfo();

            if (empty($sessionInfo['project_id']) || empty($sessionInfo['member_login']) || $sessionInfo['member_login'] === FALSE) {
                redirect(CONST_SITE_DIR . CONST_LOGIN_DIR, 'location');
            }
        }
    }
    
    public function getUrlDataNo() {
        $segs = $this->uri->segment_array();
        return is_numeric($segs[count($segs)]) ? $segs[count($segs)] : 0;
    }
    
    public function getUrlDataNoSel($num) {
        $segs = $this->uri->segment_array();
        return $segs[count($segs) - $num];
    }
}
