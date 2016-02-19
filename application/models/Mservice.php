

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
	function show_sms_list($keyword, $page){
		$this->db->select('*')->from('smsdata');
        $this->db->where('( 0',NULL, false); //for logic 
        $this->db->or_like('smsdata.phone',$keyword)->or_like('smsdata.content',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->order_by("send_time", "desc"); 
        // 頁數
        if ($page <= 0) {
            $page = 1;
        }
        $pages = 30*$page-30;
        $this->db->limit(30,$pages);

        $query = $this->db->get();
        return $query->result_array();
	}
	function show_sms_collection(){
		$this->db->select('*')->from('smscollection');
		$query = $this->db->get();
        return $query->result_array();
	}
	function add_sms_collection($content, $type){
		$data = array(	'content' => $content ,
						'type' => $type);
		$this->db->set($data);
		$this->db->insert('smscollection'); 
		return TRUE;
	}
	function show_fix_list(){
		$this->db->select('fr_id, dorm.dorm_id, room, sname, mobile, fix_item, fix_detail, is_allow, dorm.name as dname, timestamp')->from('fix_record')->join('dorm', 'dorm.dorm_id = fix_record.dorm_id', 'left')->where('done', 0);
		$query = $this->db->get();
        return $query->result_array();
	}
	function show_fix_item($fr_id){
		$this->db->select('fr_id, dorm.dorm_id, room, sname, mobile, fix_item, fix_detail, is_allow, dorm.name as dname, timestamp')->from('fix_record')->join('dorm', 'dorm.dorm_id = fix_record.dorm_id', 'left')->where('fix_record.fr_id', $fr_id);
		// die($fr_id);
		$query = $this->db->get();
		$result['state'] = true;
		$result['result'] = $query->row(0);
        return $result;	
	}
	function show_solution_list($fr_id){
		$this->db->select('sr_id, fr_id, type, solution, cost, salary, date')->from('soln_record')->where('fr_id', $fr_id);
		$query = $this->db->get();
		$result['state'] = true;
		$result['result'] = $query->result_array();
        return $result;	
	}
	function show_soltion_item($sr_id){
		$this->db->select('sr_id, fr_id, type, solution, cost, salary, date, timestamp')->from('soln_record')->where('sr_id', $sr_id);
		// die($fr_id);
		$query = $this->db->get();
		$result['state'] = true;
		$result['result'] = $query->row(0);
        return $result;	
	}
	function get_soln_type_list(){
		$this->db->select('st_id, solution, level, cost, salary, note')->from('soln_template')->where('level', 0);
		// die($fr_id);
		$query = $this->db->get();
		$result['state'] = true;
		$result['result'] = $query->result_array();
        return $result;	
	}
	function show_solution_template($type){
		$this->db->select('st_id, solution, level, type_id, cost, salary, note')->from('soln_template')->where('type_id', $type)->where('level', 1);
		$query = $this->db->get();
		$result['state'] = true;
		$result['result'] = $query->result_array();
        return $result;	
	}
	function select_solution_template($template){
		$this->db->select('st_id, solution, level, type_id, cost, salary, note')->from('soln_template')->where('st_id', $template)->where('level', 1);
		$query = $this->db->get();
		if ($query->num_rows()==1) {
		
			$result['state'] = true;
			$result['result'] = $query->row(0);
	
		}else{
			$result['state'] = false;
			// $result['result'] = $query->row(0);		
		}
		return $result;	
	}
}?>