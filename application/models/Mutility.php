

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutility extends CI_Model
{
     function __construct()
     {
        parent::__construct();
        $this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
        $this->load->library('session');
        $this->load->model(array('login_check', 'Mcontract', 'Mutility', 'Mfinance', 'Mstudent', 'Mservice'));
        // check login & power, and then init the header
        $required_power = 2;
        $this->login_check->check_init($required_power);
     }

    function Date_diff($s_date, $e_date){
      $str_time = strtotime('0 day', strtotime($s_date));
      $end_time = strtotime('0 day', strtotime($e_date));


      $start_month = date('Y', $str_time)*12 + date('m', $str_time);
      $end_month = date('Y', $end_time)*12 + date('m', $end_time);

      $td = 0;
      $mib = 0;
      for ($imonth=$start_month+1; $imonth < $end_month; $imonth++) {
        $mib+=1;
        $td+=strftime('%d', mktime(0,0,0,$imonth+1, 0, 0));
      }

      // count totalt days in first and last month
      $f_totaldays = strftime('%d', mktime(0,0,0,date('m', $str_time)+1, 0, date('Y', $str_time)));
      $l_totaldays = strftime('%d', mktime(0,0,0,date('m', $end_time)+1, 0, date('Y', $end_time)));
      if ($end_month == $start_month) {
        $days_in_f_month = date('d', $end_time) - date('d', $str_time) + 1;
        $days_in_l_month = 0;
      }else{
        $days_in_f_month = $f_totaldays - date('d', $str_time)+1;
        $days_in_l_month = date('d', $end_time);
      }
      // echo $days_in_f_month, $days_in_l_month;
      $rod = $days_in_f_month + $days_in_l_month;
      $td+=$rod;
      if ($rod - $f_totaldays >=0) {
        $rod -= $f_totaldays;
        $mib += 1;
      }
      if ($rod - $l_totaldays >=0) {
        $rod -= $l_totaldays;
        $mib += 1;
      }

      $output['td'] = $td; //total date
      $output['mib'] = $mib; //month in betwwen
      $output['rod'] = $rod;

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
    function send_sms($rx, $tx, $content, $note){
        $result = false;
        if(!is_null($rx)&!is_null($content)){
            $this->load->library(array('SmsGateway'));

            $email = $this->getparameters(2);//email
            $password = $this->getparameters(3);
            $deviceID = $this->getparameters(4);


            $this->sms = new SmsGateway();
            $this->sms->set_user_info($email, $password);

            $options = [];
            $receiver = explode(",",$rx);
            $rx = str_replace(" ", "", $rx);
            $receiver = preg_split("/(,|\n| )/", $rx);

            $response = $this->sms->sendMessageToManyNumbers($receiver, $content, $deviceID, $options);

            $result = $response['response']['success'];
            if ($result==true) {
                $r_data = $response['response']['result']['success'][0];
                $this->Mservice->add_sms_record($content,$rx,$note,$r_data['status'],$r_data['id']);
            }
        }
        return $result;
    }

}
?>
