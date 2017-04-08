<?php
class Contact extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
		$this->load->library(array('session'));

		$this->load->model(array('login_check', 'Mcontract', 'Mutility', 'Mfinance', 'Mstudent'));

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
	public function stulist(){
		$this->load->helper('dorm_list_helper');
		$this->view_header();
		$data['active'] = 0;
		$this->load->view('contact/sidebar', $data);

		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$this->load->view('contact/stulist/search_table', $data);

		$this->load->view('contact/stulist/viewModel', $data);
		$this->load->view('service/mail/mail_modal', $data);

		// footer
		$this->load->view('contact/stulist/js_section', $data);
		$this->load->view('template/footer');
	}
	public function room_stu_show(){
		$dorm_id = $this->input->post('dorm_id',TRUE);
		$type = $this->input->post('type',TRUE);
		$result['state'] = true;
		if ($type == 1) {
			$result['result'] = $this->Mutility->get_room_list($dorm_id);
		}else if ($type == 0) {
			$result['result'] = $this->Mstudent->show_dorm_stu($dorm_id);
		}else{
			$result['state'] = false;
		}

		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function stu_show(){
		$id = $this->input->post('id', TRUE);
		$type = $this->input->post('type', TRUE);
		$result['state'] = true;
		if ($type == 0) {
			$result['result'] = $this->Mstudent->get_stu_info_from_s_id($id);
		}else if ($type == 1) {
			$result['result'] = $this->Mstudent->get_stu_from_room($id);
		}else{
			$result['state'] == false;
		}

		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function searchnstu(){
		$keyword = $this->input->post('keyword', TRUE);
		$result = $this->Mstudent->searchname_in_c_id($keyword);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function send_sms(){
		$this->load->model('Mservice');

		$rx = $this->input->post('rx', TRUE);
		$content = $this->input->post('content', TRUE);
		$note = $this->input->post('note', TRUE);

		$send_result = $this->Mutility->send_sms($rx, '0927619822', $content, $note);

		$data['json_data'] = $send_result;
		$this->load->view('template/jsonview', $data);
	}
	public function contactbookmobile(){
		$this->load->helper('dorm_list_helper');
		$this->view_header();
		$data['active'] = 1;
		$this->load->view('contact/sidebar', $data);

		$this->load->view('contact/contactbookmobile/search_table');

		// footer
		$this->load->view('contact/contactbookmobile/js_section', $data);
		$this->load->view('template/footer');
	}
	public function mobile_update_auth(){
		$auth_code = $this->input->post('auth_code', TRUE);
		$send_result = $this->Mutility->request_auth_num($auth_code, 'for update mobile contactbook');

		$send_result['target_url'] = web_url('/guest/mobile_update_get_data');
		$data['json_data'] = $send_result;
		$this->load->view('template/jsonview', $data);
	}

}
?>
