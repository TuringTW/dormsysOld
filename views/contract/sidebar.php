<?php 
$sidebardata = array(array(	'name'=>'合約',
							'style'=>'alert-info',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/contract/index"),'text'=>'合約列表'),	
								array('icon'=>'','url'=>web_url("/contract/checkout"),'text'=>'待結算合約'),	
								array('icon'=>'','url'=>'#','text'=>'封存合約'),	
								array('icon'=>'','url'=>web_url("/contract/newcontract"),'text'=>'新增合約'),	
							)
						),
					array(	'name'=>'學生',
							'style'=>'alert-success',
							'data'=>array(
								array('icon'=>'','url'=>web_url('/student/index'),'text'=>'學生資料')
							)
						)
					);
echo sidebar($sidebardata, $active);

 ?>