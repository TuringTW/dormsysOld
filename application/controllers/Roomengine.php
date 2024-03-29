<?php
// 搜尋房間、時間軸等
class Roomengine extends CI_Controller
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
		$this->load->view('roomengine/sidebar', $data);
		// body table
		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$this->load->view('roomengine/index/search_table', $data);
		$data['saleslist'] = $this->Mutility->get_user_list();
		$this->load->view('contract/index/viewModel',$data);
		$this->load->view('reservation/index/viewModel',$data);
		$this->load->view('contract/index/printModel');
		$this->load->view('contract/index/break_contract_dialog');
		$this->load->view('contract/index/checkout');
		// footer
		$this->load->view('roomengine/index/js_section');
		$this->load->view('template/footer');
	}
	public function show_avail_room(){
		$dorm_id = $this->input->post('dorm', TRUE);
		$str_date = $this->input->post('str_date', TRUE);
		$end_date = $this->input->post('end_date', TRUE);
		$lprice = $this->input->post('lprice', TRUE);
		$hprice = $this->input->post('hprice', TRUE);
		$type = $this->input->post('type', TRUE);
		$order_method = $this->input->post("order_method", TRUE);
		$order_law = $this->input->post("order_law", TRUE);

		$data['json_data'] = $this->Mcontract->show_avail_room($dorm_id, $str_date, $end_date, $lprice, $hprice, $type, $order_law, $order_method);
		$this->load->view('template/jsonview', $data);
	}
	public function handover(){
		$this->load->helper('dorm_list_helper');
		// header
		$this->view_header();
		// sidebar
		$data['active'] = 1;
		$this->load->view('roomengine/sidebar', $data);
		// body table
		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$this->load->view('roomengine/handover/search_table', $data);
		$data['saleslist'] = $this->Mutility->get_user_list();
		$this->load->view('roomengine/handover/viewModel',$data);
		$this->load->view('contract/index/printModel');
		$this->load->view('contract/index/break_contract_dialog');
		$this->load->view('contract/index/checkout');
		$this->load->view('contract/index/rentdepositModal');


		// footer
		$this->load->view('roomengine/handover/js_section', $data);
		$this->load->view('template/footer');
	}
	public function show_handover_list(){
		$keyword = $this->input->post('keyword', True);
		$dorm = $this->input->post('dorm', True);
		$start_val = $this->input->post('startval', True);
		$end_val = $this->input->post('endval', True);

		$data['json_data'] = $this->Mcontract->show_handover_list($keyword, $dorm, $start_val, $end_val);
		$this->load->view('template/jsonview', $data);
	}
}
?>
