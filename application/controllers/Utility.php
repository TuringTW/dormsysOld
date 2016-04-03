<?php
class Utility extends CI_Controller 
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
	public function room_suggestion(){
		$dorm_id = $this->input->post('dorm_id', true);
		$result['result'] = $this->Mutility->get_room_list($dorm_id);
		$result['state'] = true;
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function get_room_info(){
		$room_id = $this->input->post('room_id', TRUE);
		$result = $this->Mutility->get_room_info($room_id);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);		
	}
}
?>