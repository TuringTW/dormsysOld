<?php 
	if ( ! function_exists('dorm_list_html'))
	{

		function dorm_list_html($dormlist){
			?>
					<div class="btn-group" style="width:100%">
						<button type="button" class="btn btn-default dropdown-toggle btn-success" data-toggle="dropdown" style="width:100%">
							宿舍:<?php if (empty($dorm)) {
								echo "全部";
							}else{foreach ($dormlist as  $dorm) { if ($dorm['dorm_id']==$dorm) {
								echo $dorm['name'];					
									}} } ?> <span class="caret"></span>
						</button>
						<?php 	$countdorm = count($dormlist);
								$coln = floor(($countdorm+2)/10);
								$j = 0; 
						?>
						<div class="dropdown-menu" role="menu" style="margin-left: -120%;width:<?=($coln>1)?($coln-2)*100+200:200?>%">
							<div class="row" style="width:100%">
								<?php for ($i=0; $i <= $coln; $i++) { ?>
									<div class="col-md-<?=floor(12/($coln+1))?>" style="padding-left:15px;padding-right:0px;">
										
										<ul class="nav navbar" style="width:100%">
											<?php if ($i==0) { ?>
												<li style="font-size:15px;font-weight:bold;"><a href="#" style="color:#003767">全部</a></li>									
												<hr>
											<?php 
													$key = $j -2;
												}else{
													$key = $j;
												} ?>
											<?php while($j < $key+10 && $j < $countdorm) { ?>
												<?php $value = $dormlist[$j];
												if ($value['dorm_id']!=33&&$value['dorm_id']!=34){ ?>
													<li style="font-size:15px;font-weight:bold;"><a href="#" style="color:#003767"><?=$value['name']?></a></li>									
												<?php }else{ ?>
													<?php $key++; ?>
												<?php } ?>
												<?php $j++ ?>
											<?php } ?>
										</ul>
									</div>	
								<?php } ?>
							</div>
						</div>
					</div>



			<?php
		}
	}
?>