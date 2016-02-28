

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mguest extends CI_Model
{
	function __construct()
	{
	  // Call the Model constructor
	$this->load->library('session');
	$this->load->model(array('login_check'));
	// $required_power = 2;
	// $this->login_check->check_init($required_power);
	parent::__construct();

	}

	function mobile_app_update(){
		$resultArray = array();
		$this->db->select('dorm_id, name as dname')->from('dorm');
		$query = $this->db->get();
		$dormlist = array();
		foreach (array_values($query->result_array()) as $key => $value) {
			array_push($dormlist, array_values($value));
		}
		array_push($resultArray, $dormlist);

		$this->db->flush_cache();

		$today = date('Y-m-d');

		$this->db->select('dorm, room.name as rname, student.name as sname, mobile,emg_name, emg_phone')->from('contract');
		$this->db->join('contractpeo', 'contract.contract_id = contractpeo.contract_id', 'left');
		$this->db->join('room', 'contract.room_id = room.room_id', 'left');
		$this->db->join('student', 'student.stu_id = contractpeo.stu_id', 'left');
		$this->db->where('seal', 0)->where("DATEDIFF(out_date, '$today')>", 0)->where("DATEDIFF(in_date, '$today')<", 0);
		$this->db->order_by('room.name')->order_by('student.name');
		$query = $this->db->get();

		$stuinfo = array();
		foreach (array_values($query->result_array()) as $key => $value) {
			array_push($stuinfo, array_values($value));
		}
		array_push($resultArray, $stuinfo);

		return $resultArray;
	}
	function check_auth($auth_num, $auth_code){
        $auth_code = ($auth_code-1)/5;

        $this->db->select('auth_id')->from('auth_record');
        $this->db->where('TIMESTAMPDIFF(MINUTE,`timestamp`,CURRENT_TIMESTAMP())<', 5)->where('auth_code', $auth_code)->where('auth_num', $auth_num);
        $query = $this->db->get();
        if ($query->num_rows()==1) {

            $auth_id = $query->result_array()[0]['auth_id'];
            
            $this->db->flush_cache();

            $data = array('isexpired'=>1);
            $this->db->where('auth_id', $auth_id);
            $this->db->update('auth_record', $data);
            return true;
        }else{
            return false;
        }
    }
	
}?>