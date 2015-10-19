<?php
class Index extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('My_url_helper','url'));
		$this->load->library('session');
		$this->load->model('login_check');
		// check login & power, and then init the header
		$required_power = 2;
		$this->login_check->check_init($required_power);

	}

	public function index()
	{
		// header
		$data = array(	'title' => 'Home', 
						'user' => $this->session->userdata('user'),
						'power' => $this->session->userdata('power')
					);

		$this->load->view('template/header', $data);
		$this->load->view('template/header_2', $data);




		$this->load->view('template/footer');
	}

	



// 登出
	public function logout()
	{
		$this->login_check->log_out();
	}
}
?>