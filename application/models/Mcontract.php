

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
    function show_contract_list($keyword, $dorm, $seal, $due, $outofdate, $ns, $diom, $page, $order_method=0, $order_law=0, $page_rule=0, $start_val='', $end_val='', $pne=0)
    {

        $this->db->select("contract.contract_id,contract.rent,contract.sales,student.name as sname,dorm.name as dname,room.name as rname,  contract.s_date,contract.in_date,contract.out_date ,  contract.e_date, contract.c_date, COUNT(contract.contract_id) as countp, seal, student.name as sname, mobile, p_c_id, keep, if(isnull(rentsum.totalvalue), 0, rentsum.totalvalue) as renttotal, if(isnull(paymentsum.totalvalue), 0, paymentsum.totalvalue) as paymenttotal")->from('contract');
        $this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
        $this->db->join('room','room.room_id=contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
        $this->db->join('(SELECT sum(value) AS totalvalue, contract_id
                          FROM  `payment`
                          WHERE 1
                          GROUP BY  `contract_id`
                          ) AS paymentsum','paymentsum.contract_id=contract.contract_id','left');
        $this->db->join('(SELECT if(isnull(SUM( value*if(pm=1, 1, -1) )), 0, SUM( value*if(pm=1, 1, -1) )) AS totalvalue, contract_id
                          FROM  `rent`
                          WHERE 1
                          GROUP BY  `contract_id`
                          ) AS rentsum','rentsum.contract_id=contract.contract_id','left');

        $this->db->where('( 0',NULL, false); //for logic
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('student.name',$keyword)->or_like('mobile',$keyword)->or_like('student.emg_name',$keyword)->or_like('student.emg_phone',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->where('( 0',NULL, false); //for logic
            $this->db->or_where('seal', 0);
            // $this->db->or_where('( 0',NULL, false); //for logic
            //     $this->db->or_where('seal', 2)->where("DATEDIFF(`e_date`, '".date("Y-m-d")."')>0");
            // $this->db->or_where('0 )',NULL, false);
        $this->db->or_where('0 )',NULL, false);

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
        //尚未咖使
        if ($ns==1) {
            $nsrule = "(DATEDIFF(`s_date`, '".date("Y-m-d")."')>0)";
            $this->db->where($nsrule);
        }
        //一個月內遷出

        if ($diom==1) {
            $diomrule = "(DATEDIFF(`out_date`, '".date("Y-m-d")."')<30 and DATEDIFF(`out_date`, '".date("Y-m-d")."')>=0)";
            $this->db->where($diomrule);
        }
        // 顯示租金不足合約
        if ($pne==1) {
          $today = date('Y-m-d');
          $pnerule = "(DATEDIFF(DATE_ADD(DATE_ADD(`s_date`, INTERVAL ((if(isnull(`paymentsum`.`totalvalue`), 0, `paymentsum`.`totalvalue`) MOD (`contract`.`rent`+1E-10)) DIV (`contract`.`rent` DIV 30)) DAY), INTERVAL (if(isnull(`paymentsum`.`totalvalue`), 0, `paymentsum`.`totalvalue`) DIV (`contract`.`rent`+1E-10)) MONTH), '$today')<=30)";
          $this->db->where($pnerule);
        }

        //開始結束日期限制
        if ($start_val) {
          //
          // 沒有作日期檢查！！！
          //
          $strrule = "(DATEDIFF(`s_date`, '".$start_val."')>=0)"; //前剪後
          $this->db->where($strrule);

        }
        if ($end_val) {
          $endrule = "(DATEDIFF(`e_date`, '".$end_val."')<=0)"; //前剪後
          $this->db->where($endrule);

        }
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
            $this->db->where($dormrule);
        }
        $this->db->group_by('contract.contract_id');
        // 排序規則
        $order_rule="desc";
        if ($order_law==1) {
            $order_rule="asc";
        }
        switch ($order_method) {
            case 1:
                $this->db->order_by("BINARY `student`.`name`", $order_rule, false);
                break;
            case 2:
                $this->db->order_by("BINARY `dorm`.`name`", $order_rule, false);
                $this->db->order_by("BINARY `room`.`name`", "asc", false);
                $this->db->order_by("in_date", "desc");
                break;
            case 3:
                $this->db->order_by("BINARY `dorm`.`name`", $order_rule, false);
                $this->db->order_by("BINARY `room`.`name`", $order_rule, false);
                $this->db->order_by("in_date", "desc");
                break;
            case 4:
                $this->db->order_by("s_date", $order_rule);
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                $this->db->order_by("in_date", "desc");
                break;
            case 5:
                $this->db->order_by("e_date", $order_rule);
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                $this->db->order_by("in_date", "desc");
                break;
            case 6:
                $this->db->order_by("in_date", $order_rule);
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                $this->db->order_by("in_date", "desc");
                break;
            case 7:
                $this->db->order_by("out_date", $order_rule);
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                $this->db->order_by("in_date", "desc");
                break;
            case 8:
                $this->db->order_by("c_date", $order_rule);
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                $this->db->order_by("in_date", "desc");
                break;
            case 9:
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                $this->db->order_by("in_date", "desc");
                break;
            case 10:
                $this->db->order_by("out_date");
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                break;
            case 11:
                $this->db->order_by("e_date");
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                break;

            default:
                $this->db->order_by("dorm.name", "desc");
                $this->db->order_by("room.name", "desc");
                $this->db->order_by("in_date", "desc");
                break;
        }


        // 頁數
        if ($page_rule == 0) {
            if ($page <= 0) {
                $page = 1;
            }
            $pages = 30*$page-30;
            $this->db->limit(30,$pages);
        }



        $query = $this->db->get();
        return $query->result_array();

    }
    // 取得單筆合約資料
    function get_contract_info($contract_id){
        if (!is_nan($contract_id)) {
            $this->db->select('dorm.name as dname, dorm.dorm_id, room.name as rname, room.room_id, student.name as sname, student.stu_id, contract.contract_id, s_date, e_date, in_date, out_date, student.id_num, c_date, contract.note, contract.rent, contract.sales, manager.name as mname, student.mobile');
            $this->db->from('contract');
            $this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
            $this->db->join('room','room.room_id=contract.room_id','left');
            $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
            $this->db->join('manager','manager.m_id=contract.manager','left');
            $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
            $this->db->where('contract.contract_id', $contract_id)->where('seal<>', 1);

            $query = $this->db->get();
            return $query->result_array();
        }else{
            return false;
        }
    }
    function edit_contract($contract_id, $in_date, $out_date, $sales, $note){
        $sql = "UPDATE `contract` set   `in_date` = '$in_date',
                                        `out_date` = '$out_date',
                                        `sales` = '$sales',
                                        `note` = '$note'
                                where `contract_id` = '$contract_id'";
        $query = $this->db->query($sql);
        // return $query->affected_rows();
        return true;
    }
    function break_contract($contract_id, $b_date){
        if (!is_null($contract_id)&&!is_null($b_date)) {
            $m_id = $this->session->userdata('m_id');
            $time = Date('Y-m-d h:i:s');

            $sql = "UPDATE `contract` set `e_date` = '$b_date', `out_date`= '$b_date', `note` = CONCAT(`note`,'bc at $time by $m_id,')
                    where `contract_id` = '$contract_id'";
            $query = $this->db->query($sql);
            return true;
        }else{
            return false;
        }
    }
    function count_ofd_due($dorm, $keyword, $start_val='', $end_val=''){
        $duerule = "(Month(`e_date`)=".date('m')." and Year(`e_date`)=".date('Y').")";
        $this->db->distinct()->select(' contract.contract_id')->from('contract');
        // join
        $this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
        $this->db->join('room','room.room_id = contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
        //where
        $this->db->where('( 0',NULL, false); //for logic
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('student.name',$keyword)->or_like('mobile',$keyword)->or_like('student.emg_name',$keyword)->or_like('student.emg_phone',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->where('( 0',NULL, false); //for logic
            $this->db->or_where('seal', 0);
            // $this->db->or_where('( 0',NULL, false); //for logic
            //     $this->db->or_where('seal', 2)->where("DATEDIFF(`e_date`, '".date("Y-m-d")."')>0");
            // $this->db->or_where('0 )',NULL, false);
        $this->db->or_where('0 )',NULL, false);
        // 逾期
        $ofdrule = "DATEDIFF(`e_date`,'".date('Y-m-d')."')<=0";
        $this->db->where($ofdrule);
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
            $this->db->where($dormrule);
        }
        //開始結束日期限制
        if ($start_val) {
          //
          // 沒有作日期檢查！！！
          //
          $strrule = "(DATEDIFF(`s_date`, '".$start_val."')>=0)"; //前剪後
          $this->db->where($strrule);

        }
        if ($end_val) {
          $endrule = "(DATEDIFF(`e_date`, '".$end_val."')<=0)"; //前剪後
          $this->db->where($endrule);

        }
        $result['countofd'] = $this->db->count_all_results();


    // 本月到期
        $this->db->flush_cache();
        $this->db->distinct()->select('contract.contract_id')->from('contract');
        // join
        $this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
        $this->db->join('room','room.room_id = contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
        //where
        $this->db->where('( 0',NULL, false); //for logic
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('student.name',$keyword)->or_like('mobile',$keyword)->or_like('student.emg_name',$keyword)->or_like('student.emg_phone',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->where('( 0',NULL, false); //for logic
            $this->db->or_where('seal', 0);
            // $this->db->or_where('( 0',NULL, false); //for logic
            //     $this->db->or_where('seal', 2)->where("DATEDIFF(`e_date`, '".date("Y-m-d")."')>0");
            // $this->db->or_where('0 )',NULL, false);
        $this->db->or_where('0 )',NULL, false);
        // 本月到期
        $duerule = "(Month(`e_date`)=".date('m')." and Year(`e_date`)=".date('Y').")";
        $this->db->where($duerule);
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
            $this->db->where($dormrule);
        }
        //開始結束日期限制
        if ($start_val) {
          //
          // 沒有作日期檢查！！！
          //
          $strrule = "(DATEDIFF(`s_date`, '".$start_val."')>=0)"; //前剪後
          $this->db->where($strrule);

        }
        if ($end_val) {
          $endrule = "(DATEDIFF(`e_date`, '".$end_val."')<=0)"; //前剪後
          $this->db->where($endrule);

        }
        $result['countdue'] = $this->db->count_all_results();
    //一個月內到期
        $this->db->flush_cache();
        $this->db->distinct()->select('contract.contract_id')->from('contract');
        // join
        $this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
        $this->db->join('room','room.room_id = contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
        //where
        $this->db->where('( 0',NULL, false); //for logic
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('student.name',$keyword)->or_like('mobile',$keyword)->or_like('student.emg_name',$keyword)->or_like('student.emg_phone',$keyword);
        $this->db->or_where('0 )',NULL, false);

        $this->db->where('( 0',NULL, false); //for logic
            $this->db->or_where('seal', 0);
            // $this->db->or_where('( 0',NULL, false); //for logic
            //     $this->db->or_where('seal', 2)->where("DATEDIFF(`e_date`, '".date("Y-m-d")."')>0");
            // $this->db->or_where('0 )',NULL, false);
        $this->db->or_where('0 )',NULL, false);

        // 本月到期
        $duerule = "(DATEDIFF(`out_date`, '".date("Y-m-d")."')<30 and DATEDIFF(`out_date`, '".date("Y-m-d")."')>=0)";
        $this->db->where($duerule);
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
            $this->db->where($dormrule);
        }
        //開始結束日期限制
        if ($start_val) {
          //
          // 沒有作日期檢查！！！
          //
          $strrule = "(DATEDIFF(`s_date`, '".$start_val."')>=0)"; //前剪後
          $this->db->where($strrule);

        }
        if ($end_val) {
          $endrule = "(DATEDIFF(`e_date`, '".$end_val."')<=0)"; //前剪後
          $this->db->where($endrule);

        }
        $result['countdue_in_1_m'] = $this->db->count_all_results();
    //count not start
        $this->db->flush_cache();
        $this->db->distinct()->select('contract.contract_id')->from('contract');
        // join
        $this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
        $this->db->join('room','room.room_id = contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
        //where
        $this->db->where('( 0',NULL, false); //for logic
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('student.name',$keyword)->or_like('mobile',$keyword)->or_like('student.emg_name',$keyword)->or_like('student.emg_phone',$keyword);
        $this->db->or_where('0 )',NULL, false);

        $this->db->where('( 0',NULL, false); //for logic
            $this->db->or_where('seal', 0);
            // $this->db->or_where('( 0',NULL, false); //for logic
            //     $this->db->or_where('seal', 2)->where("DATEDIFF(`e_date`, '".date("Y-m-d")."')>0");
            // $this->db->or_where('0 )',NULL, false);
        $this->db->or_where('0 )',NULL, false);

        $duerule = "(DATEDIFF(`s_date`, '".date("Y-m-d")."')>0)";
        $this->db->where($duerule);

        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
            $this->db->where($dormrule);
        }
        //開始結束日期限制
        if ($start_val) {
          //
          // 沒有作日期檢查！！！
          //
          $strrule = "(DATEDIFF(`s_date`, '".$start_val."')>=0)"; //前剪後
          $this->db->where($strrule);

        }
        if ($end_val) {
          $endrule = "(DATEDIFF(`e_date`, '".$end_val."')<=0)"; //前剪後
          $this->db->where($endrule);

        }
        $result['count_ns'] = $this->db->count_all_results();

    //count payment not enough
        $this->db->flush_cache();
        $this->db->distinct()->select('contract.contract_id')->from('contract');
        // join
        $this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
        $this->db->join('room','room.room_id = contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
        $this->db->join('(SELECT sum(value) AS totalvalue, contract_id
                          FROM  `payment`
                          WHERE 1
                          GROUP BY  `contract_id`
                          ) AS paymentsum','paymentsum.contract_id=contract.contract_id','left');
        $this->db->join('(SELECT if(isnull(SUM( value*if(pm=1, 1, -1) )), 0, SUM( value*if(pm=1, 1, -1) )) AS totalvalue, contract_id
                          FROM  `rent`
                          WHERE 1
                          GROUP BY  `contract_id`
                          ) AS rentsum','rentsum.contract_id=contract.contract_id','left');

        //where
        $this->db->where('( 0',NULL, false); //for logic
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('student.name',$keyword)->or_like('mobile',$keyword)->or_like('student.emg_name',$keyword)->or_like('student.emg_phone',$keyword);
        $this->db->or_where('0 )',NULL, false);

        $this->db->where('( 0',NULL, false); //for logic
            $this->db->or_where('seal', 0);
            // $this->db->or_where('( 0',NULL, false); //for logic
            //     $this->db->or_where('seal', 2)->where("DATEDIFF(`e_date`, '".date("Y-m-d")."')>0");
            // $this->db->or_where('0 )',NULL, false);
        $this->db->or_where('0 )',NULL, false);

        $today = date('Y-m-d');
        $pnerule = "(DATEDIFF(DATE_ADD(DATE_ADD(`s_date`, INTERVAL ((if(isnull(`paymentsum`.`totalvalue`), 0, `paymentsum`.`totalvalue`) MOD (`contract`.`rent`+1E-10)) DIV (`contract`.`rent` DIV 30)) DAY), INTERVAL (if(isnull(`paymentsum`.`totalvalue`), 0, `paymentsum`.`totalvalue`) DIV (`contract`.`rent`+1E-10)) MONTH), '$today')<=30)";
        $this->db->where($pnerule);


        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
            $this->db->where($dormrule);
        }
        //開始結束日期限制
        if ($start_val) {
          //
          // 沒有作日期檢查！！！
          //
          $strrule = "(DATEDIFF(`s_date`, '".$start_val."')>=0)"; //前剪後
          $this->db->where($strrule);

        }
        if ($end_val) {
          $endrule = "(DATEDIFF(`e_date`, '".$end_val."')<=0)"; //前剪後
          $this->db->where($endrule);

        }
        $result['count_pne'] = $this->db->count_all_results();


        return $result;
    }
// 這個不太好
    function date_check_by_room($room_id, $in_date, $out_date, $contract_id, $r_id){
        $sql = "Select contract_id, room_id, 'con' as `tag` from contract
                where ((DATEDIFF('$in_date', in_date)>=0 and DATEDIFF(out_date, '$in_date')>=0 )
                    or    (DATEDIFF('$in_date', in_date)<=0 and DATEDIFF(out_date, '$out_date')<=0)
                    or    (DATEDIFF('$out_date', in_date)>=0 and DATEDIFF(out_date, '$out_date')>=0) )
                    and seal<>1
                    and contract.room_id = '$room_id'

                UNION
                Select id, room_id, 'res' as `tag` from reservation
                        where ((DATEDIFF('$in_date', s_date)>=0 and DATEDIFF(e_date, '$in_date')>=0 )
                            or    (DATEDIFF('$in_date', s_date)<=0 and DATEDIFF(e_date, '$out_date')<=0)
                            or    (DATEDIFF('$out_date', s_date)>=0 and DATEDIFF(e_date, '$out_date')>=0) )
                            and seal=0
                            and (DATEDIFF(`d_date`, '".(date('Y-m-d'))."')>=-5 or is_deposit=1)
                            and reservation.room_id = '$room_id'";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        if (($query->num_rows() == 0||($contract_id&&$query->num_rows()==1&&$result[0]['contract_id']==$contract_id)||($r_id&&$query->num_rows()==1&&$result[0]['contract_id']==$r_id))&&(strtotime($out_date)-strtotime($in_date)>0)) {
            return true;
        }else{
            return false;
        }
    }
    function set_check_out($contract_id){
        if (!is_null($contract_id)&&is_numeric($contract_id)) {
            $m_id = $this->session->userdata('m_id');
            $time = date('Y-m-d h:i:s');
            $sql = "UPDATE `contract` set `seal` = 2, note = CONCAT(`note`, 'check out at $time by $m_id,') where `contract_id` = '$contract_id'";
            $query = $this->db->query($sql);
            return true;
        }else{
            return false;
        }
    }
    function set_keep($contract_id){
        if (!is_null($contract_id)&&is_numeric($contract_id)) {
            $m_id = $this->session->userdata('m_id');
            $time = date('Y-m-d h:i:s');
            $sql = "UPDATE `contract` set `keep` = 2, note = CONCAT(`note`, 'keep at $time by $m_id,') where `contract_id` = '$contract_id'";
            $query = $this->db->query($sql);
            return true;
        }else{
            return false;
        }
    }
    function checknotoverlap($room_id, $start, $end){
         $sql = "SELECT  `dorm`.`name` as `dname`, `room`.`name` as `rname`, `student`.`name` as `sname`, `student`.`mobile`,  `contract`.`s_date`,`contract`.`in_date`,`contract`.`out_date` ,  `contract`.`e_date`, COUNT(`contractpeo`.`stu_id`) as `countp`, 'con' as `source`
                    from `contract`
                    LEFT JOIN `contractpeo` on `contract`.`contract_id` = `contractpeo`.`contract_id`
                    LEFT join `room` on `room`.`room_id`=`contract`.`room_id`
                    LEFT JOIN `dorm` on `dorm`.`dorm_id`=`room`.`dorm`
                    LEFT JOIN `student` on `student`.`stu_id`=`contractpeo`.`stu_id`
                             where `contract`.`seal`=0 and `room`.`room_id`= '$room_id' and
                            ((DATEDIFF(  `contract`.`in_date`,'$start' ) >=0
                            AND DATEDIFF(   `contract`.`out_date`,'$end' ) <=0) or
                            (DATEDIFF(  `contract`.`out_date`,'$start' ) >=0
                            AND DATEDIFF(   `contract`.`out_date`,'$end' ) <=0) or
                            (DATEDIFF(  `contract`.`out_date`,'$start' ) >=0
                            AND DATEDIFF(   `contract`.`in_date`,'$start' ) <=0) or
                            (DATEDIFF(  `contract`.`out_date`,'$end' ) >=0
                            AND DATEDIFF(   `contract`.`in_date`,'$end' ) <=0))
                    GROUP BY `contractpeo`.`stu_id`
                    UNION
                    SELECT `dorm`.`name` as `dname`, `room`.`name` as `rname`, `sname`, `mobile`,  `s_date`, `e_date`,`s_date` as `in_date`, `e_date` as `out_date`, \"1\" as `countp`, 'res' as `source`
                    from `reservation`
                    LEFT join `room` on `room`.`room_id`=`reservation`.`room_id`
                    LEFT JOIN `dorm` on `dorm`.`dorm_id`=`room`.`dorm`
                              where `reservation`.`seal`=0 and `room`.`room_id`= '$room_id' and
                             ((DATEDIFF(  `reservation`.`s_date`,'$start' ) >=0
                             AND DATEDIFF(   `reservation`.`e_date`,'$end' ) <=0) or
                             (DATEDIFF(  `reservation`.`e_date`,'$start' ) >=0
                             AND DATEDIFF(   `reservation`.`e_date`,'$end' ) <=0) or
                             (DATEDIFF(  `reservation`.`e_date`,'$start' ) >=0
                             AND DATEDIFF(   `reservation`.`s_date`,'$start' ) <=0) or
                             (DATEDIFF(  `reservation`.`e_date`,'$end' ) >=0
                             AND DATEDIFF(   `reservation`.`s_date`,'$end' ) <=0))
                    GROUP BY d_date";

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
        $c_date = date('Y-m-d h:i:s');
        $manager = $this->login_check->get_user_id();


        $result = array();
        $result['error_id'] = array();
        $result['state'] = 1;
        $insertdata = array(    'room_id'=>$data['room_id'],
                                's_date'=>$data['s_date'],
                                'e_date'=>$data['e_date'],
                                'c_date'=>$c_date,
                                'in_date'=>$data['in_date'],
                                'out_date'=>$data['out_date'],
                                'manager'=>$manager,
                                'rent'=>$data['rent'],
                                'sales'=>$data['sales'],
                                'note'=>$data['note'],
                                'p_c_id'=>$data['prev_contract_id']);
        $this->db->insert('contract', $insertdata);
        $contract_id = $this->db->insert_id();
        if ($this->db->affected_rows()>0) {
            $insertdata = array();
            for ($i=0; $i < count($data['stu_id']); $i++) {
                $insertdatum = array('contract_id'=> $contract_id, 'stu_id'=>$data['stu_id'][$i]);
                array_push($insertdata, $insertdatum);
            }

            $this->db->insert_batch('contractpeo', $insertdata);

            if ( $this->db->affected_rows()>0) {
                $rent = $this->Mfinance->rent_cal($data['rent'], $data['s_date'], $data['e_date'], count($data['stu_id']));
                $output = $this->Mfinance->add_rent_record(1, $rent['rent_result']['total_rent'], date('Y-m-d'), '房屋/房間租金總額', $contract_id);
                $result['state'] = $output['state'];
                $result['contract_id'] = $contract_id;

            }else{
                $result['state'] = -1;
            }
        }else{
            $result['state'] = 0;
        }

        return $result;


    }
    function get_print_data($contract_id){
        $result = array();
        $this->db->select('dorm.name as dname, room.name as rname, student.name as sname, mobile, birthday, reg_address, mailing_address, id_num, home, emg_name, emg_phone, s_date, e_date, in_date, out_date, contract.rent, location');
        $this->db->from('contract');
        $this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
        $this->db->join('room','room.room_id = contract.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->join('student','student.stu_id=contractpeo.stu_id','left');
        $this->db->where('contract.contract_id=', $contract_id)->where('seal<>', 1);
        $this->db->order_by('student.name')->order_by('student.mobile');
        $query = $this->db->get();
        $countpeo = $query->num_rows();
        $result['countpeo'] = $countpeo;
        $result['data'] = $query->result_array();
        $datum = $result['data'][0];
        $result['rent'] = $this->Mfinance->rent_cal($datum['rent'], $datum['s_date'], $datum['e_date'], $countpeo);
        $result['countday'] = $this->Mutility->Date_diff($datum['s_date'], $datum['e_date']);

        $this->db->flush_cache();
        $this->db->select('*')->from('rent')->where('contract_id', $contract_id);
        $query = $this->db->get();
        $result['rent_list'] = $query->result_array();
        return $result;
    }
    function get_keep_info($contract_id){

        $this->db->select('contract.contract_id, contract.room_id, dorm as dorm_id, e_date, out_date, stu_id, room.rent')->from('contract');
        $this->db->join('contractpeo','contractpeo.contract_id=contract.contract_id','left');
        $this->db->join('room','room.room_id = contract.room_id','left');
        $this->db->where('contract.contract_id=', $contract_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function show_avail_room($dorm_id, $str_date, $end_date, $lprice, $hprice, $type){
        if (is_null($str_date)||empty($str_date)) {
            $str_date = date('Y-m-d');
        }
        if (is_null($end_date)||empty($end_date)) {
            $end_date = (new DateTime($str_date))-> modify('+1 day') -> format('Y-m-d');
        }
        $this->db->select("contract_id, room_id, (DATEDIFF('$str_date',out_date )) as premin, out_date, 'con' as ctype");
        $this->db->from('contract');
        $this->db->where("DATEDIFF('$str_date',in_date )>",'0')->where("DATEDIFF('$str_date',out_date )>", '0')->where('seal<>', '1');

        $sql_con = $this->db->get_compiled_select();

        $this->db->select("id, room_id, (DATEDIFF('$str_date',e_date )) as premin, e_date, 'res' as ctype");
        $this->db->from('reservation');
        $this->db->where("DATEDIFF('$str_date',s_date )>",'0')->where("DATEDIFF('$str_date',e_date )>", '0')->where('seal<>', '1');
        $this->db->order_by('premin');
        $sql_res = $this->db->get_compiled_select();

        $sql_precon = "(select temp.* from (".$sql_con." UNION ".$sql_res.") as temp group by `room_id`) as precontract";
// ========================


        $this->db->select("contract_id, room_id, (DATEDIFF(in_date, '$end_date')) as postmin, in_date, 'con' as ctype");
        $this->db->from('contract');
        $this->db->where("datediff(in_date, '$end_date')>",'0')->where("datediff(out_date, '$end_date')>", '0')->where('seal<>', '1');

        $sql_con = $this->db->get_compiled_select();

        $this->db->select("id, room_id, (DATEDIFF(s_date, '$end_date')) as postmin, s_date, 'res' as ctype");
        $this->db->from('reservation');
        $this->db->where("datediff(s_date, '$end_date')>",'0')->where("datediff(e_date, '$end_date')>", '0')->where('seal<>', '1');
        $this->db->order_by('postmin');
        $sql_res = $this->db->get_compiled_select();
        $sql_postcon = "(select temp1.* from (".$sql_con." UNION ".$sql_res.") as temp1 group by `room_id`) as postcontract";
// ===================
        $this->db->select('count(contract_id) as countc, room_id')->from('contract');
        $this->db->where("((DATEDIFF('$str_date', in_date)>=0 and DATEDIFF(out_date, '$str_date')>=0 )
                    or    (DATEDIFF('$str_date', in_date)<=0 and DATEDIFF(out_date, '$end_date')<=0)
                    or    (DATEDIFF('$str_date', in_date)>=0 and DATEDIFF(out_date, '$end_date')>=0)
                    or    (DATEDIFF('$end_date', in_date)>=0 and DATEDIFF(out_date, '$end_date')>=0)) ");
        $this->db->where('seal<>',0)->where('seal<>', -1);
        $this->db->group_by('room_id');

        $sql_conch = "(".$this->db->get_compiled_select().") as contractcheck";

        $this->db->select('dorm.name as dname, room.name as rname, room.type, if(isnull(precontract.contract_id), "",precontract.contract_id) as pre_id, if(isnull(precontract.out_date), "",precontract.out_date) as out_date, if(isnull(postcontract.ctype), "", postcontract.ctype) as post_ctype, if(isnull(precontract.ctype), "", precontract.ctype) as pre_ctype, if(isnull(postcontract.contract_id), "", postcontract.contract_id)  as post_id, if(isnull(postcontract.in_date),"",postcontract.in_date) as in_date, room.rent, room.room_id, if(isnull(postcontract.postmin), 4000, postcontract.postmin) as postmin, if(isnull(precontract.premin), 4000, precontract.premin) as premin, if(isnull(postcontract.postmin), 0, postcontract.postmin)+if(isnull(precontract.premin), 4000, precontract.premin) as prepost');
        $this->db->from('room');
        // join
        $this->db->join('dorm', 'dorm.dorm_id = room.dorm', 'left');
        $this->db->join("$sql_precon", 'precontract.room_id = room.room_id', 'left');

        $this->db->join("$sql_postcon", 'postcontract.room_id = room.room_id', 'left');
        $this->db->join("$sql_conch", 'contractcheck.room_id = room.room_id', 'left');
        $this->db->where('isnull(`contractcheck`.`countc`)', 1);





        if ($type<>0) {
            $this->db->where('room.type', $type);
        }
        if ($dorm_id<>0) {
            $this->db->where('dorm.dorm_id=', $dorm_id);
        }
        $this->db->where('rent>=', $lprice)->where('rent<=', $hprice);
        $this->db->where('active=', 1);
        // $this->db->order_by('postmin');
        // $this->db->order_by('premin');
        $this->db->order_by('prepost');


        $this->db->order_by('dorm.name', 'desc');
        $this->db->order_by('room.name', 'desc');
        $this->db->limit(200, 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function pdf_gen($contract_id, $method){
        $this->load->library(array('pdf'));

        if (!is_null($contract_id)&&is_numeric($contract_id)) {
            $data = $this->Mcontract->get_print_data($contract_id);

            $this->pdf->SetAuthor('AunttsaiDormSYS');
            $this->pdf->SetTitle('蔡阿姨宿舍租賃合約');
            $this->pdf->SetSubject('蔡阿姨宿舍租賃合約');
            $this->pdf->SetKeywords('租賃,合約');
            $this->pdf->SetHeaderMargin(0);
            $this->pdf->SetTopMargin(5);
            $this->pdf->setFooterMargin(0);
            $this->pdf->SetAutoPageBreak(true);
            $this->pdf->SetDisplayMode('real', 'default');




            $pw = $this->pdf->getPageWidth()*2.5;
            $data['wu'] = $pw;
            $data['barcodetext'] = date('Y-m-d').'-'.$contract_id;
            // add a page

            $this->pdf->AddPage();
            $this->pdf->SetFont('msungstdlight', '', 20);
            $this->pdf->Cell(190, 16,'蔡阿姨宿舍租賃合約', 0, false,0 , 0, '', 0, false, 'J', 'B');
            $this->pdf->SetFont('msungstdlight', '', 12);
            $this->pdf->load_view('contract/pdf/index', $data);
            $this->pdf->SetY(-15);

  	        $this->pdf->SetFont('msungstdlight', '', 12);
  	        $this->pdf->Cell(0, 10, '甲方：                                                                             乙方：', 0, false, 'x-align', 0, 0, 0, false, 'J', 'M');
            ob_end_clean();
            if ($method == 0) {
                //client side
                $this->pdf->Output('My-File-Name.pdf', 'I');
                return 0;
            }else if($method == 1){
                //server side
                $root = $_SERVER['SCRIPT_FILENAME'];
                $root = mb_substr($root,0,strpos($root,'index.php'));

                $this->pdf->Output($root.'/contract_pdf/contract_'.$contract_id.'.pdf', 'F');
                $path = $root.'/contract_pdf/contract_'.$contract_id.'.pdf';
                return $path;
            }

        }else{
            return false;
        }
    }
    function delete_contract($contract_id){
        $data = array('seal'=> 1);
        $this->db->where("contract_id", $contract_id);
        $this->db->update("contract", $data);
        return TRUE;
    }
    function show_handover_list($keyword, $dorm = 0, $start_val, $end_val){
      $result = array();
      $result['status'] = False;
      if (empty($start_val) ||empty( $end_val) ) {
        $result['status'] = False;
      }else{
          // $query = $this->db->query("SELECT `contract`.`contract_id`, count(`contract`.`contract_id`) as `count`, student.name as sname, `in_date`, `out_date`, `room_id`, if(`out_date`=\"2016-06-30\", \"out\", \"in\") as `inout`, `clean`, `out_text` from `contract` left join `contractpeo` on `contractpeo`.`contract_id` = `contract`.`contract_id` left join `student` on `contractpeo`.`stu_id` = `student`.`stu_id` where `seal`=0 and `out_date`=\"2016-06-30\" or `in_date`=\"2016-06-30\" group by `contract`.`contract_id`");
          // $query = $this->db->query("select dorm.name as dname, room.name as rname, Jun302016o.contract_id, Jun302016o.sname, Jun302016o.count, Jun302016o.inout, Jun302016o.clean, Jun302016o.out_text,Jul012016i.contract_id, Jul012016i.sname, Jul012016i.count, Jul012016i.inout, Jul012016i.clean, Jul012016i.out_text,Jun282016i.contract_id, Jun282016i.sname, Jun282016i.count, Jun282016i.inout, Jun282016i.clean, Jun282016i.out_text from room LEFT JOIN dorm on dorm.dorm_id = room.dorm LEFT JOIN ( SELECT `contract`.`contract_id`, count(`contract`.`contract_id`) as `count`, student.name as sname, `in_date`, `out_date`, `room_id`, if(`out_date`=\"2016-06-30\", \"out\", \"in\") as `inout`, `clean`, `out_text` from `contract` left join `contractpeo` on `contractpeo`.`contract_id` = `contract`.`contract_id` left join `student` on `contractpeo`.`stu_id` = `student`.`stu_id` where `seal`=0 and `out_date`=\"2016-06-30\" or `in_date`=\"2016-06-30\" group by `contract`.`contract_id` ) as `Jun302016o` on `Jun302016o`.`room_id` = `room`.`room_id` LEFT JOIN ( SELECT `contract`.`contract_id`, count(`contract`.`contract_id`) as `count`, student.name as sname, `in_date`, `out_date`, `room_id`, if(`out_date`=\"2016-07-01\", \"out\", \"in\") as `inout`, `clean`, `out_text` from `contract` left join `contractpeo` on `contractpeo`.`contract_id` = `contract`.`contract_id` left join `student` on `contractpeo`.`stu_id` = `student`.`stu_id` where `seal`=0 and `out_date`=\"2016-07-01\" or `in_date`=\"2016-07-01\" group by `contract`.`contract_id` ) as `Jul012016i` on `Jul012016i`.`room_id` = `room`.`room_id` LEFT JOIN ( SELECT `contract`.`contract_id`, count(`contract`.`contract_id`) as `count`, student.name as sname, `in_date`, `out_date`, `room_id`, if(`out_date`=\"2016-06-28\", \"out\", \"in\") as `inout`, `clean`, `out_text` from `contract` left join `contractpeo` on `contractpeo`.`contract_id` = `contract`.`contract_id` left join `student` on `contractpeo`.`stu_id` = `student`.`stu_id` where `seal`=0 and `out_date`=\"2016-06-28\" or `in_date`=\"2016-06-28\" group by `contract`.`contract_id` ) as `Jun282016i` on `Jun282016i`.`room_id` = `room`.`room_id` where dorm.active = 1 and isnull(Jun302016o.contract_id)+isnull(Jul012016i.contract_id)+isnull(Jun282016i.contract_id)<3 order by `dorm`.`name`, `room`.`name` limit 0, 30");
          // ");
          $link = $this->Mutility->connectDB();
          $query = mysqli_query($link,"call `handover`('$start_val', '$end_val', '$dorm')");

          $viewresult = array();
          if ($query) {
              while ($row = mysqli_fetch_array($query,MYSQLI_NUM)) {
                  array_push($viewresult, $row);
              }
              $result['status'] = True;
          }
          $result['data'] = $viewresult;

          $link = $this->Mutility->connectDB();
          $query1 = mysqli_query($link,"call `getdate`('$start_val', '$end_val', '$dorm')");

          $asdresult = array();
          if ($query1) {
              while ($row = mysqli_fetch_assoc($query1)) {
                  array_push($asdresult, $row['odate']);
              }
              $result['index'] = $asdresult;
              $result['status'] = True*$result['status'];
          }else{
              $result['status'] = False*$result['status'];
          }
        }
        return $result;
    }
}?>
