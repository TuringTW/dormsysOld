<?php
class Database extends CI_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper', 'dorm_list_helper'));
		$this->load->library(array('session'));
		$this->load->model(array('login_check', 'Mcontract', 'Mutility', 'Mfinance', 'Mprint'));
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
	public function dorm(){	
		// header
		$this->view_header();
		// sidebar
		$data['active'] = 0;
		$this->load->view('database/sidebar', $data);
		// searchtable
		// footer
		$this->load->view('contract/index/js_section');
		$this->load->view('template/footer');
	}
	
	public function room(){	
		// header
		$this->view_header();
		// sidebar
		$data['active'] = 1;
		$this->load->view('database/sidebar', $data);
		//searchtable
		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$this->load->view('database/room/search_table', $data);

		// footer
		$this->load->view('database/room/js_section');
		$this->load->view('template/footer');
	}
	public function edit_room_info(){
		$room_name = $this->input->post("room_name", TRUE);
		$rent = $this->input->post("rent", TRUE);
		$type_select = $this->input->post("type_select", TRUE);
		$note = $this->input->post("note", TRUE);
		$room_id = $this->input->post("room_id", TRUE);
		$dorm_id = $this->input->post("dorm_id", TRUE);
		
		$data['json_data'] = $this->Mutility->edit_room_info($room_name, $rent, $type_select, $note, $room_id, $dorm_id);
		$this->load->view('template/jsonview', $data);
	}

	
}
?>