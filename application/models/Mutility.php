

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutility extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }
    function Date_diff($s_date, $e_date){
        $s_date = date('Y-m-d', strtotime('-1 day', strtotime($s_date)));
        $start = date_create($s_date);
        $end = date_create($e_date);
        $diff=date_diff($start, $end);
        $output['td'] = $diff->format("%r%a"); //total date
        $output['mib'] = $diff->format("%r%m")+$diff->format("%r%y")*12; //month in betwwen
        $output['rod'] = $diff->format("%d");
        return $output;
    }

    function get_dorm_list()
    {
    	$sql = "SELECT `name`,`dorm_id`,`location`,`note` FROM `dorm`  WHERE 1";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }
    function get_room_list($dorm_id)
    {
    	$sql = "SELECT * from `room` where `dorm` = '$dorm_id'";
    	if ($dorm_id == 0) {
    		$sql .= ' or 1';
    	}
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }
    function get_room_info($room_id){
        $sql = "SELECT `room_id`, `room`.`name` as `rname`, `rent`, `dorm`.`name` as `dname` from `room` left join `dorm` on `dorm`.`dorm_id` = `room`.`dorm` where `room_id` = '$room_id'";
        $query = $this->db->query($sql);
        return $query->row(0);
    }

    function get_user_list()
    {
        $sql = "SELECT `m_id`,`name` from `manager` where `active` = 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
?>