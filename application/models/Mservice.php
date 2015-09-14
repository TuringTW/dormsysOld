

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mservice extends CI_Model
{
	function __construct()
	{
	  // Call the Model constructor
	$this->load->library('session');
	$this->load->model(array('login_check', 'Mutility'));
	$required_power = 2;
	$this->login_check->check_init($required_power);
	parent::__construct();

	}
	function add_sms_record($content,$phone,$note,$stats,$errormsg){
		$admin = $this->session->userdata('m_id');
        $sqldata = array('content'=>$content,'phone'=>$phone,'note'=>$note,'m_id'=>$admin,'send_state'=>$stats,'api_code'=>$errormsg);
       	$this->db->insert('smsdata', $sqldata);
       	return true;
	}

}?>