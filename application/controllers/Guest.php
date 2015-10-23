<?php
class Guest extends CI_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
		$this->load->model(array('Mguest', 'login_check'));
		$this->login_check->log_out(1);
	}


	
	public function mobile_update_get_data(){
		$result = array();
		$auth_code = $this->input->get('auth_code', TRUE);
		$auth_num = $this->input->get('auth_num', TRUE);
	
		if ($this->Mguest->check_auth($auth_num, $auth_code)) {
			$result = $this->Mguest->mobile_app_update();
		}else{
			show_404();
		}

		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);

	}

	public function student_input(){
		$data['title'] = '房客資料輸入';
		$this->load->view('template/header', $data);
		$this->load->view('guest/guest_input/index');
	}
}
?>