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
		$sql = "select `stu_id`,`name`,`mobile`, `emg_name`, `emg_phone` from `student` where (
			`name` like binary '%$keyword' or
			`emg_name` like binary '%$keyword' or
			`mobile` like binary '%$keyword' or
			`emg_phone` like binary '%$keyword' or
			`name` like binary '%$keyword%' or
			`emg_name` like binary '%$keyword%' or
			`mobile` like binary '%$keyword%' or
			`emg_phone` like binary '%$keyword%' or
			`name` like binary '$keyword%' or
			`mobile` like binary '$keyword%' or
			`emg_phone` like binary '$keyword%'
			) and(Year(`ctime`)='".date('Y')."' and MONTH(`ctime`)='".date('m')."' and Day(`ctime`)='".date('j')."')";
			// `emg_name` like binary '$keyword%' or
		$query = $this->db->query($sql);
		$result['today'] = $query->result_array();
		// echo "$sql";

		// 全部
		$sql = "select `stu_id`,`name`,`mobile`, `emg_name`, `emg_phone` from `student` where
			`name` like binary '%$keyword' or
			`emg_name` like binary '%$keyword' or
			`mobile` like binary '%$keyword' or
			`emg_phone` like binary '%$keyword' or
			`name` like binary '%$keyword%' or
			`emg_name` like binary '%$keyword%' or
			`mobile` like binary '%$keyword%' or
			`emg_phone` like binary '%$keyword%' or
			`name` like binary '$keyword%' or
			
			`mobile` like binary '$keyword%' or
			`emg_phone` like binary '$keyword%'
			 LIMIT 0,20";
			 // `emg_name` like binary '$keyword%' or
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
        $this->db->where('( 0',null,false)->or_like('student.name',$keyword)->or_like('student.mobile',$keyword)->or_like('student.home',$keyword)->or_like('student.emg_name',$keyword)->or_like('student.emg_phone',$keyword)->or_like('student.car_id',$keyword)->or_where('0 )',null,false);
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

			$sql = "SELECT `contract`.`contract_id`, `stu_id`, `dorm`.`name` as `dname`, `room`.`name` as `rname`, `s_date`, `e_date`, `in_date`, `out_date` ,`seal`
				from `contract`
				LEFT JOIN `contractpeo` on `contract`.`contract_id` = `contractpeo`.`contract_id`
				LEFT JOIN `room` on `room`.`room_id`=`contract`.`room_id`
            	LEFT JOIN `dorm` on `dorm`.`dorm_id`=`room`.`dorm`
				where `contractpeo`.`stu_id` = '$stu_id' and `seal` <> 1";
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

	function edit_stu_info($stu_id, $reg_address, $mailing_address, $name, $school, $mobile, $home, $email, $id_num, $birthday, $emg_name, $emg_phone, $note, $car_id){
		$sql = "UPDATE `dorm`.`student` SET `name` = '$name', `school` = '$school', `mobile` = '$mobile', `home` = '$home', `reg_address` = '$reg_address', `mailing_address` = '$mailing_address', `email` = '$email', `id_num` = '$id_num', `birthday` = '$birthday', `emg_name` = '$emg_name', `emg_phone` = '$emg_phone', `car_id` = '$car_id', `note` = '$note' WHERE `student`.`stu_id` = '$stu_id';";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

	function show_dorm_stu($dorm_id){
		$today = date('Y-m-d');
		$this->db->select('contractpeo.stu_id, contract.contract_id, student.name as sname, room.name as rname');
		$this->db->from('contract');
		$this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
		$this->db->join('room','room.room_id=contract.room_id','left');
        $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
        $this->db->where('room.dorm',$dorm_id);
        $this->db->where("((DATEDIFF(  `in_date`,'$today' ) <=0
                            AND DATEDIFF(   `out_date`,'$today' ) >=0))");

				$this->db->where('( 1',NULL, false); //for logic
						$this->db->where('seal=',0);
						// $this->db->or_where('( 1',NULL, false); //for logic
            //     $this->db->where('seal', 2)->where("DATEDIFF(`e_date`, '".date("Y-m-d")."')>0");
            // $this->db->or_where('0 )',NULL, false);
				$this->db->or_where('0 )',NULL, false);
        $this->db->order_by('room.name');
        $query = $this->db->get();
        return $query->result_array();

	}

	function get_stu_from_room($room_id){
		$this->db->select('contractpeo.stu_id, contract.contract_id, student.name as sname, in_date, out_date')->from('contract');
		$this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
		$this->db->join('room','room.room_id=contract.room_id','left');
        $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
		$this->db->where('contract.room_id', $room_id)->where('seal<>', 1);
		$this->db->order_by('contract.in_date', 'DESC');
		$this->db->order_by('contract.out_date', 'DESC');
		$this->db->order_by('student.name');
		$query = $this->db->get();
        return $query->result_array();
	}
	function get_stu_info_from_s_id($stu_id){

		$this->db->select('contract.contract_id, contractpeo.stu_id, dorm.name as dname, room.name as rname, student.name as sname, mobile, home, email, reg_address, mailing_address, emg_name, emg_phone, school, car_id');
		$this->db->from('contract');
		$this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
		$this->db->join('room','room.room_id=contract.room_id','left');
		$this->db->join('dorm','dorm.dorm_id=room.dorm','left');
        $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
        $this->db->where('contractpeo.stu_id', $stu_id)->where('seal<>', 1);
        $query = $this->db->get();
        return $query->result_array();

	}
	function searchname_in_c_id($keyword){
		$this->db->select('contract.contract_id, contractpeo.stu_id, student.name as sname, in_date')->from('contract');
		$this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
		$this->db->join('student','student.stu_id=contractpeo.stu_id','left');
		$this->db->where('seal<>', 1);
		$this->db->where('( 0',NULL, false); //for logic
        $this->db->or_like('student.name',$keyword)->or_like('student.emg_name',$keyword)->or_like('student.mobile',$keyword)->or_like('student.emg_phone',$keyword)->or_like('student.car_id',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->order_by('student.name')->order_by('in_date');
		$query = $this->db->get();
        return $query->result_array();
	}
	function update_from_type_form(){
		$this->load->library(array('web'));
		$key = $this->Mutility->getparameters(1);
		$today = mktime(0,0,0,Date('m'), Date('d')-3, Date('Y'));
		//change to 3 day before
		$url = "https://api.typeform.com/v0/form/tWEk2z?key=".$key."&completed=true&order_by[]=date_land,desc&since=".$today."&limit=10";
		$curl_result = json_decode($this->web->cURL($url, array(), 'get'));
		$success_add = 0;
		foreach ($curl_result->responses as $key => $value) {
			$this->db->from('student')->where('n_id', $value->token);
			$this->db->or_where('( 1',NULL, false)->where('name', $value->answers->textfield_12545150)->where('id_num', $value->answers->textfield_12545462)->where('1 )',NULL, false); //for logic ;
			$count = $this->db->count_all_results();

			if ($count==0) {
				$data = array(
					'name' => $value->answers->textfield_12545150,
					'sex' => '',
					'school' => $value->answers->textfield_12545151,
					'mobile' => $value->answers->textarea_12545543,
					'home' => $value->answers->textfield_12545648,
					'reg_address' => $value->answers->textfield_12545553,
					'mailing_address' => $value->answers->textfield_12545574,
					'email' => $value->answers->email_12545152,
					'id_num' => $value->answers->textfield_12545462,
					'birthday' => date('Y-m-d', mktime(0, 0, 0, $value->answers->number_12545429, $value->answers->number_12545433, $value->answers->number_12545423)),
					'emg_name' => $value->answers->textfield_12545584,
					'emg_phone' => $value->answers->textfield_12545601,
					'note' => '',
					'car_id' => $value->answers->textfield_24024411,
					'n_id' => $value->token,
					);
				$this->db->flush_cache();
				$this->db->insert('student', $data);
				$success_add += 1;

			}
			$this->db->flush_cache();
		}



		$result['state'] = true;
		$result['chrows'] = $success_add;
		return $result;
	}
}?>
