<?php 
$sidebardata = array(array(	'name'=>'',
							'style'=>'',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/roomengine/index"),'text'=>'房間搜尋'),	
								// array('icon'=>'','url'=>web_url("#"),'text'=>'時間軸')
							)
						)
					);
echo sidebar($sidebardata, $active);

 ?>