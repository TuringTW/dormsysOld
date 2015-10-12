<?php 
$sidebardata = array(array(	'name'=>'',
							'style'=>'',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/accounting/expenditure"),'text'=>'支出管理'),	
								// array('icon'=>'','url'=>web_url("#"),'text'=>'時間軸')
							)
						)
					);
echo sidebar($sidebardata, $active);

 ?>