

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mtools extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model(array('login_check'));
        // check login & power, and then init the header
    }

    function addlog($status, $tag, $msg){
        // status: 0:normal 1:warning 2:error
         $data=array(       'status'=>$status,
                            'tag'=>$tag,
                            'msg'=>$msg);
        $this->db->insert('log', $data);
    }
}
?>
