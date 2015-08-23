<?php
class Student extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
		$this->load->library('session');
		$this->load->model(array('login_check', 'Mstudent', 'Mutility'));
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
	}
	public function search_name(){
		$keyword = $this->input->post('keyword', TRUE);
		$result = $this->Mstudent->search_name($keyword);

		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function add_stu_info(){
		$stu_id = $this->input->post('stu_id', TRUE);
		$result = $this->Mstudent->add_stu_info($stu_id);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function submitstuinfo(){
		$data = $this->input->post(NULL,true);
		$result = $this->Mstudent->submitstuinfo($data);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);
	}
	public function checkdoubleadd(){
		$id_num = $this->input->post('id_num', TRUE);
		$name = $this->input->post('name', TRUE);
		$mobile = $this->input->post('mobile', TRUE);
		$result = $this->Mstudent->checkdoubleadd($name, $id_num, $mobile);
		$data['json_data'] = $result;
		$this->load->view('template/jsonview', $data);

	}

	public function index(){
		$data['stu_id'] = $this->input->get('view',TRUE);
		if (!is_numeric($data['stu_id'])||$data['stu_id']<=0) {
			$data['stu_id'] = 0;
		}
		$this->view_header();
		$data['active'] = 4;
		$this->load->view('contract/sidebar', $data);
		$this->load->view('/student/search_table');
		$this->load->view('/student/viewModal');


		$this->load->view('/student/js_section',$data);
		$this->load->view('template/footer');
	}
	public function show(){
		$keyword = $this->input->post("keyword", TRUE);
		$page = $this->input->post("page", TRUE);
		
		$data['json_data'] = $this->Mstudent->show_student_list($keyword, $page);
		$this->load->view('template/jsonview', $data);
	}
	public function show_stu_info(){
		$stu_id = $this->input->post("stu_id", TRUE);
		
		$data['json_data'] = $this->Mstudent->get_stu_info($stu_id);
		$this->load->view('template/jsonview', $data);
	}
	public function edit(){
		$stu_id = $this->input->post('stu_id',TRUE);
		$reg_address = $this->input->post('reg_address',TRUE);
		$mailing_address = $this->input->post('mailing_address',TRUE);
		$name = $this->input->post('name',TRUE);
		$school = $this->input->post('school',TRUE);
		$mobile = $this->input->post('mobile',TRUE);
		$home = $this->input->post('home',TRUE);
		$email = $this->input->post('email',TRUE);
		$id_num = $this->input->post('id_num',TRUE);
		$birthday = $this->input->post('birthday',TRUE);
		$emg_name = $this->input->post('emg_name',TRUE);
		$emg_phone = $this->input->post('emg_phone',TRUE);
		$note = $this->input->post('note',TRUE);

		$data['json_data'] = $this->Mstudent->edit_stu_info($stu_id, $reg_address, $mailing_address, $name, $school, $mobile, $home, $email, $id_num, $birthday, $emg_name, $emg_phone, $note);
		$this->load->view('template/jsonview', $data);


	}
}
?>