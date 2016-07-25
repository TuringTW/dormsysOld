<?php
class Api extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('My_url_helper','url'));
		$this->load->model(array('Mapi', 'login_check'));
		// $this->login_check->log_out(1);
    // $auth_code = $this->input->get('auth_code', TRUE);
    // $auth_num = $this->input->get('auth_num', TRUE);
    // if ($this->Mapi->check_auth($auth_num, $auth_code)) {
    //     $result = $this->Mapi->mobile_app_update();
    // }else{
    //     show_404();
    // }
	}

	public function phone_detect(){
    $phone = $this->input->get("phone", TRUE);
    $result = $this->Mapi->search_by_phone($phone);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);

	}
}
?>
