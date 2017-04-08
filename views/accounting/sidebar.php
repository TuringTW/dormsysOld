<?php
$sidebardata = array(
						array(	'name'=>'公司支出',
							'style'=>'',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/accounting/expenditure"),'text'=>'支出管理'),
							)
						),array(	'name'=>'房租紀錄',
							'style'=>'',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/accounting/payment"),'text'=>'租金收款紀錄'),
							)
						)



					);
echo sidebar($sidebardata, $active);

 ?>
