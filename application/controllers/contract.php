<?php
class Contract extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
		$this->load->library('session');
		$this->load->model(array('login_check', 'Mcontract', 'Mutility'));
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
	public function index($c_num=0)
	{	
		$this->load->helper('dorm_list_helper');
		// header
		$this->view_header();
		// sidebar
		$data['active'] = 0;
		$this->load->view('contract/sidebar', $data);
		// body table
		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$this->load->view('contract/index/search_table', $data);
		$data['saleslist'] = $this->Mutility->get_user_list();
		$this->load->view('contract/index/viewModel',$data);
		$this->load->view('contract/index/break_contract_dialog');
		$this->load->view('contract/index/checkout');

		// footer
		$this->load->view('contract/index/js_section');
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
	public function due_ofd_refresh()
	{
		$keyword = $this->input->post("keyword", TRUE);
		$dorm = $this->input->post("dorm", TRUE);
		$data['json_data'] = $this->Mcontract->count_ofd_due($dorm, $keyword);
		$this->load->view('template/jsonview', $data);
	}
	public function show_contract()
	{
		$c_num = $this->input->post('c_num', true);
		$data['json_data'] = $this->Mcontract->get_contract_info($c_num);
		$this->load->view('template/jsonview', $data);

	}
	public function edit(){
		$c_num = $this->input->post('c_num', TRUE);
		$in_date = $this->input->post('in_date', TRUE);
		$out_date = $this->input->post('out_date', TRUE);
		$sales = $this->input->post('sales', TRUE);
		$note = $this->input->post('note', TRUE);

		$result = $this->Mcontract->edit_contract($c_num, $in_date, $out_date, $sales, $note);
		if ($result) {
			$data['json_data'] = $result;
			$this->load->view('template/jsonview', $data);
		}
	}
	public function break_contract()
	{
		$c_num = $this->input->post('c_num',TRUE);
		$b_date = $this->input->post('b_date',TRUE);

		$result = $this->Mcontract->break_contract($c_num, $b_date);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function date_check_by_room()
	{
		$in_date = $this->input->post('in_date', TRUE);
		$out_date = $this->input->post('out_date', TRUE);
		$room_id = $this->input->post('room_id', TRUE);
		$result = $this->Mcontract->date_check_by_room($room_id, $in_date, $out_date);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function checkout_contract()
	{
		$c_num = $this->input->post('c_num', TRUE);
		$result = $this->Mcontract->set_check_out($c_num);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);	
	}
	public function checkout()
	{
		$this->load->helper('dorm_list_helper');
		// header
		$this->view_header();
		// sidebar
		$data['active'] = 1;
		$this->load->view('contract/sidebar', $data);
		// body table
		// $data['dormlist'] = $this->Mutility->get_dorm_list();
		// $this->load->view('contract/search_table', $data);
		// $data['saleslist'] = $this->Mutility->get_user_list();
		// $this->load->view('contract/viewModel',$data);
		// $this->load->view('contract/break_contract_dialog');

		// footer
		$this->load->view('contract/index/js_section');
		$this->load->view('template/footer');
	}
	public function newcontract(){
		$this->load->model('Mstudent');
		$this->view_header();
		$data['active'] = 3;
		$this->load->view('contract/sidebar', $data);
		// $data['dormlist'] = $this->Mutility->get_dorm_list();
		$this->load->view('contract/newcontract/newcontract', $data);


		$this->load->view('contract/newcontract/js_section');
		$this->load->view('template/footer');
	}
}
?>