

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
    


}?>