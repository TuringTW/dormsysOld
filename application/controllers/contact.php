<?php
class Contact extends CI_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
		$this->load->library('session');
		$this->load->model(array('login_check', 'Mcontract', 'Mutility', 'Mfinance', 'Mstudent'));
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
		$this->load->view('template/message_dialog');
		$this->load->view('template/smsModel');
	}
	public function stulist(){
		$this->load->helper('dorm_list_helper');
		$this->view_header();
		$data['active'] = 0;
		$this->load->view('contact/sidebar', $data);

		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$this->load->view('contact/stulist/search_table', $data);

		$this->load->view('contact/stulist/viewModel', $data);

		
		// footer
		$this->load->view('contact/stulist/js_section', $data);
		$this->load->view('template/footer');
	}
	public function room_stu_show(){
		$dorm_id = $this->input->post('dorm_id',TRUE);
		$type = $this->input->post('type',TRUE);
		$result['state'] = true;
		if ($type == 1) {
			$result['result'] = $this->Mutility->get_room_list($dorm_id);
		}else if ($type == 0) {
			$result['result'] = $this->Mstudent->show_dorm_stu($dorm_id);
		}else{
			$result['state'] = false;
		}
		
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function stu_show(){
		$id = $this->input->post('id', TRUE);
		$type = $this->input->post('type', TRUE);
		$result['state'] = true;
		if ($type == 0) {
			$result['result'] = $this->Mstudent->get_stu_info_from_c_id($id);
		}else if ($type == 1) {
			$result['result'] = $this->Mstudent->get_stu_from_room($id);
		}else{
			$result['state'] == false;
		}

		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
}
?>