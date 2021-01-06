<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'App_model.php';

class Project_model extends App_model {
    
    public function __construct() {
      parent::__construct();

      $this->tbl_project = 'blog_project';
      $this->load->model('administrator_model');
    }
    
    public function project_register($paramData) {
        $ret = array('result' => 'NG');

        $projectId = md5($paramData['user_id'] . "_" . date("YmdHis"));

        try {
            // 중복체크
            $count = $this->administrator_model->administrator_count($paramData['user_id']);

            if ($count > 0) {
                $ret['message'] = "이미 사용중인 아이디 입니다.";
                return $ret;
            }
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_001, $e->getMessage());
            return $ret;
        }

        try {
            // 관리자 등록
            $this->administrator_model->administrator_insert($paramData, $projectId);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_002, $e->getMessage());
            return $ret;
        }

        try {
            // 프로젝트 생성
            $sql = " INSERT INTO " . $this->tbl_project;
            $sql .= " (no, user_id, project_id, project_title, project_description, status, reg_date) ";
            $sql .= " VALUES('', ?, ?, ?, ?, 1, now()) ";

            $insertQuery = array(
                $this->db->escape_str($paramData['user_id']),
                $this->db->escape_str($projectId),
                $this->db->escape_str($paramData['project_title']),
                $this->db->escape_str($paramData['project_description'])
            );

            $this->db->trans_start();
            $query = $this->db->query($sql, $insertQuery);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $db_error = $this->db->error();
                if (!empty($db_error)) {
                    throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                    return false;
                }
            }

            $ret['result'] = "OK";

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_003, $e->getMessage());
            return $ret;
        }

        return $ret;
    }
    
    public function getProjectInfo($paramData) {

        try {
            $sql = " SELECT no, user_id, project_title, project_description, status ";
            $sql .= " FROM " . $this->tbl_project;
            $sql .= " WHERE project_id = ? ";
            $sql .= " LIMIT 0, 1 ";

            $query = $this->db->query($sql, array($paramData));

            if (!$query) {
                $db_error = $this->db->error();
                if (!empty($db_error)) {
                    throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                    return false;
                }
            }
            
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $data) {
                    $ret = array(
                        'no' => $data['no'],
                        'user_id' => $data['user_id'],
                        'project_title' => $data['project_title'],
                        'project_description' => $data['project_description']
                    );
                }

                return $ret;
            }
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_001, $e->getMessage());
            return $ret;
        }
    }
}