

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mstudent extends CI_Model
{
	function __construct()
	{
	  // Call the Model constructor
	$this->load->library('session');
	$this->load->model(array('login_check', 'utility'));
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

}?>