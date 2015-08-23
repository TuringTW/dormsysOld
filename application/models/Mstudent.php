

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mstudent extends CI_Model
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

	function search_name($keyword)
	{
		// echo "<div class='list-group' style='position: relative; width: 100%; max-height: 180px; overflow: auto;'>";
		// 今日新增
		$sql = "select `stu_id`,`name`,`mobile` from `student` where (`name` like binary '%$keyword' or `mobile` like binary '%$keyword' or `name` like binary '%$keyword%' or `mobile` like binary '%$keyword%' or `name` like binary '$keyword%' or `mobile` like binary '$keyword%') and(Year(`ctime`)='".date('Y')."' and MONTH(`ctime`)='".date('m')."' and Day(`ctime`)='".date('d')."')";  
		$query = $this->db->query($sql);
		$result['today'] = $query->result_array();
		// echo "$sql";
		
		// 全部
		$sql = "select `stu_id`,`name`,`mobile` from `student` where `name` like binary '%$keyword' or `mobile` like binary '%$keyword' or `name` like binary '%$keyword%' or `mobile` like binary '%$keyword%' or `name` like binary '$keyword%' or `mobile` like binary '$keyword%' LIMIT 0,20";  
		$query = $this->db->query($sql);
		$result['all'] = $query->result_array();
		return $result;
	} 
	function add_stu_info($stu_id)
	{
		if (!is_null($stu_id)&&is_numeric($stu_id)) {
			$sql = "SELECT * from `student` where `stu_id` = '$stu_id'";
			$query = $this->db->query($sql);
			return $query->row(0);
		}else{
			return FALSE;
		}
	}


	function submitstuinfo($data){
		if (isset($data['stu_id'])) {
			if ($data['stu_id']==0) {
				$sql = "INSERT INTO `dorm`.`student` (`stu_id`, `name`, `sex`, `school`, `mobile`, `home`, `reg_address`, `mailing_address`, `email`, `id_num`, `birthday`, `emg_name`, `emg_phone`, `note`, `ctime`) VALUES (NULL, '".$data['name']."', 'NULL', '".$data['school']."', '".$data['mobile']."', '".$data['home']."', '".$data['reg_address']."', '".$data['mailing_address']."', '".$data['email']."', '".$data['id_num']."', '".$data['birthday']."', '".$data['emg_name']."', '".$data['emg_phone']."', '".$data['note']."', CURRENT_TIMESTAMP)";
				$query = $this->db->query($sql);
				return $this->db->insert_id();
			}else{
				$sql = "UPDATE `dorm`.`student` SET `name` = '".$data['name']."', `sex` = 'NULL', `school` = '".$data['school']."', `mobile` = '".$data['mobile']."', `home` = '".$data['home']."', `reg_address` = '".$data['reg_address']."',`birthday` = '".$data['birthday']."', `mailing_address` = '".$data['mailing_address']."', `email` = '".$data['email']."', `id_num` = '".$data['id_num']."', `emg_name` = '".$data['emg_name']."', `emg_phone` = '".$data['emg_phone']."', `note` = '".$data['note']."' WHERE `student`.`stu_id` = '".$data['stu_id']."'";
				$query = $this->db->query($sql);
				return $data['stu_id'];
			}
				
		}else{
			return FALSE;
		}
	}
	function checkdoubleadd($name, $id_num, $mobile){
		$sql = "SELECT COUNT(`stu_id`) as `count` FROM `student` where `name` = '$name' and (`id_num` = '$id_num' and `mobile` = '$mobile')";
		$query = $this->db->query($sql);
		if ($query->row(0)->count>0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function show_student_list($keyword, $page){
        // 頁數		
		if ($page <= 0) {
            $page = 1;
        }
        $pages = 30*$page-30;
        // from
        $this->db->from('student');
        // where
        $this->db->where('( 0',null,false)->or_like('student.name',$keyword)->or_like('student.mobile',$keyword)->or_like('student.home',$keyword)->or_like('student.emg_name',$keyword)->or_like('student.emg_phone',$keyword)->or_where('0 )',null,false);
        $this->db->order_by('student.name')->limit(30,$pages);

        $query = $this->db->get();
        return $query->result_array();
	}
	function get_stu_info($stu_id){
		$output = array();

		$sql = "SELECT * from `student` where `stu_id` = '$stu_id'";
		$query = $this->db->query($sql);

		
		if ($query->num_rows()>0) {
			$output['stu_info'] = $query->result_array();

			$sql = "SELECT `contract_id`,`c_num`, `dorm`.`name` as `dname`, `room`.`name` as `rname`, `s_date`, `e_date`, `in_date`, `out_date` ,`seal`
				from `contract`
				LEFT JOIN `room` on `room`.`room_id`=`contract`.`room_id`
            	LEFT JOIN `dorm` on `dorm`.`dorm_id`=`room`.`dorm`
				where `contract`.`stu_id` = '100' and `seal` <> 1";
			$query = $this->db->query($sql);
			$output['countc'] = $query->num_rows();
			$output['cdata'] = $query->result_array();
			$output['state'] = true;
			return $output;
			
		}else{
			$outpu['state'] = false;
			return $output;

		}
		

	}

	function edit_stu_info($stu_id, $reg_address, $mailing_address, $name, $school, $mobile, $home, $email, $id_num, $birthday, $emg_name, $emg_phone, $note){
		$sql = "UPDATE `dorm`.`student` SET `name` = '$name', `school` = '$school', `mobile` = '$mobile', `home` = '$home', `reg_address` = '$reg_address', `mailing_address` = '$mailing_address', `email` = '$email', `id_num` = '$id_num', `birthday` = '$birthday', `emg_name` = '$emg_name', `emg_phone` = '$emg_phone', `note` = '$note' WHERE `student`.`stu_id` = '$stu_id';";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

}?>