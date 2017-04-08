<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class login_check extends CI_Model
{
     function __construct()
     {
        parent::__construct();
        $this->load->database();
        $this->load->model(array('Mtools'));
     }
     //get the username & password from tbl_usrs
     function get_user($usr, $pwd)
     {
          $sql = "select `name`,`power`, `m_id` from `manager` where `user` = '" . $usr . "' and pass = '" . md5($pwd) . "' and active = 1";
          $query = $this->db->query($sql);
          return $query->row();
     }

     function check_init($required_power){
       
     	$this->load->helper('My_url_helper');
		$this->load->helper('url');
		$this->load->library('session');
		// login check
		if ($this->session->userdata('user')===false) {
			redirect('/login');
		}
		// power check
		if ($this->session->userdata('power')===false) {
			redirect('/login');
		}else{
			if ($this->session->userdata('power') > $required_power) {
				redirect('/index');
			}
		}

    }
    function get_user_id(){
    	return $this->session->userdata('m_id');
    }
    function get_user_name(){
      return $this->session->userdata('user');
    }
    function log_out($method=0){
      $this->Mtools->addlog(0, 'Logout', $this->get_user_name()." logout successfully!");
      $this->load->library('session');
      $this->session->sess_destroy();
  		if ($method==0) {
        redirect('/login');
      }
    }
}?>
