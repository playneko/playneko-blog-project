<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'App_model.php';

class Api_model extends App_model {
    
    public function __construct() {
        parent::__construct();

        $this->tbl_blog_board = 'blog_board';
        $this->tbl_blog_cat = 'blog_cat';
        $this->tbl_blog_tag = 'blog_tag';
    }

    public function getAllTotal($projectId, $catquery, $keyword) {
        $ret = array();

        try {
            $sql = " SELECT count(*) as cnt ";
            $sql .= " FROM " . $this->tbl_blog_board . " board ";

            if (!empty($keyword)) {
                $sql .= " WHERE board.project_id = ? ";
                $sql .= " AND board.board_title like '%" .$keyword. "%' ";
                $sql .= " AND board.is_del = 0 ";
            } else if (!empty($catquery)) {
                $sql .= " INNER JOIN " . $this->tbl_blog_cat . " cat ";
                $sql .= " ON board.no = cat.blog_no ";
                $sql .= " WHERE board.project_id = ? ";
                $sql .= " AND cat.cat_name = '" . $catquery . "' ";
                $sql .= " AND board.is_del = 0 ";
            } else {
                $sql .= " WHERE board.project_id = ? ";
                $sql .= " AND board.is_del = 0 ";
            }

            $query = $this->db->query($sql, array($projectId));

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
                        'cnt' => $data['cnt']
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

    public function getPage($projectId, $pageNum, $limitpage, $catquery, $keyword) {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        if (!$pageNum) {
            $pageNum = 0;
        }
        if (!$limitpage) {
            $limitpage = CONST_LIST_PAGE_MAX;
        }
        $pageStart = $pageNum;
        $pageEnd = $limitpage;

        try {
            $sql = " SELECT board.no, board.board_title, board.board_comment, ";
            $sql .= " board.board_thumnail, board.board_date ";
            $sql .= " FROM " . $this->tbl_blog_board . " board ";

            if (!empty($keyword)) {
                $sql .= " WHERE board.project_id = ? ";
                $sql .= " AND board.board_title like '%" .$keyword. "%' ";
                $sql .= " AND board.is_del = 0 ";
            } else if (!empty($catquery)) {
                $sql .= " INNER JOIN " . $this->tbl_blog_cat . " cat ";
                $sql .= " ON board.no = cat.blog_no ";
                $sql .= " WHERE board.project_id = ? ";
                $sql .= " AND cat.cat_name = '" . $catquery . "' ";
                $sql .= " AND board.is_del = 0 ";
            } else {
                $sql .= " WHERE board.project_id = ? ";
                $sql .= " AND board.is_del = 0 ";
            }

            $sql .= " ORDER BY board.board_date DESC ";
            $sql .= " LIMIT ".$pageStart.", ".$pageEnd;

            $query = $this->db->query($sql, array($projectId));

            if (!$query) {
                $db_error = $this->db->error();
                if (!empty($db_error)) {
                    throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                    return false;
                }
            }

            if ($query->num_rows() > 0) {
                $ret = array('result' => CONST_QUERY_RESULT_OK);

                foreach ($query->result_array() as $data) {
                    $ret['list'][] = array(
                        'no' => $data['no'],
                        'board_title' => $data['board_title'],
                        'board_comment' => $this->nl2br3($data['board_comment']),
                        'board_thumnail' => $data['board_thumnail'],
                        'board_date' => date('Y/m/d H:i', strtotime($data['board_date']))
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

    public function getDetail($projectId, $id) {
        $ret = array('result' => CONST_QUERY_RESULT_NG);

        try {
            $sql = " SELECT board.no, board_title, board_article, board_date, ";
            $sql .= " ( SELECT GROUP_CONCAT(cat_name SEPARATOR ',') ";
            $sql .= "   FROM " . $this->tbl_blog_cat;
            $sql .= "   where blog_no = board.no ) AS cat_name, ";
            $sql .= " ( SELECT GROUP_CONCAT(tag_name SEPARATOR ',') ";
            $sql .= "   FROM " . $this->tbl_blog_tag;
            $sql .= "   where blog_no = board.no ) AS tag_name ";
            $sql .= " FROM " . $this->tbl_blog_board . " board ";
            $sql .= " WHERE no = ? AND project_id = ? ";
            $sql .= " LIMIT 0, 1 ";

            $query = $this->db->query($sql, array($id, $projectId));

            if (!$query) {
                $db_error = $this->db->error();
                if (!empty($db_error)) {
                    throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                    return false;
                }
            }

            if ($query->num_rows() > 0) {
                $ret = array('result' => CONST_QUERY_RESULT_OK);

                foreach ($query->result_array() as $data) {
                    $catNameArr = explode(",", $data['cat_name']);
                    $tagNameArr = explode(",", $data['tag_name']);
                    $ret['detail'][] = array(
                        'no' => $data['no'],
                        'board_title' => $data['board_title'],
                        'board_article' => $this->nl2br3($data['board_article']),
                        'cat_name' => $catNameArr,
                        'tag_name' => $tagNameArr,
                        'board_date' => date('Y/m/d H:i', strtotime($data['board_date']))
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