<?php

defined('BASEPATH') OR die('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $_tablename;

    public function __construct() {
        parent::__construct();
    }

    public function total_records() {
        return $this->db->count_all($this->_tablename);
    }

}
