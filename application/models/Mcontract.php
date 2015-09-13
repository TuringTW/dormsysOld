

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcontract extends CI_Model
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
    // 取得合約列表
    function show_contract_list($keyword, $dorm, $seal, $due, $outofdate, $page)
    {
        $this->db->select('contract.contract_id,c_num,contract.rent,contract.sales,student.name as sname,dorm.name as dname,room.name as rname,  contract.s_date,contract.in_date,contract.out_date ,  contract.e_date, COUNT(contract.contract_id) as countp, seal')->from('contract');
        $this->db->join('room','room.room_id=contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contract.stu_id','left');
        $this->db->where('( 0',NULL, false); //for logic 
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('student.name',$keyword)->or_like('mobile',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->where('seal',0);
        // 逾期
        if ($outofdate==1) {
            $ofdrule = "DATEDIFF(`e_date`,'".date('Y-m-d')."')<=0";
            $this->db->where($ofdrule);
        }
        // 即將到期
        if ($due==1) {
            $duerule = "(Month(`e_date`)=".date('m')." and Year(`e_date`)=".date('Y').")";
            $this->db->where($duerule);
        }
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
            $this->db->where($dormrule);
        }
        $this->db->group_by('c_num');
        $this->db->order_by("dorm.name", "desc"); 
        $this->db->order_by("room.name", "desc"); 
        $this->db->order_by("in_date", "desc"); 
        // 頁數
        if ($page <= 0) {
            $page = 1;
        }
        $pages = 30*$page-30;
        $this->db->limit(30,$pages);

        $query = $this->db->get();
        return $query->result_array();

    }
    // 取得單筆合約資料
    function get_contract_info($c_num){
        if (!is_nan($c_num)) {
            $sql = "SELECT  `dorm`.`name` as `dname`,
                            `dorm`.`dorm_id`,
                            `room`.`name` as `rname`,
                            `room`.`room_id`,
                            `student`.`name` as `sname`,
                            `student`.`stu_id`,
                            `contract_id`,
                            `s_date`,
                            `e_date`,
                            `in_date`,
                            `student`.`id_num`,
                            `out_date`,
                            `c_date`,
                            `contract`.`note`,
                            `contract`.`rent`,`contract`.`sales`,`manager`.`name` as `mname`,
                            `student`.`mobile`,`payed_rent`,`c_num`
                    FROM `contract`
                    LEFT JOIN `room` on `room`.`room_id` = `contract`.`room_id`
                    LEFT JOIN `dorm` on `dorm`.`dorm_id` = `room`.`dorm`
                    LEFT JOIN `student` on `student`.`stu_id` = `contract`.`stu_id`
                    LEFT JOIN `manager` on `manager`.`m_id` = `contract`.`manager`
                    where   `c_num` = '$c_num'
                            and `contract`.`seal` = 0";
            $query = $this->db->query($sql);
            return $query->result_array();
        }else{
            return false;
        }
    }
    function edit_contract($c_num, $in_date, $out_date, $sales, $note){
        $sql = "UPDATE `contract` set   `in_date` = '$in_date',
                                        `out_date` = '$out_date',
                                        `sales` = '$sales',
                                        `note` = '$note'
                                where `c_num` = '$c_num'";
        $query = $this->db->query($sql);
        // return $query->affected_rows();
        return true;
    }
    function break_contract($c_num, $b_date){
        if (!is_null($c_num)&&!is_null($b_date)) {
            $m_id = $this->session->userdata('m_id');
            $time = Date('Y-m-d h:i:s');

            $sql = "UPDATE `contract` set `e_date` = '$b_date', `note` = CONCAT(`note`,'bc at $time by $m_id,') 
                    where `c_num` = '$c_num'";
            $query = $this->db->query($sql);
            return true;
        }else{
            return false;
        }
    }
    function count_ofd_due($dorm, $keyword){
        $duerule = "(Month(`e_date`)=".date('m')." and Year(`e_date`)=".date('Y').")";
        

        $this->db->distinct()->select('c_num')->from('contract');    
        // join
        $this->db->join('room','room.room_id = contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contract.stu_id','left');
        //where 
        $this->db->where('( 0',NULL, false); //for logic 
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('student.name',$keyword)->or_like('mobile',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->where('seal',0);
        // 逾期
        $ofdrule = "DATEDIFF(`e_date`,'".date('Y-m-d')."')<=0";
        $this->db->where($ofdrule);
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
            $this->db->where($dormrule);
        }
        $this->db->group_by('c_num');
        $result['countofd'] = $this->db->count_all_results();


    // 本月到期
        $this->db->distinct()->select('c_num')->from('contract');    
        // join
        $this->db->join('room','room.room_id = contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contract.stu_id','left');
        //where 
        $this->db->where('( 0',NULL, false); //for logic 
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('student.name',$keyword)->or_like('mobile',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->where('seal',0);
        // 本月到期
        $duerule = "(Month(`e_date`)=".date('m')." and Year(`e_date`)=".date('Y').")";
        $this->db->where($duerule);
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
            $this->db->where($dormrule);
        }
        $result['countdue'] = $this->db->count_all_results();

        return $result;
    }
    function date_check_by_room($room_id, $in_date, $out_date){
        $sql = "SELECT COUNT(DISTINCT `c_num`) as `count`,`room_id` from `contract` where `seal`=0 and 
                            ((DATEDIFF(  `in_date`,'$in_date' ) >=0
                            AND DATEDIFF(   `out_date`,'$out_date' ) <=0) or 
                            (DATEDIFF(  `out_date`,'$in_date' ) >=0
                            AND DATEDIFF(   `out_date`,'$out_date' ) <=0) or 
                            (DATEDIFF(  `out_date`,'$in_date' ) >=0
                            AND DATEDIFF(   `in_date`,'$in_date' ) <=0) or 
                            (DATEDIFF(  `out_date`,'$out_date' ) >=0
                            AND DATEDIFF(   `in_date`,'$out_date' ) <=0)) group by `room_id` having `room_id` = '$room_id'" ;  
        $query = $this->db->query($sql);
        $result = $query->row(0);
        if ($result->count == 1&&strtotime($out_date)-strtotime($in_date)>0) {
            return true;
        }else{
            return false;
        }
    }
    function set_check_out($c_num){
        if (!is_null($c_num)&&is_numeric($c_num)) {
            $m_id = $this->session->userdata('m_id');
            $time = date('Y-m-d h:i:s');
            $sql = "UPDATE `contract` set `seal` = 2, note = CONCAT(`note`, 'check out at $time by $m_id,') where `c_num` = '$c_num'";
            $query = $this->db->query($sql);
            return true;
        }else{
            return false;
        }
    }

    function checknotoverlap($room_id, $start, $end){
         $sql = "SELECT  `dorm`.`name` as `dname`, `room`.`name` as `rname`, `student`.`name` as `sname`, `student`.`mobile`,  `contract`.`s_date`,`contract`.`in_date`,`contract`.`out_date` ,  `contract`.`e_date`, COUNT(`contract`.`contract_id`) as `countp`
                    from `contract` 
                    LEFT join `room` on `room`.`room_id`=`contract`.`room_id`
                    LEFT JOIN `dorm` on `dorm`.`dorm_id`=`room`.`dorm`
                    LEFT JOIN `student` on `student`.`stu_id`=`contract`.`stu_id`
                             where `contract`.`seal`=0 and `room`.`room_id`= '$room_id' and
                            ((DATEDIFF(  `contract`.`in_date`,'$start' ) >=0
                            AND DATEDIFF(   `contract`.`out_date`,'$end' ) <=0) or 
                            (DATEDIFF(  `contract`.`out_date`,'$start' ) >=0
                            AND DATEDIFF(   `contract`.`out_date`,'$end' ) <=0) or 
                            (DATEDIFF(  `contract`.`out_date`,'$start' ) >=0
                            AND DATEDIFF(   `contract`.`in_date`,'$start' ) <=0) or 
                            (DATEDIFF(  `contract`.`out_date`,'$end' ) >=0
                            AND DATEDIFF(   `contract`.`in_date`,'$end' ) <=0)) 
                    GROUP BY `c_num`" ; 
        $query = $this->db->query($sql);
        $output = array();
        if ($query->num_rows()>0) {
            $output['state'] = false;
            $output['result'] = $query->result_array();
        }else{
            $output['state'] = true;
        }

        return $output;
    }
    function add_contract($data){
        $sql = "SELECT MAX(`c_num`) as `max` from `contract` where `seal` <> 1";
        $query = $this->db->query($sql);
        $c_num = $query->row(0)->max + 1;
        $c_date = date('Y-m-d h:i:s');
        $manager = $this->login_check->get_user_id();


        $result = array();
        $result['c_num'] = $c_num;
        $result['error_id'] = array();
        $result['state'] = 1;
        for ($i=0; $i < count($data['stu_id']); $i++) { 
            $sql = "INSERT INTO  `contract` (
                `stu_id` ,
                `c_num`,
                `room_id` ,
                `s_date` ,
                `e_date` ,
                `c_date` ,
                `in_date` ,
                `out_date` ,
                `manager` ,
                `rent`,
                `sales`,
                `note`
                )VALUES (  
                '".$data['stu_id'][$i]."', 
                '".$c_num."', 
                '".$data['room_id']."',  
                '".$data['s_date']."',   
                '".$data['e_date']."',  
                '".$c_date."',  
                '".$data['in_date']."',  
                '".$data['out_date']."',  
                '".$manager."', 
                '".$data['rent']."', 
                '".$data['sales']."', 
                '".$data['note']."')";
            $this->db->query($sql);
            $countr = $this->db->affected_rows();
            if ($countr=0 ) {
                $result['state']*=0;
                array_push($result['error_id'], $data['stu_id'][$i]) ;
            }
        }
        return $result;
            
    }
    function get_print_data($c_num){
        $result = array();
        $this->db->select('dorm.name as dname, room.name as rname, student.name as sname, mobile, birthday, reg_address, mailing_address, id_num, home, emg_name, emg_phone, s_date, e_date, in_date, out_date, contract.rent, location');
        $this->db->from('contract');
        $this->db->join('room','room.room_id = contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contract.stu_id','left');
        $this->db->where('c_num=', $c_num)->where('seal<>', 1);
        $this->db->order_by('student.name')->order_by('student.mobile');
        $query = $this->db->get();
        $countpeo = $query->num_rows();
        $result['countpeo'] = $countpeo;
        $result['data'] = $query->result_array();
        $datum = $result['data'][0];
        $result['rent'] = $this->Mfinance->rent_cal($datum['rent'], $datum['s_date'], $datum['e_date'], $countpeo);
        $result['countday'] = $this->Mutility->Date_diff($datum['s_date'], $datum['e_date']);
        return $result;
    }

}?>