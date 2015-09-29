<?php 
$sidebardata = array(array(	'name'=>'信件通知',
							'style'=>'alert-info',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/service/mail"),'text'=>'信件'),	
								
							)
						)
					);
echo sidebar($sidebardata, $active);

 ?>