<?php

class Advertisement_Type extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form'));
        $this->load->library(array('form_validation'));
        $this->load->model('advertisement_type_model');
    }

    public function index() {
        $this->data['subview'] = $this->load->view('advertisement_type/view', NULL, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }

    public function quick_add() {
        $data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name');
        $this->load->view('advertisement_type/_modal_add', $data);
    }

    public function add() {
        $this->data['action'] = 'advertisement_type/add';
        /*
         * Form inputs
         */
        $this->data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name', 'value' => set_value('name'));

        /*
         * Validation rules
         */
        $rules_add_advertisement_type = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($rules_add_advertisement_type);

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');
        } else {
            $this->advertisement_type_model->create();
            $this->session->set_flashdata('message', alert_message('Advertisement type added successfully', 'success'));
            redirect('advertisement_type/add', 'refresh');
        }

        $this->data['subview'] = $this->load->view('advertisement_type/add', $this->data, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }
    
    public function edit($id) {
        $this->data['action'] = 'advertisement_type/edit/' . $id;
        $row = $this->advertisement_type_model->find_by_id($id);
        /*
         * Form inputs
         */
        $this->data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name', 'value' => $row->name);

        /*
         * Validation rules
         */
        $rules_add_advertisement_type = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($rules_add_advertisement_type);

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');
        } else {
            $this->advertisement_type_model->update($id);
            $this->session->set_flashdata('message', alert_message('Advertisement type updated successfully', 'success'));
            redirect('advertisement_type/edit/' . $id, 'refresh');
        }

        $this->data['subview'] = $this->load->view('advertisement_type/add', $this->data, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }

    public function fetch_post() {
        $draw = $this->input->post('draw');
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search[value]');
        $sort_column = $this->input->post('order[0][column]');
        $order = $this->input->post('order[0][dir]');

        $data = array(
            'limit' => $limit,
            'offset' => $offset,
            'search' => $search,
            'sort' => $sort_column,
            'order' => $order
        );

        $total_records = $this->advertisement_type_model->total_records();
        $query = $this->advertisement_type_model->get_view($data);

        if ($query) {
            $index = 1;
            foreach ($query->result() as $row) {
                $rows[] = array(
                    $index++,
                    html_escape($row->name),
                    "<a href='" . base_url('advertisement_type/edit/' . html_escape($row->id)) . "' class='btn btn-xs btn-success'><i class='fa fa-edit'></i></a>"
//                    . "&nbsp;&nbsp;<a href='' class='btn btn-xs btn-danger'><i class='fa fa-times'></i></a>"
                );
            }
            $filtered_records = $query->num_rows();
        } else {
            $filtered_records = 0;
            $rows = '';
        }

        $output = array(
            'draw' => (int) $draw,
            'recordsFiltered' => $filtered_records,
            'recordsTotal' => $total_records,
            'data' => $rows
        );

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

}
