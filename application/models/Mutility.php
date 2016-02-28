

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutility extends CI_Model
{
     function __construct()
     {
        parent::__construct();
        $this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
        $this->load->library('session');
        $this->load->model(array('login_check', 'Mcontract', 'Mutility', 'Mfinance', 'Mstudent'));
        // check login & power, and then init the header
        $required_power = 2;
        $this->login_check->check_init($required_power);
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
    function get_type_list(){
        $sql = "SELECT `cate`,`cate_id` FROM `itemcate`  WHERE 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_room_info($room_id){
        $sql = "SELECT `room_id`, `room`.`name` as `rname`, `rent`, `dorm`.`name` as `dname`, `room`.`note`, `room`.`type` from `room` left join `dorm` on `dorm`.`dorm_id` = `room`.`dorm` where `room_id` = '$room_id'";
        $query = $this->db->query($sql);
        return $query->row(0);
    }
    function edit_room_info($room_name, $rent, $type, $note, $room_id, $dorm_id){
        if ($this->is_in_the_dorm($dorm_id)) {
            $data=array(    'name'=>$room_name,
                            'dorm'=>$dorm_id,
                            'rent'=>$rent,
                            'type'=>$type,
                            'note'=>$note);
            if ($room_id == 0) {
                $this->db->insert('room', $data);
            }else{
                $this->db->where('room_id', $room_id);
                $this->db->update('room', $data); 
            }
            $result['state'] = true;
        }else{
            $result['state'] = false;
            $result['dorm'] = $dorm_id;
        }
        return $result;
    }   
    function is_in_the_dorm($dorm_id){
        if ($this->db->from('dorm')->where('dorm_id', $dorm_id)->count_all_results()==1) {
            return true;
        }else{
            return false;
        }
    }
    function get_user_list()
    {
        $sql = "SELECT `m_id`,`name` from `manager` where `active` = 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function request_auth_num($auth_code, $usage){
        if (floor(log10($auth_code))==3) {
            $this->db->select('auth_id')->from('auth_record');
            $this->db->where('TIMESTAMPDIFF(MINUTE,`timestamp`,CURRENT_TIMESTAMP())<', 5)->where('auth_code', $auth_code);
            $query = $this->db->get();
            if ($query->num_rows()==0) {
                // delete ci query stream
                $this->db->flush_cache();

                $m_id = $this->login_check->get_user_id();
                $auth_num = md5(date('U').'-'.$auth_code.'-mobileapp');
                $data = array(  'auth_code'=>$auth_code, 
                                'auth_num'=>$auth_num, 
                                'usage'=>$usage, 
                                'm_id'=>$m_id);
                $this->db->insert('auth_record', $data);
                if ($this->db->affected_rows()>0) {
                    $result['state'] = true;
                    $result['auth_num'] = $auth_num;
                }else{
                    $result['state'] = false;
                }
            }else{
                $result['state'] = -1;
            }

                
        }else{
            $result['state'] = false;
            
        }
        return $result;
        
    }
    function getparameters($id){
        $this->db->select('value')->from('parameter')->where('id', $id);
        $query = $this->db->get();
        return $query->result_array()[0]['value'];
    }
   
    
}
?>