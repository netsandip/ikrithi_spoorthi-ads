<?php

defined('BASEPATH') or die('No direct access allowed');

class Acl extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function roles() {
        $this->data['subview'] = $this->load->view('acl/manage_role', NULL, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }
    
    public function permissions() {
        $this->data['subview'] = $this->load->view('acl/manage_permission', NULL, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }

}
