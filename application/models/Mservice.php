

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
	function show_mail_list(){
		$this->db->select('mail_id, student.name as sname, student.mobile, recname, date, mail.phone, mail.type, mail.deal, DATEDIFF(CURDATE(), date ) as delay', FALSE)->from('mail');
		$this->db->join('student','student.stu_id=mail.stu_id','left');
		$this->db->where('deal', 0);
		$this->db->order_by('delay');
		$query = $this->db->get();
        return $query->result_array();
	}
	function mail_done($mail_id){
		$curday = date('Y-m-d');
		$data = array(
				'deal' => 1,
				'dealday' => $curday
            );

		$this->db->where('mail_id', $mail_id);
		$this->db->update('mail', $data); 
		return TRUE;
	}
	function mail_remove($mail_id){
		$this->db->where('mail_id', $mail_id);
		$this->db->delete('mail'); 
		return TRUE;
	}

	function add_stu_mail($stu_id, $type, $date, $note){
		$data = array(	'stu_id' => $stu_id ,
						'type' => $type ,
						'date' => $date ,
						'note' => $note );
		$this->db->set($data);
		$this->db->insert('mail'); 
		return TRUE;
	}
	function add_nstu_mail($recname, $phone, $type, $date, $note){
		$data = array(	'recname' => $recname ,
						'phone' => $phone ,
						'type' => $type ,
						'date' => $date ,
						'note' => $note );
		$this->db->set($data);
		$this->db->insert('mail'); 
		return TRUE;
	}
	
}?>