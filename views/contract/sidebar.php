<?php 
$sidebardata = array(array(	'name'=>'合約',
							'data'=>array(
								array('icon'=>'','url'=>'#','text'=>'合約列表'),	
								array('icon'=>'','url'=>'#','text'=>'待結算合約'),	
								array('icon'=>'','url'=>'#','text'=>'封存合約'),	
							)
						),
					array(	'name'=>'學生',
							'data'=>array(
								array('icon'=>'','url'=>'#','text'=>'學生資料')
							)
						)
					);
echo sidebar($sidebardata, $active);

 ?>