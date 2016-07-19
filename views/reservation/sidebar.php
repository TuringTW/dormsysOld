<?php
$sidebardata = array(array(	'name'=>'',
							'style'=>'',
							'data'=>array(
								array('icon'=>'','url'=>web_url("/reservation/index"),'text'=>'預定列表'),
								array('icon'=>'','url'=>web_url("/reservation/newres"),'text'=>'新增預定單'),
							)
						),
					);
echo sidebar($sidebardata, $active);

 ?>
