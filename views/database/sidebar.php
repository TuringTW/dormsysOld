<?php 
$sidebardata = array(array(	'name'=>'管理',
							'style'=>'alert-info',
							'data'=>array(
								// array('icon'=>'','url'=>web_url("/database/dorm"),'text'=>'宿舍管理'),	
								array('icon'=>'','url'=>web_url("/database/room"),'text'=>'房間管理'),	
								// array('icon'=>'','url'=>web_url("/database/electronum"),'text'=>'電表管理'),	
							)
						),
					
					);
echo sidebar($sidebardata, $active);

 ?>