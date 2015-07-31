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

		$this->load->view('template/footer');
	}

	// public function view($slug)
	// {
	// 	$data['news_item'] = $this->news_model->get_news($slug);

	// 	if (empty($data['news_item']))
	// 	{
	// 		show_404();
	// 	}

	// 	$data['title'] = $data['news_item']['title'];

	// 	$this->load->view('template/header', $data);
	// 	$this->load->view('news/view', $data);
	// 	$this->load->view('template/footer');
	// }
	// public function create()
	// {
	// 	$this->load->helper('form');
	// 	$this->load->library('form_validation');
		
	// 	$data['title'] = 'Create a news item';
		
	// 	$this->form_validation->set_rules('title', '標題', 'required');
	// 	$this->form_validation->set_rules('text', '內文', 'required');
		
	// 	if ($this->form_validation->run() === FALSE)
	// 	{
	// 		$this->load->view('template/header', $data);	
	// 		$this->load->view('news/create');
	// 		$this->load->view('template/footer');
			
	// 	}
	// 	else
	// 	{
	// 		$this->news_model->set_news();
	// 		$this->load->view('news/success');
	// 	}
	// }

	
}
?>