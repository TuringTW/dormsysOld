<?php
// 進行送信等操作
class Service extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper', 'dorm_list_helper'));
		$this->load->library('session');
		$this->load->model(array('login_check', 'Mstudent', 'Mservice'));
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
	public function mail(){
		$this->view_header();
		// sidebar
		$data['active'] = 0;
		$this->load->view('service/sidebar', $data);
		$data['mail_list'] = $this->Mservice->show_mail_list();
		$this->load->view('service/mail/search_table', $data);

		$this->load->view('service/mail/mail_modal', $data);
		
		$this->load->view('service/mail/js_section', $data);
		$this->load->view('template/footer');
	}
	public function show_mail(){
		$data['json_data'] = $this->Mservice->show_mail_list();
		$this->load->view('template/jsonview', $data);
	}
	public function mail_done(){
		$mail_id = $this->input->post('mail_id', TRUE);
		$data['json_data'] = $this->Mservice->mail_done($mail_id);
		$this->load->view('template/jsonview', $data);
	}

	public function mail_remove(){
		$mail_id = $this->input->post('mail_id', TRUE);
		$data['json_data'] = $this->Mservice->mail_remove($mail_id);
		$this->load->view('template/jsonview', $data);
	}

	public function add_stu_mail(){
		$stu_id = $this->input->post('stu_id', TRUE);
		$type = $this->input->post('type', TRUE);
		$date = $this->input->post('date', TRUE);
		$note = $this->input->post('note', TRUE);
		$data['json_data'] = $this->Mservice->add_stu_mail($stu_id, $type, $date, $note);
		$this->load->view('template/jsonview', $data);

	}	
	public function add_nstu_mail(){
		$recname = $this->input->post('recname', TRUE);
		$phone = $this->input->post('phone', TRUE);
		$type = $this->input->post('type', TRUE);
		$date = $this->input->post('date', TRUE);
		$note = $this->input->post('note', TRUE);
		$data['json_data'] = $this->Mservice->add_nstu_mail($recname, $phone, $type, $date, $note);
		$this->load->view('template/jsonview', $data);

	}
	public function sms(){
		$this->view_header();
		// sidebar
		$data['active'] = 1;
		$this->load->view('service/sidebar', $data);
		$this->load->view('service/sms/search_table', $data);

		// $this->load->view('service/sms/mail_modal', $data);
		
		$this->load->view('service/sms/js_section', $data);
		$this->load->view('template/footer');
	}
	public function show_sms(){
		$keyword = $this->input->post("keyword", TRUE);
		$page = $this->input->post("page", TRUE);
		
		$data['json_data'] = $this->Mservice->show_sms_list($keyword, $page);

		$this->load->view('template/jsonview', $data);
	}
	public function smscollection(){
		$this->view_header();
		// sidebar
		$data['active'] = 2;
		$this->load->view('service/sidebar', $data);
		$data['mail_list'] = $this->Mservice->show_mail_list();
		$this->load->view('service/smscollection/search_table', $data);

		// $this->load->view('service/sms/mail_modal', $data);
		$this->load->view('service/smscollection/new_collection_modal', $data);
		$this->load->view('service/smscollection/js_section', $data);
		$this->load->view('template/footer');
	}
	public function show_sms_collection(){
		$data['json_data'] = $this->Mservice->show_sms_collection();
		$this->load->view('template/jsonview', $data);
	}
	public function add_sms_collection(){
		$content = $this->input->post('content', TRUE);
		$type = $this->input->post('type', TRUE);

		$data['json_data'] = $this->Mservice->add_sms_collection($content, $type);
		$this->load->view('template/jsonview', $data);
	}
	public function fix_record(){
		$this->view_header();
		$data['active'] = 3;
		
		$this->load->view('service/sidebar', $data);
		$data['dormlist'] = $this->Mutility->get_dorm_list();
		$this->load->view("service/fix/search_table", $data);
		
		$this->load->view('service/fix/viewModel',$data);
		$this->load->view("service/fix/js_section", $data);


		$this->load->view("template/footer");
	}	
	public function show_fix_list(){
		$data['json_data'] = $this->Mservice->show_fix_list();
		$this->load->view('template/jsonview', $data);
	}
	public function show_fix_item(){
		$fr_id = $this->input->post('fr_id', TRUE);
		$data['json_data'] = $this->Mservice->show_fix_item($fr_id);
		$this->load->view('template/jsonview', $data);
	}
}
?>

