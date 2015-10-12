

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
    // 租金計算
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
    // 支出列表
    function show_expenditure_list($keyword, $page, $type, $dorm, $rtype){
        $this->db->select('item_id, receipttype, item, cate, dorm.name as dname, item.dorm_id, company, money, isrequest, billing, date')->from('item');
        $this->db->join('itemcate', 'itemcate.cate_id = item.type');
        $this->db->join('dorm','item.dorm_id=dorm.dorm_id','left');
        $this->db->where('( 0',NULL, false); //for logic 
        $this->db->or_like('item.item',$keyword)->or_like('dorm.name',$keyword)->or_like('itemcate.cate',$keyword)->or_like('company',$keyword);
        $this->db->or_where('0 )',NULL, false);
        // 宿舍
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
            $this->db->where($dormrule);
        }
        // 類別
        if ($type != 0&&!is_null($type)) {
            $dormrule = "`item`.`type` = '$type'";
            $this->db->where($dormrule);
        }
        // 類別
        if ($rtype != 0&&!is_null($rtype)) {
            $dormrule = "`item`.`receipttype` = '$rtype'";
            $this->db->where($dormrule);
        }
        $this->db->order_by("timestamp", "desc"); 
        // 頁數
        if ($page <= 0) {
            $page = 1;
        }
        $pages = 30*$page-30;
        $this->db->limit(30,$pages);

        $query = $this->db->get();
        return $query->result_array();


    }
    function show_item($item_id){
        $this->db->select('item_id, receipttype as rtype, item, type, dorm_id, company, money, isrequest, billing, date, note, m_id')->from('item');
        $this->db->where('item_id', $item_id); //for logic 
        $query = $this->db->get();
        
        if ($query->num_rows()>0) {
            $result['data'] = $query->result_array();
            $result['state'] = TRUE;
        }else{
            $result['state']=FALSE;
        }
        return $result;
    }
    function edit_item($rtype, $item, $type, $note, $company, $money, $date, $dorm, $billing, $item_id){
        $data = array(  'receipttype'=>$rtype,
                        'item'=>$item,
                        'type'=>$type,
                        'note'=>$note,
                        'company'=>$company,
                        'money'=>$money,
                        'date'=>$date,
                        'dorm_id'=>$dorm,
                        'billing'=>$billing,
                        );
        if ($item_id == 0) {
            $this->db->insert('item', $data);
        }else{
            $this->db->where('item_id', $item_id);
            $this->db->update('item', $data);
        }
        if($this->db->affected_rows()>0){
            $result['state']=TRUE;
        }else{
            $result['state']=FALSE;
        }
        return $result;
    }

}?>