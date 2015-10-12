<?php
class Guest extends CI_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
		$this->load->model(array('Mguest'));

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
}
?>