<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'App_model.php';

class Administrator_model extends App_model {
    
    public function __construct() {
      parent::__construct();

      $this->tbl_admin = 'blog_admin';
    }
    
    public function administrator_login($memberId, $memberPw) {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        try {
            $sql = " SELECT no, project_id, member_id, admin_level ";
            $sql .= " FROM " . $this->tbl_admin;
            $sql .= " WHERE member_id = ? and member_pw = ? ";
            $sql .= " LIMIT 0, 1 ";

            $query = $this->db->query($sql, array($memberId, md5($memberPw)));

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
                        'result' => CONST_QUERY_RESULT_OK,
                        'no' => $data['no'],
                        'project_id' => $data['project_id'],
                        'admin_id' => $data['member_id'],
                        'admin_level' => $data['admin_level']
                    );
                }
            } else {
                $ret['message'] = "아이디 또는 비밀번호가 일치하지 않습니다.";
            }
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_004, $e->getMessage());
            return $ret;
        }

        return $ret;
    }
    
    public function administrator_count($userId) {

        try {
            $sql = " SELECT count(*) as cnt FROM " . $this->tbl_admin;
            $sql .= " WHERE member_id = ? ";
            $query = $this->db->query($sql, array($userId));

            if (!$query) {
                $db_error = $this->db->error();
                if (!empty($db_error)) {
                    throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                    return false;
                }
            }

            foreach ($query->result_array() as $data) {
                return $data['cnt'];
            }
        } catch (Exception $e) {
            throw $e;
        }

        return 0;
    }
    
    public function administrator_insert($paramData, $projectId) {

        try {
            $sql = " INSERT INTO ".$this->tbl_admin;
            $sql .= " (no, project_id, member_id, member_pw, member_email, admin_level, reg_date) ";
            $sql .= " VALUES('', ?, ?, ?, ?, 1, now()) ";

            $insertQuery = array(
                $this->db->escape_str($projectId),
                $this->db->escape_str($paramData['user_id']),
                md5($paramData['user_pw']),
                $this->db->escape_str($paramData['user_email'])
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
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_005, $e->getMessage());
            return $ret;
        }
    }
}