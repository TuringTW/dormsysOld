<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mreservation extends CI_Model
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
    function show_reservation_list($keyword, $dorm, $ofd, $wait, $page, $order_method=0, $order_law=0, $page_rule, $start_val='', $end_val='')
    {

        $this->db->select("reservation.id,dorm.name as dname, room.name as rname, sname, mobile, is_res_deposit, is_deposit, d_date, e_date, s_date");
        $this->db->from('reservation');
        $this->db->join('room','room.room_id=reservation.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');

        $this->db->where('( 0',NULL, false); //for logic
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('sname',$keyword)->or_like('mobile',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->where('( 0',NULL, false); //for logic
            $this->db->or_where('seal', 0);
        $this->db->or_where('0 )',NULL, false);
        //開始結束日期限制
        if ($start_val) {
          //
          // 沒有作日期檢查！！！
          //
          $strrule = "(DATEDIFF(DATE_FORMAT(`s_date`,'%Y-%m-%d'), '".$start_val."')>=0)"; //前剪後
          $this->db->where($strrule);

        }
        if ($end_val) {
          $endrule = "(DATEDIFF(DATE_FORMAT(`s_date`,'%Y-%m-%d'), '".$end_val."')<=0)"; //前剪後
          $this->db->where($endrule);

        }
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
          $dormrule = "`dorm`.`dorm_id` = '$dorm'";
          $this->db->where($dormrule);
        }

        // 逾期
        if ($ofd==1) {
            $ofdrule = "DATEDIFF(`d_date`,'".date('Y-m-d')."')<=0";
            $this->db->where($ofdrule);
        }
        // 逾期
        if ($wait==1) {
            $this->db->where('is_deposit', 1);
        }
        // 排序規則
        $order_rule="desc";
        if ($order_law==1) {
            $order_rule="asc";
        }
        switch ($order_method) {
            case 1:
                $this->db->order_by("BINARY `dorm`.`name`", $order_rule, false);
                break;
            case 2:
                $this->db->order_by("BINARY `dorm`.`name`", $order_rule, false);
                $this->db->order_by("BINARY `room`.`name`", "asc", false);
                $this->db->order_by("in_date", "desc");
                break;
            case 3:
                $this->db->order_by("BINARY `reservation`.`sname`", $order_rule, false);
                break;
            case 4:
                $this->db->order_by("mobile", $order_rule);
                break;
            case 5:
                $this->db->order_by("s_date", $order_rule);
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                $this->db->order_by("timestamp", "desc");
                break;
            case 6:
                $this->db->order_by("e_date", $order_rule);
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                $this->db->order_by("timestamp", "desc");
                break;
            case 7:
                $this->db->order_by("d_date", $order_rule);
                $this->db->order_by("BINARY `dorm`.`name`", "desc", false);
                $this->db->order_by("BINARY `room`.`name`", "desc", false);
                $this->db->order_by("timestamp", "desc");
                break;

            default:
                $this->db->order_by("timestamp", "desc");
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
    function get_reservation_info($r_id){
        if (!is_nan($r_id)) {
            $this->db->select('id, dorm.name as dname, dorm.dorm_id, room.name as rname, room.room_id, sname, mobile, s_date, e_date, d_date, timestamp, reservation.note, sales, manager.name as mname, is_res_deposit, is_deposit');
            $this->db->from('reservation');
            $this->db->join('room','room.room_id=reservation.room_id','left');
            $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
            $this->db->join('manager','manager.m_id=reservation.m_id','left');
            $this->db->where('reservation.id', $r_id)->where('seal<>', 1);

            $query = $this->db->get();
            return $query->result_array();
        }else{
            return false;
        }
    }
    function edit_contract($r_id, $sname, $mobile, $s_date, $e_date, $d_date, $sales, $note){
        $sql = "UPDATE `reservation` set   `s_date` = '$s_date',
                                        `e_date` = '$e_date',
                                        `sname` = '$sname',
                                        `mobile` = '$mobile',
                                        `d_date` = '$d_date',
                                        `sales` = '$sales',
                                        `note` = '$note'
                                where `id` = '$r_id'";
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
        $this->db->select("reservation.id,dorm.name as dname, room.name as rname, sname, mobile, is_res_deposit, is_deposit, d_date, e_date, s_date");
        $this->db->from('reservation');
        $this->db->join('room','room.room_id=reservation.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');

        $this->db->where('( 0',NULL, false); //for logic
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('sname',$keyword)->or_like('mobile',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->where('( 0',NULL, false); //for logic
            $this->db->or_where('seal', 0);
        $this->db->or_where('0 )',NULL, false);
        //開始結束日期限制
        if ($start_val) {
          //
          // 沒有作日期檢查！！！
          //
          $strrule = "(DATEDIFF(DATE_FORMAT(`s_date`,'%Y-%m-%d'), '".$start_val."')>=0)"; //前剪後
          $this->db->where($strrule);

        }
        if ($end_val) {
          $endrule = "(DATEDIFF(DATE_FORMAT(`s_date`,'%Y-%m-%d'), '".$end_val."')<=0)"; //前剪後
          $this->db->where($endrule);

        }
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
          $dormrule = "`dorm`.`dorm_id` = '$dorm'";
          $this->db->where($dormrule);
        }
        // 逾期
        $ofdrule = "DATEDIFF(`d_date`,'".date('Y-m-d')."')<0";
        $this->db->where($ofdrule);

        $result['countofd'] = $this->db->count_all_results();


    // 本月到期
        $this->db->flush_cache();
        $this->db->select("reservation.id,dorm.name as dname, room.name as rname, sname, mobile, is_res_deposit, is_deposit, d_date, e_date, s_date");
        $this->db->from('reservation');
        $this->db->join('room','room.room_id=reservation.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');

        $this->db->where('( 0',NULL, false); //for logic
        $this->db->or_like('dorm.name',$keyword)->or_like('room.name',$keyword)->or_like('sname',$keyword)->or_like('mobile',$keyword);
        $this->db->or_where('0 )',NULL, false);
        $this->db->where('( 0',NULL, false); //for logic
            $this->db->or_where('seal', 0);
        $this->db->or_where('0 )',NULL, false);
        //開始結束日期限制
        if ($start_val) {
          //
          // 沒有作日期檢查！！！
          //
          $strrule = "(DATEDIFF(DATE_FORMAT(`s_date`,'%Y-%m-%d'), '".$start_val."')>=0)"; //前剪後
          $this->db->where($strrule);

        }
        if ($end_val) {
          $endrule = "(DATEDIFF(DATE_FORMAT(`s_date`,'%Y-%m-%d'), '".$end_val."')<=0)"; //前剪後
          $this->db->where($endrule);

        }
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
          $dormrule = "`dorm`.`dorm_id` = '$dorm'";
          $this->db->where($dormrule);
        }
        // wait rule
        $this->db->where('is_deposit', 1);
        $result['count_wait'] = $this->db->count_all_results();
        return $result;
    }
// 這個不太好
    function date_check_by_room($room_id, $in_date, $out_date, $contract_id){
        $this->db->select('contract_id, room_id');
        $this->db->from('contract');
        // join

        $this->db->where("((DATEDIFF('$in_date', in_date)>=0 and DATEDIFF(out_date, '$in_date')>=0 )
            or    (DATEDIFF('$in_date', in_date)<=0 and DATEDIFF(out_date, '$out_date')<=0)
            or    (DATEDIFF('$out_date', in_date)>=0 and DATEDIFF(out_date, '$out_date')>=0) )and seal<>1");
        $this->db->where('contract.room_id', $room_id);

        $query = $this->db->get();
        $result = $query->result_array();

        if (($query->num_rows() == 0||($query->num_rows()==1&&$result[0]['contract_id']==$contract_id))&&(strtotime($out_date)-strtotime($in_date)>0)) {
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
    function add_reservation($new_sname, $new_mobile, $dorm_select, $room_select, $d_date, $sales, $note, $datepickerStart, $datepickerEnd, $res_deposit){
        $c_date = date('Y-m-d h:i:s');
        $manager = $this->login_check->get_user_id();


        $result = array();
        $result['error_id'] = array();
        $result['state'] = 1;
        $insertdata = array(    'sname'=>$new_sname,
                                'mobile'=>$new_mobile,
                                'room_id'=>$room_select,
                                'd_date'=>$d_date,
                                's_date'=>$datepickerStart,
                                'e_date'=>$datepickerEnd,
                                'sales'=>$sales,
                                'm_id'=>$manager,
                                'note'=>$note);
        $this->db->insert('reservation', $insertdata);
        $r_id = $this->db->insert_id();
        if ($this->db->affected_rows()>0) {
            $result['id'] = $r_id;
            $result['state'] = 1;

            $insertdata = array(  'contract_id'=>0,
                                  'r_id'=>$r_id,
                                  'customer'=>$new_sname,
                                  'value'=>$res_deposit,
                                  'date'=>date('Y-m-d'),
                                  'receipt_id'=>'AT-&nbsp;R-&nbsp;'.str_pad($r_id,7,'0',STR_PAD_LEFT),
                                  'm_id' =>$manager,
                                  'description'=>($new_sname.'-'.$new_mobile.'租屋押金') );
            $this->db->insert('payment', $insertdata);
            if ($this->db->affected_rows()>0) {
                $result['id'] = $r_id;
                $result['state'] = 1;
            }else{
                $result['state']=2;
            }
        }else{
            $result['state'] = 0;
        }

        return $result;


    }
    function get_print_data($r_id){
        $result = array();
        $this->db->select('dorm.name as dname, room.name as rname, sname, mobile, s_date, e_date, d_date, timestamp, location');
        $this->db->from('reservation');
        $this->db->join('room','room.room_id = reservation.room_id','left');
        $this->db->join('dorm','room.dorm=dorm.dorm_id','left');
        $this->db->where('reservation.id=', $r_id)->where('seal<>', 1);
        $this->db->order_by('sname')->order_by('mobile');
        $query = $this->db->get();
        $countpeo = $query->num_rows();
        $result['countpeo'] = $countpeo;
        $result['data'] = $query->result_array();

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

        $this->db->select('dorm.name as dname, room.name as rname, room.type, if(isnull(precontract.contract_id), "",precontract.contract_id) as pre_id, if(isnull(precontract.out_date), "",precontract.out_date) as out_date, if(isnull(postcontract.contract_id), "", postcontract.contract_id)  as post_id, if(isnull(postcontract.in_date),"",postcontract.in_date) as in_date, room.rent, room.room_id, if(isnull(postcontract.postmin), 4000, postcontract.postmin) as postmin, if(isnull(precontract.premin), 4000, precontract.premin) as premin, if(isnull(postcontract.postmin), 0, postcontract.postmin)+if(isnull(precontract.premin), 4000, precontract.premin) as prepost');
        $this->db->from('room');
        // join
        $this->db->join('dorm', 'dorm.dorm_id = room.dorm', 'left');
        $this->db->join("(select temp.* from (select contract_id, room_id, (DATEDIFF('$str_date',out_date )) as premin, out_date from contract where DATEDIFF('$str_date',in_date )>0 and DATEDIFF('$str_date',out_date )>0 and seal<>1 order by room_id, DATEDIFF('$str_date',out_date ) ) as temp group by `room_id`) as precontract ", 'precontract.room_id = room.room_id', 'left');

        $this->db->join("(select temp1.* from (select contract_id, room_id, (DATEDIFF(in_date, '$end_date')) as postmin, in_date from contract where DATEDIFF(in_date, '$end_date')>0 and DATEDIFF(out_date, '$end_date')>0 and seal<>1 order by room_id, DATEDIFF(out_date, '$end_date') ) as temp1 group by room_id) as postcontract", 'postcontract.room_id = room.room_id', 'left');
        $this->db->join("(select count(contract_id) as countc, room_id from contract where (
                (DATEDIFF('$str_date', in_date)>=0 and DATEDIFF(out_date, '$str_date')>=0 )
            or    (DATEDIFF('$str_date', in_date)<=0 and DATEDIFF(out_date, '$end_date')<=0)
            or    (DATEDIFF('$str_date', in_date)>=0 and DATEDIFF(out_date, '$end_date')>=0)
            or    (DATEDIFF('$end_date', in_date)>=0 and DATEDIFF(out_date, '$end_date')>=0) )and seal<>1 and seal<>-1 group by room_id) as contractcheck", 'contractcheck.room_id = room.room_id', 'left');
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

    function pdf_gen($r_id, $method){
        $this->load->library(array('pdf'));

        if (!is_null($r_id)&&is_numeric($r_id)) {
            $data = $this->Mreservation->get_print_data($r_id);

            $this->pdf->Header('蔡阿姨宿舍房間訂單');

            $this->pdf->SetAuthor('AunttsaiDormSYS');
            $this->pdf->SetTitle('蔡阿姨宿舍房間訂單');
            $this->pdf->SetSubject('蔡阿姨宿舍房間訂單');
            $this->pdf->SetKeywords('租賃,合約');
            $this->pdf->SetHeaderMargin(0);
            $this->pdf->SetTopMargin(5);
            $this->pdf->setFooterMargin(0);
            $this->pdf->SetAutoPageBreak(true);
            $this->pdf->SetDisplayMode('real', 'default');

            // print_r($data['data']);


            $pw = $this->pdf->getPageWidth()*2.5;
            $data['wu'] = $pw;
            $data['barcodetext'] = 'AT-&nbsp;R-&nbsp;'.str_pad($r_id,7,'0',STR_PAD_LEFT);
            // add a page

            $this->pdf->AddPage();


            $this->pdf->SetFont('msungstdlight', '', 20);
            $this->pdf->Cell(210, 16,'蔡阿姨宿舍房間訂金收據(存根聯)', 0, false,0 , 0, '', 0, false, 'J', 'B');
            $this->pdf->SetFont('msungstdlight', '', 12);
            $this->pdf->load_view('reservation/pdf/index', $data);


            $image_file = img_url("/banner.jpg");
  	        // $this->pdf->Image($image_file, 10, 5, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->pdf->Image($image_file, $x=10, $y=157, $w=50, $h=15, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array());
            $this->pdf->SetFont('msungstdlight', '', 20);
            // $this->pdf->Image($image_file, 10, 5, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->pdf->Cell(210, 16,'蔡阿姨宿舍房間訂金收據(收執聯)', 0, false,0 , 0, '', 0, false, 'J', 'B');
            $this->pdf->SetFont('msungstdlight', '', 12);
            $data['second']=1;
            $this->pdf->load_view('reservation/pdf/index', $data);
            ob_end_clean();
            if ($method == 0) {
                //client side
                $this->pdf->Output('My-File-Name.pdf', 'I');
                return 0;
            }else if($method == 1){
                //server side
                $root = $_SERVER['SCRIPT_FILENAME'];
                $root = mb_substr($root,0,strpos($root,'index.php'));

                $this->pdf->Output($root.'/contract_pdf/contract_'.$r_id.'.pdf', 'F');
                $path = $root.'/contract_pdf/contract_'.$r_id.'.pdf';
                return $path;
            }

        }else{
            return false;
        }
    }
    function delete_contract($r_id){
        $data = array('seal'=> 1);
        $this->db->where("r_id", $r_id);
        $this->db->update("contract", $data);
        return TRUE;
    }
    function show_handover_list($keyword, $dorm = 0, $start_val, $end_val){
      $result = array();
      $result['status'] = False;
      if (empty($start_val) ||empty( $end_val) ) {
        $result['status'] = False;
      }else{
          // $query = $this->db->query("SELECT `contract`.`r_id`, count(`contract`.`r_id`) as `count`, student.name as sname, `in_date`, `out_date`, `room_id`, if(`out_date`=\"2016-06-30\", \"out\", \"in\") as `inout`, `clean`, `out_text` from `contract` left join `contractpeo` on `contractpeo`.`r_id` = `contract`.`r_id` left join `student` on `contractpeo`.`stu_id` = `student`.`stu_id` where `seal`=0 and `out_date`=\"2016-06-30\" or `in_date`=\"2016-06-30\" group by `contract`.`r_id`");
          // $query = $this->db->query("select dorm.name as dname, room.name as rname, Jun302016o.r_id, Jun302016o.sname, Jun302016o.count, Jun302016o.inout, Jun302016o.clean, Jun302016o.out_text,Jul012016i.r_id, Jul012016i.sname, Jul012016i.count, Jul012016i.inout, Jul012016i.clean, Jul012016i.out_text,Jun282016i.r_id, Jun282016i.sname, Jun282016i.count, Jun282016i.inout, Jun282016i.clean, Jun282016i.out_text from room LEFT JOIN dorm on dorm.dorm_id = room.dorm LEFT JOIN ( SELECT `contract`.`r_id`, count(`contract`.`r_id`) as `count`, student.name as sname, `in_date`, `out_date`, `room_id`, if(`out_date`=\"2016-06-30\", \"out\", \"in\") as `inout`, `clean`, `out_text` from `contract` left join `contractpeo` on `contractpeo`.`r_id` = `contract`.`r_id` left join `student` on `contractpeo`.`stu_id` = `student`.`stu_id` where `seal`=0 and `out_date`=\"2016-06-30\" or `in_date`=\"2016-06-30\" group by `contract`.`r_id` ) as `Jun302016o` on `Jun302016o`.`room_id` = `room`.`room_id` LEFT JOIN ( SELECT `contract`.`r_id`, count(`contract`.`r_id`) as `count`, student.name as sname, `in_date`, `out_date`, `room_id`, if(`out_date`=\"2016-07-01\", \"out\", \"in\") as `inout`, `clean`, `out_text` from `contract` left join `contractpeo` on `contractpeo`.`r_id` = `contract`.`r_id` left join `student` on `contractpeo`.`stu_id` = `student`.`stu_id` where `seal`=0 and `out_date`=\"2016-07-01\" or `in_date`=\"2016-07-01\" group by `contract`.`r_id` ) as `Jul012016i` on `Jul012016i`.`room_id` = `room`.`room_id` LEFT JOIN ( SELECT `contract`.`r_id`, count(`contract`.`r_id`) as `count`, student.name as sname, `in_date`, `out_date`, `room_id`, if(`out_date`=\"2016-06-28\", \"out\", \"in\") as `inout`, `clean`, `out_text` from `contract` left join `contractpeo` on `contractpeo`.`r_id` = `contract`.`r_id` left join `student` on `contractpeo`.`stu_id` = `student`.`stu_id` where `seal`=0 and `out_date`=\"2016-06-28\" or `in_date`=\"2016-06-28\" group by `contract`.`r_id` ) as `Jun282016i` on `Jun282016i`.`room_id` = `room`.`room_id` where dorm.active = 1 and isnull(Jun302016o.r_id)+isnull(Jul012016i.r_id)+isnull(Jun282016i.r_id)<3 order by `dorm`.`name`, `room`.`name` limit 0, 30");
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
