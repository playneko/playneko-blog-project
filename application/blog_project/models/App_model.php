<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function date_day($date, $plus_date) {
        //날짜 계산
        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);
        $return_date = date("Y-m-d", mktime(0, 0, 0, $month, $day + $plus_date, $year));
        //---------------

        return $return_date;
    }

    function nl2br2($string) {
        $string = str_replace(array("\\r\\n", "\\r", "\\n"), "<br />", $string);
        return $string;
    }

    function nl2br3($string) {
        $string = str_replace(array("\\r\\n", "\\r", "\\n"), "\n", $string);
        return $string;
    }
}