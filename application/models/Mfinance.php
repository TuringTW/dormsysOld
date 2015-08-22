

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mfinance extends CI_Model
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
    function rent_cal($rpm, $s_date, $e_date, $countpeo){ //rpm rent per month
        $date_result = $this->Mutility->Date_diff($s_date, $e_date);

        if ($date_result['td'] > 0) {
            // whole month
            $rent_result['mib_rent'] = $date_result['mib']*$rpm*$countpeo;
            // ROD
            $rpd = (float)$rpm/30;
            $rent_result['ROD_rent'] = round($date_result['rod']*$rpd*$countpeo);
            // total_rent
            $rent_result['total_rent'] = $rent_result['mib_rent'] + $rent_result['ROD_rent'];

            $output['rent_result'] = $rent_result;
            $output['date_result'] = $date_result;
            return $output;
        }else{
            return false;
        }
    }    

}?>