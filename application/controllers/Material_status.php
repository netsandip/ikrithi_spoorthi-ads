<?php

class Material_Status extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form'));
        $this->load->library(array('form_validation'));
        $this->load->model('material_status_model');
    }

    public function index() {
        $this->data['subview'] = $this->load->view('material_status/view', NULL, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }

    public function quick_add() {
        $data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name');
        $this->load->view('material_status/_modal_add', $data);
    }

    public function add() {
        $this->data['action'] = 'material_status/add';
        /*
         * Form inputs
         */
        $this->data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name', 'value' => set_value('name'));

        /*
         * Validation rules
         */
        $rules_add_material_status = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($rules_add_material_status);

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');
        } else {
            $this->material_status_model->create();
            $this->session->set_flashdata('message', alert_message('Material status added successfully', 'success'));
            redirect('material_status/add', 'refresh');
        }

        $this->data['subview'] = $this->load->view('material_status/add', $this->data, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }
    
    public function edit($id) {
        $this->data['action'] = 'material_status/edit/' . $id;
        $row = $this->material_status_model->find_by_id($id);
        /*
         * Form inputs
         */
        $this->data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name', 'value' => $row->name);

        /*
         * Validation rules
         */
        $rules_add_material_status = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($rules_add_material_status);

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');
        } else {
            $this->material_status_model->update($id);
            $this->session->set_flashdata('message', alert_message('Material status updated successfully', 'success'));
            redirect('material_status/edit/' . $id, 'refresh');
        }

        $this->data['subview'] = $this->load->view('material_status/add', $this->data, TRUE);
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

        $total_records = $this->material_status_model->total_records();
        $query = $this->material_status_model->get_view($data);

        if ($query) {
            $index = 1;
            foreach ($query->result() as $row) {
                $rows[] = array(
                    $index++,
                    html_escape($row->name),
                    "<a href='" . base_url('material_status/edit/' . html_escape($row->id)) . "' class='btn btn-xs btn-success'><i class='fa fa-edit'></i></a>"
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
