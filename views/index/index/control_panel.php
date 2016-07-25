<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="row">
		<div class="col-sm-4">

		</div>
		<div class="col-sm-4">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  	<div class="panel panel-default">
			    	<div class="panel-heading">
				      	<h4 class="panel-title">
				        	訂單狀態
				      	</h4>
			    	</div>

			  	</div>
			  	<div class="panel panel-default">
			    	<div class="panel-heading" role="tab" id="headingOne">
				      	<h4 class="panel-title">
				        	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_due" aria-expanded="true" aria-controls="collapse_due">
				        		 過期&nbsp;&nbsp;<span class="badge" style="float:none" id="badge_not_check_out"><?=$count_reservation['countofd']?></span><a href="<?=web_url('/reservation/index')?>?option=2" title="在合約列表裡查看" class="pull-right"><span class="glyphicon glyphicon-search"></span></a>
				        	</a>
				      	</h4>
			    	</div>
			    	<div id="collapse_due" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			      		<div class="panel-body">
			      		</div>
			      		<div style="overflow-y:scroll;height:375px;">
					  		<table class="table" style="">
								<thead>
									<th>#</th><th>姓名</th><th>到期日</th><th>詳細</th>
								</thead>
								<tbody id="near_expiration_reservation" style="text-align:center">
									<?php foreach ($reservation_due as $key => $value): ?>
										<?php $name = $value['sname'] ?>
										<?php $mobile = $value['mobile'] ?>
										<tr>
											<td><?=$key+1?></td>
											<td><?=$value['sname']?>&nbsp;<a onclick="sendsms('<?=$name?>同學你好,', '<?=$mobile?>')" title="寄簡訊"><span class="glyphicon glyphicon-comment"></span></a></td>
											<td><?=$value['e_date']?></td>
											<td><a href="<?=web_url('/reservation/index')?>?id=<?=$value['id']?>" title="查看"><span class="glyphicon glyphicon-pencil"></span></a></td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
			  			</div>
			    	</div>
			  	</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  	<div class="panel panel-default">
			    	<div class="panel-heading">
				      	<h4 class="panel-title">
				        	合約狀態
				      	</h4>
			    	</div>

			  	</div>
			  	<div class="panel panel-warning">
			    	<div class="panel-heading">
				      	<h4 class="panel-title">
				        	過期合約&nbsp;&nbsp;<span class="badge" style="float:none" id="badge_not_check_out"><?=$count_ofd_due['countofd']?></span><a href="<?=web_url('/contract/index')?>?option=1" title="在合約列表裡查看" class="pull-right"><span class="glyphicon glyphicon-search"></span></a>
				      	</h4>
			    	</div>
			  	</div>
					<div class="panel panel-danger">
			    	<div class="panel-heading">
				      	<h4 class="panel-title">
				        	租金不足合約&nbsp;&nbsp;<span class="badge" style="float:none" id="badge_not_check_out"><?=$count_ofd_due['count_pne']?></span><a href="<?=web_url('/contract/index')?>?option=3" title="在合約列表裡查看" class="pull-right"><span class="glyphicon glyphicon-search"></span></a>
				      	</h4>
			    	</div>
			  	</div>

			  	<div class="panel panel-default">
			    	<div class="panel-heading" role="tab" id="headingOne">
				      	<h4 class="panel-title">
				        	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_due_in_one_m" aria-expanded="true" aria-controls="collapse_due_in_one_m">
				        		 一個月內遷出&nbsp;&nbsp;<span class="badge" style="float:none" id="badge_not_check_out"><?=$count_ofd_due['countdue_in_1_m']?></span>
				        	</a>
				      	</h4>
			    	</div>
			    	<div id="collapse_due_in_one_m" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			      		<div style="overflow-y:scroll;height:375px;">
					  		<table class="table" style="">
								<thead>
									<th>#</th><th>姓名</th><th>遷出日</th><th>詳細</th>
								</thead>
								<tbody id="near_expiration_contract" style="text-align:center">
									<?php foreach ($contract_due_in_a_month as $key => $value): ?>
										<?php $name = $value['sname'] ?>
										<?php $mobile = $value['mobile'] ?>
										<tr>
											<td><?=$key+1?></td>
											<td><?=$value['sname']?>&nbsp;<a onclick="sendsms('<?=$name?>同學你好,', '<?=$mobile?>')" title="寄簡訊"><span class="glyphicon glyphicon-comment"></span></a></td>
											<td><?=$value['out_date']?></td>
											<td><a href="<?=web_url('/contract/index')?>?contract_id=<?=$value['contract_id']?>" title="查看"><span class="glyphicon glyphicon-pencil"></span></a></td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
			  			</div>
			    	</div>
			  	</div>
			  	<div class="panel panel-default">
			    	<div class="panel-heading" role="tab" id="headingOne">
				      	<h4 class="panel-title">
				        	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_due" aria-expanded="true" aria-controls="collapse_due">
				        		 本月到期&nbsp;&nbsp;<span class="badge" style="float:none" id="badge_not_check_out"><?=$count_ofd_due['countdue']?></span><a href="<?=web_url('/contract/index')?>?option=2" title="在合約列表裡查看" class="pull-right"><span class="glyphicon glyphicon-search"></span></a>
				        	</a>
				      	</h4>
			    	</div>
			    	<div id="collapse_due" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
			      		<div class="panel-body">
			      		</div>
			      		<div style="overflow-y:scroll;height:375px;">
					  		<table class="table" style="">
								<thead>
									<th>#</th><th>姓名</th><th>到期日</th><th>詳細</th>
								</thead>
								<tbody id="near_expiration_contract" style="text-align:center">
									<?php foreach ($contract_due as $key => $value): ?>
										<?php $name = $value['sname'] ?>
										<?php $mobile = $value['mobile'] ?>
										<tr>
											<td><?=$key+1?></td>
											<td><?=$value['sname']?>&nbsp;<a onclick="sendsms('<?=$name?>同學你好,', '<?=$mobile?>')" title="寄簡訊"><span class="glyphicon glyphicon-comment"></span></a></td>
											<td><?=$value['e_date']?></td>
											<td><a href="<?=web_url('/contract/index')?>?contract_id=<?=$value['contract_id']?>" title="查看"><span class="glyphicon glyphicon-pencil"></span></a></td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
			  			</div>
			    	</div>
			  	</div>
			</div>
		</div>
	</div>
</div>
