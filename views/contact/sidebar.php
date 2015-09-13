<?php 
$sidebardata = array(array(	'name'=>'',
							'style'=>'',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/contact/stulist"),'text'=>'學生通訊錄')	
								// array('icon'=>'','url'=>web_url("/contract/checkout"),'text'=>'常用通訊錄')
							)
						)
					);
echo sidebar($sidebardata, $active);

 ?>