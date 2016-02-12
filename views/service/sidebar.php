<?php 
$sidebardata = array(array(	'name'=>'信件通知',
							'style'=>'alert-info',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/service/mail"),'text'=>'信件'),	
								
							)
						),
					array(	'name'=>'簡訊',
							'style'=>'alert-success',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/service/sms"),'text'=>'簡訊紀錄'),	
								array('icon'=>'','url'=>web_url("/service/smscollection"),'text'=>'罐頭簡訊'),	
								
							)
						)
					);
echo sidebar($sidebardata, $active);

 ?>