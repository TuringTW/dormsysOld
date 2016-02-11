<?php
class Index extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('My_url_helper','url'));
		$this->load->library('session');
		$this->load->model(array('login_check', 'Mcontract'));
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
	public function index()
	{
		// header
		$this->view_header();
		$this->load->view('index/index/sidebar');
		$data['count_ofd_due'] = $this->Mcontract->count_ofd_due(0, '');
		$data['contract_due'] = $this->Mcontract->show_contract_list('', 0, 0, 2, 0, 1, 11, 0, 1);
		// 一個月內遷出
		$data['contract_due_in_a_month'] = $this->Mcontract->show_contract_list('', 0, 0, 2, 0, 1, 10, 0, 1);

		$this->load->view('index/index/control_panel', $data);



		$this->load->view('service/mail/mail_modal');
		$this->load->view('index/index/js_section');
		$this->load->view('template/footer');
	}

	



// 登出
	public function logout()
	{
		$this->login_check->log_out();
	}
}
?>