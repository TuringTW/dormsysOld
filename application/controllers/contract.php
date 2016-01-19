<?php
class Contract extends CI_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
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
	public function index($contract_id=0){	
		// get contract_id
		$data['view_contract_id'] = $this->input->get('contract_id', TRUE);
		if (is_null($data['view_contract_id'])) {
			$data['view_contract_id'] = 0;
		}
		if (!is_numeric($data['view_contract_id'])||$data['view_contract_id']<0) {
			$data['view_contract_id'] = -1;
		}
		$data['view_ofd_contract'] = $this->input->get('option', TRUE);
		if (is_null($data['view_ofd_contract'])) {
			$data['view_ofd_contract'] = 0;
		}
		if (!is_numeric($data['view_ofd_contract'])||$data['view_ofd_contract']<0) {
			$data['view_ofd_contract'] = 0;
		}

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
		$this->load->view('contract/index/rentdepositModal');
		// footer
		$this->load->view('contract/index/js_section', $data);
		$this->load->view('template/footer');
	}
	public function show(){
		$keyword = $this->input->post("keyword", TRUE);
		$page = $this->input->post("page", TRUE);
		$due = $this->input->post("due_value", TRUE);
		$ofd = $this->input->post("ofd_value", TRUE);
		$dorm = $this->input->post("dorm", TRUE);
		
		$data['json_data'] = $this->Mcontract->show_contract_list($keyword, $dorm, 0, $due, $ofd, $page);
		$this->load->view('template/jsonview', $data);
	}
	public function due_ofd_refresh(){
		$keyword = $this->input->post("keyword", TRUE);
		$dorm = $this->input->post("dorm", TRUE);
		$data['json_data'] = $this->Mcontract->count_ofd_due($dorm, $keyword);
		$this->load->view('template/jsonview', $data);
	}
	public function show_contract(){
		$contract_id = $this->input->post('contract_id', true);
		$data['json_data'] = $this->Mcontract->get_contract_info($contract_id);
		$this->load->view('template/jsonview', $data);
	}
	public function edit(){
		$contract_id = $this->input->post('contract_id', TRUE);
		$in_date = $this->input->post('in_date', TRUE);
		$out_date = $this->input->post('out_date', TRUE);
		$sales = $this->input->post('sales', TRUE);
		$note = $this->input->post('note', TRUE);

		$result = $this->Mcontract->edit_contract($contract_id, $in_date, $out_date, $sales, $note);
		if ($result) {
			$data['json_data'] = $result;
			$this->load->view('template/jsonview', $data);
		}
	}
	public function break_contract(){
		$contract_id = $this->input->post('contract_id',TRUE);
		$b_date = $this->input->post('b_date',TRUE);

		$result = $this->Mcontract->break_contract($contract_id, $b_date);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function date_check_by_room(){
		$in_date = $this->input->post('in_date', TRUE);
		$out_date = $this->input->post('out_date', TRUE);
		$room_id = $this->input->post('room_id', TRUE);
		$contract_id = $this->input->post('contract_id', TRUE);
		$result = $this->Mcontract->date_check_by_room($room_id, $in_date, $out_date, $contract_id);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function checkout_contract(){
		$contract_id = $this->input->post('contract_id', TRUE);
		$result = $this->Mcontract->set_check_out($contract_id);
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
		$keep = $this->input->get('keep', TRUE);
		if (!is_null($keep)&&is_numeric($keep)) {
			$data['keep'] = $keep;
			$data['keep_result'] = $this->Mcontract->get_keep_info($keep);

		}else{
			$data['keep'] = null;
			$data['keep_result'] = array();
		}
		

		$this->load->model('Mstudent');
		$this->view_header();
		$data['active'] = 1;
		$this->load->view('contract/sidebar', $data);
		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$data['saleslist'] = $this->Mutility->get_user_list();
		$this->load->view('contract/newcontract/newcontract', $data);
		$this->load->view('contract/newcontract/overlapModal');
		
		$this->load->view('contract/index/rentdepositModal');

		$this->load->view('contract/newcontract/js_section');
		$this->load->view('template/footer');
	}
	public function get_rent_cal(){
		$s_date = $this->input->post('s_date', TRUE);
		$e_date = $this->input->post('e_date', TRUE);
		$rpm = $this->input->post('rpm', TRUE);
		$countpeo = $this->input->post('countpeo', TRUE);
		$data['json_data'] = $this->Mfinance->rent_cal($rpm, $s_date, $e_date, $countpeo);
		$this->load->view('template/jsonview', $data);	
	}
	public function check_not_over_lap(){
		$s_date = $this->input->post('s_date',TRUE);		
		$e_date = $this->input->post('e_date',TRUE);
		$room_id = $this->input->post('room_id',TRUE);
		if (is_numeric($room_id)&&$room_id!==0) {
			$data['json_data'] = $this->Mcontract->checknotoverlap($room_id, $s_date, $e_date);
		}
		else{
			$data['json_data']['state'] = -1;
		}
		$this->load->view('template/jsonview', $data);	

	}
	public function submitcontract(){
		$json_data = $this->input->post('json_data', TRUE);
		$cdata = json_decode($json_data, TRUE);

		$data['json_data'] = $this->Mcontract->add_contract($cdata);
		$this->load->view('template/jsonview', $data);	

	}
	public function pdf_gen(){
		$this->load->library(array('pdf'));

		$contract_id = $this->input->get('contract_id', TRUE);
		if (!is_null($contract_id)&&is_numeric($contract_id)) {
			$this->Mcontract->pdf_gen($contract_id, 0);
		}
	}
	public function move_to_new_data_base(){
		
		$result = $this->Mcontract->move_to_new_data_base();
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);	
	}
	public function print_contract(){
		$contract_id = $this->input->get('contract_id', TRUE);
		$printer_id = $this->input->post('printer_id', TRUE);
		$path = $this->Mcontract->pdf_gen($contract_id, 1); //server  side
		$result = $this->Mprint->document_gcp_print($path, $printer_id);

		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
}
?>