<?php
class Contract extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
		$this->load->library('session');
		$this->load->model(array('login_check', 'Mcontract', 'utility'));
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
	public function index()
	{
		$this->load->helper('dorm_list_helper');
		// header
		$this->view_header();
		// sidebar
		$data['active'] = 0;
		$this->load->view('contract/sidebar', $data);
		// body table
		$data['dormlist'] = $this->utility->get_dorm_list();
		$this->load->view('contract/search_table', $data);

		// footer
		$this->load->view('contract/js_section');
		$this->load->view('template/footer');
	}
	public function show()
	{
		$keyword = $this->input->post("keyword", TRUE);
		$page = $this->input->post("page", TRUE);
		$due = $this->input->post("due_value", TRUE);
		$ofd = $this->input->post("ofd_value", TRUE);
		$dorm = $this->input->post("dorm", TRUE);
		
		$data['json_data'] = $this->Mcontract->show_contract_list($keyword, $dorm, 0, $due, $ofd, $page);
		$this->load->view('template/jsonview', $data);
	}
	

	
}
?>