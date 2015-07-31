<h1 class="page-header">合約列表</h1>
<!-- 搜尋列 次導覽列 -->
	<form method="GET" action="contract.php">
		<div class="form-group">
			<div class="col-sm-3">
				<input type="text" class="form-control" name="search" placeholder="搜尋:宿舍、房號、姓名" value="">
			</div>
			<div class="col-sm-1">
				<a name="searchsubmit" class="btn btn-primary" >搜尋</a>
			</div>
			<div class="col-md-3">
				<?php echo dorm_list_html($dormlist); ?>
			</div>
			<div class="col-sm-3">
				<div class="btn-group">
					<a href="#" name="searchsubmit" class="btn btn-default" >本月到期&nbsp;&nbsp;<span class="badge">1</span></a>
					<a href="#" name="searchsubmit" class="btn btn-default" >過期合約&nbsp;&nbsp;<span class="badge">1</span></a>
				</div>
			</div>

			<div class="col-sm-2">
				<a href="#" class="btn btn-default " ><span class=" glyphicon glyphicon-chevron-left"></span></a>
				<a href="#" class="btn btn-default " >1</a>
				<a href="#" class="btn btn-default " ><span class=" glyphicon glyphicon-chevron-right"></span></a>

			</div>
		</div>	
	</form>
	<br>
	<br>
	<hr>
			<!-- 搜尋結果 -->

	<div class="table-responsive">
		<table class="table table-striped">
			
				<thead>
					<tr>
						<th>#</th>
						<th>學生姓名</th>
						<th>宿舍</th>
						<th>房號</th>
						<th>合約開始</th>
						<th>合約結束</th>
						<th>遷入日期</th>
						<th>遷出日期</th>
						<th style="width:5%">詳細</th>
					</tr>
				</thead>
				<tbody>



				<!-- 	<?php 
						$c_num = 0;
						$color = 1;
						foreach ($searchresults as $key => $searchresult) { ?>
					<tr <?php 
						if ($c_num != $searchresult['c_num']) {
							$color = !$color;
							$c_num = $searchresult['c_num'];
						}
						if ($color == 1){ ?>
						class="info"
					<?php }else{ 
						$c_num = $searchresult['c_num']; ?>
						class="warning"
					<?php } ?>>
						<td><?=($page-1)*30+$key+1?></td>
						<td><?=$searchresult['sname']?></td>
						<td><?=$searchresult['dname']?></td>
						<td><?=$searchresult['rname']?></td>
						<td><?=$searchresult['s_date']?></td>
						<td><?=$searchresult['e_date']?></td>
						<td><?=$searchresult['rent']?></td>
						<td><a onclick="showcontract(<?=$searchresult['c_num']?>)"><span class="glyphicon glyphicon-pencil"></span></a></td>
						<td><input type="checkbox" value="<?=$searchresult['contract_id']?>" name="tocsv[]"></td>
					</tr>
					<?php } ?> -->
				</tbody>
		</table>
	</div>
</div>
</div>

<script type="text/javascript">
	

</script>