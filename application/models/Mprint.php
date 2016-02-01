

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mprint extends CI_Model
{
     function __construct()
     {
        parent::__construct();
        $this->load->helper(array('My_url_helper','url', 'My_sidebar_helper'));
        $this->load->library('session');
        $this->load->model(array('login_check', 'Mcontract', 'Mutility', 'Mfinance', 'Mstudent'));
        $this->load->library(array('GoogleCloudPrint'));
        // check login & power, and then init the header
        $required_power = 2;
        $this->login_check->check_init($required_power);
        // printer parameter

        $this->db->select('value')->where('id', 2)->or_where('id', 3)->or_where('id', 3)->or_where('id', 4)->or_where('id', 5)->from('parameter');
        $query = $this->db->get();
        $result = $query->result_array();


        $redirectConfig = array(
        'client_id'     => '',
        'redirect_uri'  => 'http://127.0.0.1/gcptest/oAuthRedirect.php',
        'response_type' => 'code',
        'scope'         => 'https://www.googleapis.com/auth/cloudprint',
        );

        $authConfig = array(
            'code' => '',
            'client_id'     => '',
            'client_secret' => '',
            'redirect_uri'  => 'http://127.0.0.1/gcptest/oAuthRedirect.php',
            "grant_type"    => "authorization_code"
        );

        $offlineAccessConfig = array(
            'access_type' => 'offline'
        );

        $refreshTokenConfig = array(

            'refresh_token' => "",
            // 'refresh_token' => "",
            'client_id' => $authConfig['client_id'],
            'client_secret' => $authConfig['client_secret'],
            'grant_type' => "refresh_token"
        );

        $urlconfig = array(
            'authorization_url'     => 'https://accounts.google.com/o/oauth2/auth',
            'accesstoken_url'       => 'https://accounts.google.com/o/oauth2/token',
            'refreshtoken_url'      => 'https://www.googleapis.com/oauth2/v3/token'
        );


        $this->gcp = new GoogleCloudPrint();
        $token = $this->gcp->getAccessTokenByRefreshToken($urlconfig['refreshtoken_url'],http_build_query($refreshTokenConfig));
        $this->gcp->setAuthToken($token);
    }
    function get_gcp_printer_list(){
        $printers = $this->gcp->getPrinters();
        return $printers;
    }
    function document_gcp_print($document, $printer_id=0){
        $printers = $this->gcp->getPrinters();
        //print_r($printers);

        $printerid = "";
        if(count($printers)==0||is_null($document)) {

            $result['status'] = -1;
        }else{
            $printerid = $printers[0]['id']; // Pass id of any printer to be used for print
            foreach ($printers as $key => $value) {
                if ($value['id']==$printer_id) {
                    $printer_id = $value['id'];
                }
            }
            // Send document to the printer
            $result = $this->gcp->sendPrintToPrinter($printerid, "AuntSys列印合約", $document, "application/pdf");

            if($result['status']==true) {

            }else {
                $result['status'] = 0;
            }
        }


        return $result;

    }

}
?>
