<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('company_model','person');
	}

	public function index()
	{

		$this->load->library('upload'); 
		$this->load->helper('url');
		//$this->load->view('company'); 
        //$this->data['subview'] = $this->load->view('invoice/company', NULL, TRUE);
        //$this->load->view('layout/header');
        //$this->load->view('layout/_main', $this->data);
        //$this->load->view('layout/footer 
	}

	public function ajax_list()
	{
		$list = $this->person->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[] = $person->name;
			$row[] = $person->address;
			$row[] = $person->phone;
			$row[] = $person->fax;
			$row[] = $person->email;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person->count_all(),
						"recordsFiltered" => $this->person->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->person->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone'),
				'fax' => $this->input->post('fax'),
				'email' => $this->input->post('email'),
				'tax' => $this->input->post('tax'),
				'website' => $this->input->post('website'),  
			);
		$insert = $this->person->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone'),
				'fax' => $this->input->post('fax'),
				'email' => $this->input->post('email'),
				'tax' => $this->input->post('tax'),
				'website' => $this->input->post('website'),  
			);
		$this->person->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->person->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_upload(){
		$config['upload_path']='./uploads';
		$config['allowed_type']='gif|jpg|png';
		$config['max_size']='';
		$config['max_width']='';
		$config['max_height']='';
		$this->load->library('upload',$config);
		if(!$this->upload->ajax_upload()){
			$error = array('error'=>$this->upload->display_errors());
			echo json_encode($error);
		}
		else{ 
			$data = $this->upload->data();
			echo json_encode($data);
		}
	}

}
