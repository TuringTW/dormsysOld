<?php
class Reservation extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
		$this->load->library(array('session'));
		$this->load->model(array('login_check', 'Mcontract', 'Mutility', 'Mfinance', 'Mprint', 'Mreservation'));
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


		$this->load->helper('dorm_list_helper');
		// header
		$this->view_header();
		// sidebar
		$data['active'] = 0;
		$this->load->view('reservation/sidebar', $data);
		// body table
		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$this->load->view('reservation/index/search_table', $data);
		$data['saleslist'] = $this->Mutility->get_user_list();
		$this->load->view('reservation/index/viewModel',$data);
		$this->load->view('contract/index/printModel');
		$this->load->view('contract/index/break_contract_dialog');
		$this->load->view('contract/index/checkout');
		$this->load->view('contract/index/rentdepositModal');

		// footer
		$this->load->view('reservation/index/js_section', $data);
		$this->load->view('template/footer');
	}
	public function show(){
		$keyword = $this->input->post("keyword", TRUE);
		$page = $this->input->post("page", TRUE);
		$ofd = $this->input->post("ofd_value", TRUE);
		$dorm = $this->input->post("dorm", TRUE);
    $wait = $this->input->post("wait_value", TRUE);
		$order_method = $this->input->post("order_method", TRUE);
		$order_law = $this->input->post("order_law", TRUE);
		$start_val = $this->input->post("startval", TRUE);
		$end_val = $this->input->post("endval", TRUE);

		$data['json_data'] = $this->Mreservation->show_reservation_list($keyword, $dorm, $ofd, $wait, $page, $order_method, $order_law, 0, $start_val, $end_val);
		$this->load->view('template/jsonview', $data);
	}
	public function due_ofd_refresh(){
		$keyword = $this->input->post("keyword", TRUE);
		$dorm = $this->input->post("dorm", TRUE);
		$start_val = $this->input->post("startval", TRUE);
		$end_val = $this->input->post("endval", TRUE);

		$data['json_data'] = $this->Mreservation->count_ofd_due($dorm, $keyword, $start_val, $end_val);
		$this->load->view('template/jsonview', $data);
	}
	public function show_reservation(){
		$r_id = $this->input->post('r_id', true);
		$data['json_data'] = $this->Mreservation->get_reservation_info($r_id);
		$this->load->view('template/jsonview', $data);
	}
	public function edit(){
		$r_id = $this->input->post('r_id', TRUE);
		$s_date = $this->input->post('s_date', TRUE);
		$e_date = $this->input->post('e_date', TRUE);
    $d_date = $this->input->post('d_date', TRUE);
    $sales = $this->input->post('sales', TRUE);
    $sname = $this->input->post('sname', TRUE);
    $mobile = $this->input->post('mobile', TRUE);
		$note = $this->input->post('note', TRUE);


		$result = $this->Mreser->edit_contract($r_id, $sname, $mobile, $s_date, $e_date, $d_date, $sales, $note);
		if ($result) {
			$data['json_data'] = $result;
			$this->load->view('template/jsonview', $data);
		}
	}
	public function newres(){


		$this->view_header();
		$data['active'] = 1;
		$this->load->view('reservation/sidebar', $data);
		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$data['saleslist'] = $this->Mutility->get_user_list();
		$this->load->view('reservation/new/new', $data);

		$this->load->view('contract/newcontract/overlapModal');


		$this->load->view('reservation/new/js_section');
		$this->load->view('template/footer');
	}








	public function break_contract(){
		$contract_id = $this->input->post('contract_id',TRUE);
		$b_date = $this->input->post('b_date',TRUE);

		$result = $this->Mcontract->break_contract($contract_id, $b_date);
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
	public function submit_reservation(){
		$new_sname = $this->input->post('new_sname', TRUE);
		$new_mobile = $this->input->post('new_mobile', TRUE);
		$dorm_select = $this->input->post('dorm_select', TRUE);
		$room_select = $this->input->post('room_select', TRUE);
		$d_date = $this->input->post('d_date', TRUE);
		$sales = $this->input->post('sales', TRUE);
		$note = $this->input->post('note', TRUE);
		$datepickerStart = $this->input->post('datepickerStart', TRUE);
		$datepickerEnd = $this->input->post('datepickerEnd', TRUE);
		$res_deposit = $this->input->post('res_deposit', TRUE);

		$data['json_data'] = $this->Mreservation->add_reservation($new_sname, $new_mobile, $dorm_select, $room_select, $d_date, $sales, $note, $datepickerStart, $datepickerEnd, $res_deposit);
		$this->load->view('template/jsonview', $data);

	}
	public function pdf_gen(){
		$this->load->library(array('pdf'));

		$r_id = $this->input->get('r_id', TRUE);
		if (!is_null($r_id)&&is_numeric($r_id)) {
			$this->Mreservation->pdf_gen($r_id, 0);
		}
	}

	public function print_contract(){
		$contract_id = $this->input->get('contract_id', TRUE);
		$printer_id = $this->input->post('printer_id', TRUE);
		$path = $this->Mcontract->pdf_gen($contract_id, 1); //server  side
		$result = $this->Mprint->document_gcp_print($path, $printer_id);

		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function keep_contract_check(){
		$result = false;
		$contract_id = $this->input->post('contract_id', TRUE);
		$contract_info = $this->Mcontract->get_contract_info($contract_id)[0];

		if ($contract_info) {
			$dted = $this->Mutility->date_diff(date('Y-m-d'),$contract_info['e_date']);
			// 檢查有可不可以續約
			if ($dted['td']<=90) {
				// 可以續約 先把原合約結算
				$result = $this->Mcontract->set_keep($contract_id);
			}
		}

		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function delete_contract(){
		$contract_id = $this->input->post("contract_id", TRUE);
		$result = $this->Mcontract->delete_contract($contract_id);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
}
?>
