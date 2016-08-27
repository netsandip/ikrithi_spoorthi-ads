<?php

class Package extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form'));
        $this->load->library(array('form_validation'));
        $this->load->model('package_model');
    }

    public function index() {
        $this->data['subview'] = $this->load->view('package/view', NULL, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }

    public function quick_add() {
        $data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name');
        $this->load->view('package/_modal_add', $data);
    }

    public function add() {
        $this->data['action'] = 'package/add';

        $this->load->model('publication_model');
        $this->load->model('ad_type_model');
        /*
         * Form inputs
         */
        $this->data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name', 'value' => set_value('name'));
        $this->data['input_paid'] = array('type' => 'text', 'id' => 'paid', 'name' => 'paid', 'value' => set_value('paid'));
        $this->data['input_free'] = array('type' => 'text', 'id' => 'free', 'name' => 'free', 'value' => set_value('free'));
        $this->data['textarea_description'] = array('id' => 'description', 'name' => 'description', 'value' => set_value('description'));
        
        /* Fetch ad types */
        $ad_types = $this->ad_type_model->find_all();
        $this->data['dropdown_ad_type']['options'][''] = 'Select Ad Type';
        if ($ad_types) {
            foreach ($ad_types as $ad_type) {
                $this->data['dropdown_ad_type']['options'][$ad_type->id] = $ad_type->name;
            }
        }
        $this->data['dropdown_ad_type']['default'] = set_value('ad_type');
        
        /* Fetch publications */
        $publications = $this->publication_model->find_all();
        $this->data['dropdown_publication']['options'][''] = 'Select Publication';
        if ($publications) {
            foreach ($publications as $publication) {
                $this->data['dropdown_publication']['options'][$publication->id] = $publication->name;
            }
        }
        $this->data['dropdown_publication']['default'] = set_value('publication');

        /*
         * Validation rules
         */
        $rules_add_package = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'publication',
                'label' => 'Publication',
                'rules' => 'required'
            ),
            array(
                'field' => 'ad_type',
                'label' => 'Ad Type',
                'rules' => 'required'
            ),
            array(
                'field' => 'paid',
                'label' => 'Paid',
                'rules' => 'required'
            ),
            array(
                'field' => 'free',
                'label' => 'Free',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($rules_add_package);

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');
        } else {
            $this->package_model->create();
            $this->session->set_flashdata('message', alert_message('Package added successfully', 'success'));
            redirect('package/add', 'refresh');
        }

        $this->data['subview'] = $this->load->view('package/add', $this->data, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }

    public function edit($id) {
        $this->load->model('publication_model');
        $this->load->model('ad_type_model');
        $this->data['action'] = 'package/edit/' . $id;
        $row = $this->package_model->find_by_id($id);
        /*
         * Form inputs
         */
        $this->data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name', 'value' => $row->name);
        $this->data['input_paid'] = array('type' => 'text', 'id' => 'paid', 'name' => 'paid', 'value' => $row->paid);
        $this->data['input_free'] = array('type' => 'text', 'id' => 'free', 'name' => 'free', 'value' => $row->free);
        $this->data['textarea_description'] = array('id' => 'description', 'name' => 'description', 'value' => $row->description);
        
        /* Fetch ad types */
        $ad_types = $this->ad_type_model->find_all();
        $this->data['dropdown_ad_type']['options'][''] = 'Select Ad Type';
        if ($ad_types) {
            foreach ($ad_types as $ad_type) {
                $this->data['dropdown_ad_type']['options'][$ad_type->id] = $ad_type->name;
            }
        }
        $this->data['dropdown_ad_type']['default'] = $row->ad_type_id;
        
        /* Fetch publications */
        $publications = $this->publication_model->find_all();
        $this->data['dropdown_publication']['options'][''] = 'Select Publication';
        if ($publications) {
            foreach ($publications as $publication) {
                $this->data['dropdown_publication']['options'][$publication->id] = $publication->name;
            }
        }
        $this->data['dropdown_publication']['default'] = $row->publication_id;

        /*
         * Validation rules
         */
        $rules_add_package = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($rules_add_package);

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');
        } else {
            $this->package_model->update($id);
            $this->session->set_flashdata('message', alert_message('Package updated successfully', 'success'));
            redirect('package/edit/' . $id, 'refresh');
        }

        $this->data['subview'] = $this->load->view('package/add', $this->data, TRUE);
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

        $total_records = $this->package_model->total_records();
        $return_data = $this->package_model->get_view($data);

        if ($return_data['query']) {
            $index = 1;
            foreach ($return_data['query']->result() as $row) {
                $publication = $row->publication_name;
                if (empty($publication)) {
                    $publication = '<label class="label label-danger">NOT SET</label>';
                }
                $ad_type = $row->ad_type_name;
                if (empty($ad_type)) {
                    $ad_type = '<label class="label label-danger">NOT SET</label>';
                }

                $rows[] = array(
                    $index++,
                    html_escape($row->package_name),
                    $publication,
                    $ad_type,
                    $row->paid,
                    $row->free,
                    "<a href='" . base_url('package/edit/' . html_escape($row->id)) . "' class='btn btn-xs btn-success'><i class='fa fa-edit'></i></a>"
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

}
