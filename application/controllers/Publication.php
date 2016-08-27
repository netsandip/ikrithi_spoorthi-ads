<?php

class Publication extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form'));
        $this->load->library(array('form_validation'));
        $this->load->model('publication_model');
    }

    public function index() {
        $this->data['subview'] = $this->load->view('publication/view', NULL, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }

    public function find_editions($id) {
        $html = "";
        $editions = $this->publication_model->get_editions($id);

        if ($editions) {
            $html .= "<option value=''>Select Edition</option>";
            foreach ($editions as $edition) {
                $html .= "<option value='" . html_escape($edition->edition_name) . "'>";
                $html .= html_escape($edition->edition_name);
                $html .= "</option>";
            }
        } else {
            $html .= "<option value=''>No Editions Found</option>";
        }

        $this->output->set_output($html);
    }
    
    public function find_packages($id, $ad_type_id) {
        $html = "";
        $packages = $this->publication_model->get_packages($id, $ad_type_id);

        if ($packages) {
            $html .= "<option value=''>Select Package</option>";
            foreach ($packages as $package) {
                $html .= "<option value='" . html_escape($package->package_id) . "'>";
                $html .= html_escape($package->package_name);
                $html .= "</option>";
            }
        } else {
            $html .= "<option value=''>No Packages Found</option>";
        }

        $this->output->set_output($html);
    }

    public function quick_add() {
        $data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name');
        $this->load->view('publication/_modal_add', $data);
    }

    public function add() {
        $this->data['action'] = 'publication/add';

        $this->load->model('edition_model');
        /*
         * Form inputs
         */
        $this->data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name', 'value' => set_value('name'));

        /*
         * Validation rules
         */
        $rules_add_publication = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'editions[]',
                'label' => 'Edition',
                'rules' => 'required',
                'errors' => array('required' => 'Please select atleast one edition')
            )
        );
        $this->form_validation->set_rules($rules_add_publication);

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');
        } else {
            $this->publication_model->create();
            $this->session->set_flashdata('message', alert_message('Publication added successfully', 'success'));
            redirect('publication/add', 'refresh');
        }

        $editions = $this->edition_model->find_all(NULL, NULL, array('column' => 'name', 'dir' => 'ASC'));

        if ($editions) {
            foreach ($editions as $edition) {
                $this->data['checkbox_edition'][$edition->name] = array(
                    'name' => 'editions[]',
                    'id' => 'edition_' . $edition->id,
                    'value' => $edition->id,
                    'checked' => set_checkbox('editions[]', $edition->id),
                );
            }
        }

        $this->data['subview'] = $this->load->view('publication/add', $this->data, TRUE);
        $this->load->view('layout/header');
        $this->load->view('layout/_main', $this->data);
        $this->load->view('layout/footer');
    }

    public function edit($id) {
        $this->load->model('edition_model');
        $this->data['action'] = 'publication/edit/' . $id;
        $row = $this->publication_model->find_by_id($id);
        /*
         * Form inputs
         */
        $this->data['input_name'] = array('type' => 'text', 'id' => 'name', 'name' => 'name', 'value' => $row->name);

        /*
         * Validation rules
         */
        $rules_add_publication = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'editions[]',
                'label' => 'Edition',
                'rules' => 'required',
                'errors' => array('required' => 'Please select atleast one edition')
            )
        );
        $this->form_validation->set_rules($rules_add_publication);

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');
        } else {
            $this->publication_model->update($id);
            $this->session->set_flashdata('message', alert_message('Publication updated successfully', 'success'));
            redirect('publication/edit/' . $id, 'refresh');
        }

        $publication_editions = array();
        $publication_edition_result = $this->publication_model->get_editions($id);
        if ($publication_edition_result) {
            foreach ($publication_edition_result as $publication_edition) {
                $publication_editions[] = $publication_edition->edition_id;
            }
        }

        $editions = $this->edition_model->find_all_array(NULL, NULL, array('column' => 'name', 'dir' => 'ASC'));

        if ($editions) {
            foreach ($editions as $edition) {
                $this->data['checkbox_edition'][$edition['name']] = array(
                    'name' => 'editions[]',
                    'id' => 'edition_' . $edition['id'],
                    'value' => $edition['id'],
                    'checked' => in_array($edition['id'], $publication_editions) ? TRUE : FALSE,
                );
            }
        }

        $this->data['subview'] = $this->load->view('publication/add', $this->data, TRUE);
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

        $total_records = $this->publication_model->total_records();
        $return_data = $this->publication_model->get_view($data);

        if ($return_data['query']) {
            $index = 1;
            foreach ($return_data['query']->result() as $row) {
                $edition = $row->edition_name;
                if (empty($edition)) {
                    $edition = '<label class="label label-danger">NOT SET</label>';
                }

                $rows[] = array(
                    $index++,
                    html_escape($row->publication_name),
                    $edition,
                    "<a href='" . base_url('publication/edit/' . html_escape($row->id)) . "' class='btn btn-xs btn-success'><i class='fa fa-edit'></i></a>"
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
