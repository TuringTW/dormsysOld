<?php
class RoomEngine extends CI_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
		$this->load->library(array('session'));
		$this->load->model(array('login_check', 'Mcontract', 'Mutility', 'Mfinance'));
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
	public function index($c_num=0){	
		$this->load->helper('dorm_list_helper');
		// header
		$this->view_header();
		// sidebar
		$data['active'] = 0;
		$this->load->view('contract/sidebar', $data);
		// body table
<<<<<<< HEAD
		$data['dormlist'] = $this->Mutility->get_dorm_list();
<<<<<<< HEAD
<<<<<<< HEAD
		$this->load->view('roomengine/index/search_table', $data);
=======
		// $data['dormlist'] = $this->Mutility->get_dorm_list();
		// $this->load->view('contract/index/search_table', $data);
>>>>>>> parent of 2803106... wrong commit
		// $data['saleslist'] = $this->Mutility->get_user_list();
		// $this->load->view('contract/index/viewModel',$data);
		// $this->load->view('contract/index/checkout');
=======
=======
>>>>>>> parent of f04623b... add roomengine
		$this->load->view('contract/index/search_table', $data);
		$data['saleslist'] = $this->Mutility->get_user_list();
		$this->load->view('contract/index/viewModel',$data);
		$this->load->view('contract/index/checkout');
<<<<<<< HEAD
>>>>>>> parent of f04623b... add roomengine
=======
>>>>>>> parent of f04623b... add roomengine

		// footer
		$this->load->view('contract/index/js_section');
		$this->load->view('template/footer');
	}
	
}
?>