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
						),
					array(	'name'=>'維修',
							'style'=>'alert-warning',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/service/fix_record"),'text'=>'維修紀錄'),	
								
							)
						)
					);
echo sidebar($sidebardata, $active);

 ?>