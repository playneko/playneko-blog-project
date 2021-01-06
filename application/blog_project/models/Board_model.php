<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'App_model.php';

class Board_model extends App_model {
    
    public function __construct() {
      parent::__construct();

      $this->tbl_blog_board = 'blog_board';
      $this->tbl_blog_cat = 'blog_cat';
      $this->tbl_blog_tag = 'blog_tag';
    }

    public function board_list($projectId) {
        $ret = array();

        $sql = " SELECT no, board_title, board_thumnail, board_date ";
        $sql .= " FROM " . $this->tbl_blog_board;
        $sql .= " WHERE project_id = ? ";
        $sql .= " ORDER BY no DESC ";

        $query = $this->db->query($sql, array($projectId));

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $data) {
                $ret[] = array(
                    'no' => $data['no'],
                    'board_title' => $data['board_title'],
                    'board_thumnail' => $data['board_thumnail'],
                    'board_date' => $data['board_date']
                );
            }
        }

        return $ret;
    }

    public function board_detail($projectId, $paramNo) {
        $ret = array();

        $sql = " SELECT board.no, board.board_title, board.board_comment, ";
        $sql .= " board.board_article, board.board_thumnail, board.board_date, ";
        $sql .= " ( SELECT GROUP_CONCAT(cat_name SEPARATOR ',') ";
        $sql .= "   FROM " . $this->tbl_blog_cat;
        $sql .= "   where blog_no = board.no ) AS cat_name, ";
        $sql .= " ( SELECT GROUP_CONCAT(tag_name SEPARATOR ',') ";
        $sql .= "   FROM " . $this->tbl_blog_tag;
        $sql .= "   where blog_no = board.no ) AS tag_name ";
        $sql .= " FROM " . $this->tbl_blog_board . " board ";
        $sql .= " WHERE board.no = ? AND board.project_id = ? ";

        $query = $this->db->query($sql, array($paramNo, $projectId));

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $data) {
                $ret[] = array(
                    'no' => $data['no'],
                    'board_title' => $data['board_title'],
                    'board_comment' => $this->nl2br3($data['board_comment']),
                    'board_article' => $this->nl2br3($data['board_article']),
                    'board_thumnail' => $data['board_thumnail'],
                    'board_date' => $data['board_date'],
                    'board_category' => $data['cat_name'],
                    'board_tag' => $data['tag_name']
                );
            }
        }

        return $ret;
    }

    public function board_add($projectId, $paramData) {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        try {
            $sql = " INSERT INTO " . $this->tbl_blog_board;
            $sql .= " (no, project_id, board_title, board_comment, board_article, board_thumnail, board_date) ";
            $sql .= " VALUES('', ?, ?, ?, ?, ?, ?) ";

            $insertQuery = array(
                $this->db->escape_str($projectId),
                $this->db->escape_str($paramData['board_title']),
                $this->db->escape_str($this->nl2br3($paramData['board_comment'])),
                $this->db->escape_str($this->nl2br3($paramData['board_article'])),
                $this->db->escape_str($paramData['board_thumnail']),
                $this->db->escape_str($paramData['board_date'])
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

            $ret['result'] = CONST_QUERY_RESULT_OK;

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_003, $e->getMessage());
            return $ret;
        }

        return $ret;
    }

    public function getLastBoard($projectId) {
        $ret = array();

        $sql = " SELECT no ";
        $sql .= " FROM " . $this->tbl_blog_board;
        $sql .= " WHERE project_id = ? ";
        $sql .= " ORDER BY no DESC ";
        $sql .= " LIMIT 0, 1 ";

        $query = $this->db->query($sql, array($projectId));

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $data) {
                $ret = array(
                    'no' => $data['no']
                );
            }
        }

        return $ret;
    }

    public function board_add_category($projectId, $paramNo, $paramData) {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        try {
            if (!empty($paramData)) {
                $sql = " INSERT INTO " . $this->tbl_blog_cat;
                $sql .= " (no, project_id, blog_no, cat_name, reg_date) ";
                $sql .= " VALUES ";

                $insertQuery = "";
                $dataArr = explode(",", $paramData);
                foreach ($dataArr as $value) {
                    if (!empty($value)) {
                        if (!empty($insertQuery)) {
                            $insertQuery .= ",";
                        }
                        $insertQuery .= " ('', '" . $projectId . "', '" . $paramNo. "', '" . $value . "', now())";
                    }
                }

                $sql .= $insertQuery;

                $this->db->trans_start();
                $query = $this->db->query($sql, array());
                $this->db->trans_complete();
    
                if ($this->db->trans_status() === FALSE) {
                    $db_error = $this->db->error();
                    if (!empty($db_error)) {
                        throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                        return false;
                    }
                }
    
                $ret['result'] = CONST_QUERY_RESULT_OK;
            }
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_003, $e->getMessage());
            return $ret;
        }

        return $ret;
    }

    public function board_add_tag($projectId, $paramNo, $paramData) {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        try {
            if (!empty($paramData)) {
                $sql = " INSERT INTO " . $this->tbl_blog_tag;
                $sql .= " (no, project_id, blog_no, tag_name, reg_date) ";
                $sql .= " VALUES ";

                $insertQuery = "";
                $dataArr = explode(",", $paramData);
                foreach ($dataArr as $value) {
                    if (!empty($value)) {
                        if (!empty($insertQuery)) {
                            $insertQuery .= ",";
                        }
                        $insertQuery .= " ('', '" . $projectId . "', '" . $paramNo. "', '" . $value . "', now())";
                    }
                }

                $sql .= $insertQuery;

                $this->db->trans_start();
                $query = $this->db->query($sql, array());
                $this->db->trans_complete();
    
                if ($this->db->trans_status() === FALSE) {
                    $db_error = $this->db->error();
                    if (!empty($db_error)) {
                        throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                        return false;
                    }
                }
    
                $ret['result'] = CONST_QUERY_RESULT_OK;
            }
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_003, $e->getMessage());
            return $ret;
        }

        return $ret;
    }


    public function board_update($projectId, $paramData) {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        try {
            if(!empty($paramData)) {
                $sql = " UPDATE " . $this->tbl_blog_board;
                $sql .= " set board_title = ?, ";
                $sql .= " board_comment = ?, ";
                $sql .= " board_article = ?, ";
                $sql .= " board_thumnail = ?, ";
                $sql .= " board_date = ? ";
                $sql .= " WHERE no = ? ";

                $this->db->trans_start();
                $query = $this->db->query($sql, array(
                    $paramData['board_title'],
                    $this->nl2br3($paramData['board_comment']),
                    $this->nl2br3($paramData['board_article']),
                    $paramData['board_thumnail'],
                    $paramData['board_date'],
                    $paramData['board_no']
                ));
                $this->db->trans_complete();
    
                $ret['result'] = CONST_QUERY_RESULT_OK;
            }
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_001, $e->getMessage());
            return $ret;
        }

        return $ret;
    }

    public function board_delete($projectId, $paramData) {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        try {
            $sql = " DELETE FROM " . $this->tbl_blog_board;
            $sql .= " WHERE no = ? AND project_id = ? ";

            $this->db->trans_start();
            $query = $this->db->query($sql, array($paramData, $projectId));
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $db_error = $this->db->error();
                if (!empty($db_error)) {
                    throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                    return false;
                }
            }
            return array('result' => CONST_QUERY_RESULT_OK);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_001, $e->getMessage());
            return $ret;
        }
    }

    public function board_delete_category($projectId, $paramData) {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        try {
            $sql = " DELETE FROM " . $this->tbl_blog_cat;
            $sql .= " WHERE project_id = ? AND blog_no = ? ";

            $this->db->trans_start();
            $query = $this->db->query($sql, array($projectId, $paramData));
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $db_error = $this->db->error();
                if (!empty($db_error)) {
                    throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                    return false;
                }
            }
            return array('result' => CONST_QUERY_RESULT_OK);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_001, $e->getMessage());
            return $ret;
        }
    }

    public function board_delete_tag($projectId, $paramData) {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        try {
            $sql = " DELETE FROM " . $this->tbl_blog_tag;
            $sql .= " WHERE project_id = ? AND blog_no = ? ";

            $this->db->trans_start();
            $query = $this->db->query($sql, array($projectId, $paramData));
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $db_error = $this->db->error();
                if (!empty($db_error)) {
                    throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                    return false;
                }
            }
            return array('result' => CONST_QUERY_RESULT_OK);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $ret['message'] = sprintf(CONST_ERROR_MESSAGE_DB, CONST_ERROR_CODE_001, $e->getMessage());
            return $ret;
        }
    }
}