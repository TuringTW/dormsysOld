<?php
class Accounting extends CI_Controller 
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
	public function expenditure($contract_id=0){	
		$this->load->helper('dorm_list_helper');
		// header
		$this->view_header();
		// sidebar
		$data['active'] = 0;
		$this->load->view('accounting/sidebar', $data);
		// body table
		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$data['typelist'] = $this->Mutility->get_type_list();
		$this->load->view('accounting/expenditure/search_table', $data);
		$data['manager'] = $this->Mutility->get_user_list();
		$this->load->view('accounting/expenditure/viewModel',$data);


		// footer
		$this->load->view('accounting/expenditure/js_section');
		$this->load->view('template/footer');
	}
	public function show_item_list(){
		$keyword = $this->input->post("keyword", TRUE);
		$page = $this->input->post("page", TRUE);
		$type = $this->input->post("type", TRUE);
		$rtype = $this->input->post("rtype", TRUE);
		$dorm = $this->input->post("dorm", TRUE);
		
		$data['json_data'] = $this->Mfinance->show_expenditure_list($keyword, $page, $type, $dorm, $rtype);

		$this->load->view('template/jsonview', $data);
	}
	public function show_item(){
		$item_id = $this->input->post('item_id', TRUE);
		if (!is_null($item_id)&&$item_id>0) {
			$result = $this->Mfinance->show_item($item_id);
			
		}else{
			$result['state'] = false;
		}
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function itemedit(){
		$rtype = $this->input->post('rtype', TRUE);
		$item = $this->input->post('item', TRUE);
		$type = $this->input->post('type', TRUE);
		$note = $this->input->post('note', TRUE);
		$company = $this->input->post('company', TRUE);
		$money = $this->input->post('money', TRUE);
		$date = $this->input->post('date', TRUE);
		$dorm = $this->input->post('dorm', TRUE);
		$billing = $this->input->post('billing', TRUE);
		$item_id = $this->input->post('item_id', TRUE);
		if (!is_null($item_id)&&$item_id>=0) {
			$result = $this->Mfinance->edit_item($rtype, $item, $type, $note, $company, $money, $date, $dorm, $billing, $item_id);
		}else{
			$result['state'] = false;
		}
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
// 租金
	public function show_rent_detail(){
		$contract_id = $this->input->post('contract_id', TRUE);
		if (!is_null($contract_id)&&$contract_id>=0) {
			$result = $this->Mfinance->show_rent_detail($contract_id, 0);
		}else{
			$result['state'] = false;
		}
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function add_rent_record(){
		$type = $this->input->post('type', TRUE);
		$value = $this->input->post('value', TRUE);
		$date = $this->input->post('date', TRUE);
		$description = $this->input->post('description', TRUE);
		$contract_id = $this->input->post('contract_id', TRUE);

		if (!is_null($contract_id)&&$contract_id>=0) {
			$result = $this->Mfinance->add_rent_record($type, $value, $date, $description, $contract_id);
		}else{
			$result['state'] = false;
		}
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);

	}

	public function show_pay_rent_detail(){
		$contract_id = $this->input->post('contract_id', TRUE);
		if (!is_null($contract_id)&&$contract_id>=0) {
			$result = $this->Mfinance->show_rent_detail($contract_id, 1);
		}else{
			$result['state'] = false;
		}
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function add_pay_rent_record(){
		$source = $this->input->post('source', TRUE);
		$value = $this->input->post('value', TRUE);
		$from = $this->input->post('from', TRUE);
		$date = $this->input->post('date', TRUE);
		$r_id = $this->input->post('r_id', TRUE);
		$description = $this->input->post('description', TRUE);
		$contract_id = $this->input->post('contract_id', TRUE);

		if (!is_null($contract_id)&&$contract_id>=0) {
			$result = $this->Mfinance->add_pay_rent_record($source, $value, $from, $date, $r_id, $description, $contract_id);
		}else{
			$result['state'] = false;
		}
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);

	}
	
}
?>