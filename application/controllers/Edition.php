<?php

class Edition extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form'));
        $this->load->library(array('form_validation'));
        $this->load->model('edition_model');
    }

    public function index() {
        $this->data['subview'] = $this->load->view('edition/view', NULL, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }

    public function quick_add() {
        $data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name');
        $this->load->view('edition/_modal_add', $data);
    }

    public function add() {
        $this->data['action'] = 'edition/add';
        /*
         * Form inputs
         */
        $this->data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name', 'value' => set_value('name'));

        /*
         * Validation rules
         */
        $rules_add_edition = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($rules_add_edition);

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');
        } else {
            $this->edition_model->create();
            $this->session->set_flashdata('message', alert_message('Edition added successfully', 'success'));
            redirect('edition/add', 'refresh');
        }

        $this->data['subview'] = $this->load->view('edition/add', $this->data, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }

    public function edit($id) {
        $this->data['action'] = 'edition/edit/' . $id;
        $row = $this->edition_model->find_by_id($id);
        /*
         * Form inputs
         */
        $this->data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name', 'value' => $row->name);

        /*
         * Validation rules
         */
        $rules_add_edition = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($rules_add_edition);

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');
        } else {
            $this->edition_model->update($id);
            $this->session->set_flashdata('message', alert_message('Edition updated successfully', 'success'));
            redirect('edition/edit/' . $id, 'refresh');
        }

        $this->data['subview'] = $this->load->view('edition/add', $this->data, TRUE);
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

        $total_records = $this->edition_model->total_records();
        $return_data = $this->edition_model->get_view($data);

        if ($return_data['query']) {
//            $index = 1;
            foreach ($return_data['query']->result() as $row) {
                $rows[] = array(
//                    $index++,
                    form_checkbox('chk_row[]', $row->id, FALSE, array('class' => 'chk_row')),
                    html_escape($row->name),
                    "<a href='" . base_url('edition/edit/' . html_escape($row->id)) . "' class='btn btn-xs btn-success'><i class='fa fa-edit'></i></a>"
//                    . "&nbsp;&nbsp;<a href='' class='btn btn-xs btn-danger'><i class='fa fa-times'></i></a>"
                );
            }
            $filtered_records = $return_data['count'];
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

    public function bulk_delete() {
        $ids = $this->input->post('data_ids');

        if (empty($ids)) {
            $this->session->set_flashdata('message', alert_message('Selected atleast one record to delete', 'success'));
            redirect('edition', 'refresh');
        }

        $id_array = explode(",", $ids);

        foreach ($id_array AS $id) {
            $this->edition_model->delete($id);
        }

        $this->session->set_flashdata('message', alert_message('Selected records are deleted', 'success'));
        redirect('edition', 'refresh');
    }

}
