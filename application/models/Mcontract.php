

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcontract extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }
    // 取得合約列表
    function show_contract_list($keyword, $dorm, $seal, $due, $outofdate, $page)
    {
        // 即將到期
        $duerule = "1";
        if ($due==1) {
            $duerule = "(Month(`e_date`)=".date('m')." and Year(`e_date`)=".date('Y').")";
        }

        // 逾期
        $ofdrule = "1";
        if ($outofdate==1) {
            $ofdrule = "DATEDIFF(`e_date`,'".date('Y-m-d')."')<=0";
        }
        // 宿舍
        $dormrule = "1";
        if ($dorm != 0&&!is_null($dorm)) {
            $dormrule = "`dorm`.`dorm_id` = '$dorm'";
        }
        if ($page <= 0) {
            $page = 1;
        }


        // 頁數
        $pages = 30*$page-30;
        $sql = "SELECT  `contract`.`contract_id`,`contract`.`c_num`,`contract`.`rent`,`contract`.`keep`,`contract`.`sales`,`student`.`name` as `sname`,`dorm`.`name`as `dname`,`room`.`name`as`rname`,  `contract`.`s_date`,`contract`.`in_date`,`contract`.`out_date` ,  `contract`.`e_date`,`contract`.`seal`
            FROM  `contract` 
            LEFT JOIN `room` on `room`.`room_id`=`contract`.`room_id`
            LEFT JOIN `dorm` on `dorm`.`dorm_id`=`room`.`dorm`
            LEFT JOIN `student` on `student`.`stu_id`=`contract`.`stu_id`
            WHERE  (`student`.`name` LIKE 
            BINARY  '%$keyword%'
            or  `dorm`.`name` LIKE 
            BINARY  '%$keyword%'
            or  `room`.`name` LIKE 
            BINARY  '%$keyword%'
            or   `student`.`name` LIKE 
            BINARY  '%$keyword'
            or  `dorm`.`name` LIKE 
            BINARY  '%$keyword'
            or  `room`.`name` LIKE 
            BINARY  '%$keyword'
            or   `student`.`name` LIKE 
            BINARY  '$keyword%'
            or  `dorm`.`name` LIKE 
            BINARY  '$keyword%'
            or  `room`.`name` LIKE 
            BINARY  '$keyword%')
            and `contract`.`seal` = 0
            and $duerule
            and $ofdrule
            and $dormrule
            
            ORDER BY `dorm`.`name` DESC,`room`.`name`,`contract`.`c_num`
            LIMIT $pages,30";
        $query = $this->db->query($sql);
        return $query->result_array();

    }
    // 取得單筆合約資料
    function get_contract_info($c_num)
    {
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
            return 0;
        }
    }


}?>