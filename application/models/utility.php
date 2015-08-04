

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class utility extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
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
    function get_user_list()
    {
        $sql = "SELECT `m_id`,`name` from `manager` where 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
?>