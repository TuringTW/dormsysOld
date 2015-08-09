<?php
class Student extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
		$this->load->library('session');
		$this->load->model(array('login_check', 'Mstudent', 'Mutility'));
		// check login & power, and then init the header
		$required_power = 2;
		$this->login_check->check_init($required_power);

	}
	private function view_header(){
		$data = array(	'title' => 'Home', 
						'user' => $this->session->userdata('user'),
						'power' => $this->session->userdata('power')
					);

		$this->load->view('template/header', $data);
		$this->load->view('template/header_2', $data);
	}
	public function search_name(){
		$keyword = $this->input->post('keyword', TRUE);
		$result = $this->Mstudent->search_name($keyword);

		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function add_stu_info(){
		$stu_id = $this->input->post('stu_id', TRUE);
		$result = $this->Mstudent->add_stu_info($stu_id);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function submitstuinfo(){
		$data = $this->input->post(NULL,true);
		$result = $this->Mstudent->submitstuinfo($data);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function checkdoubleadd(){
		$id_num = $this->input->post('id_num', TRUE);
		$name = $this->input->post('name', TRUE);
		$mobile = $this->input->post('mobile', TRUE);
		$result = $this->Mstudent->checkdoubleadd($name, $id_num, $mobile);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);

	}
}
?>