<h1 class="page-header">報修總表</h1>
<!-- 搜尋列 次導覽列 -->
	<div class="form-group">
		<!-- <div class="col-sm-2">
			<input type="text" id="txtkeyword"class="form-control" onchange="keyword_serach()" placeholder="名稱、宿舍、請款單位" value="">
		</div>
		<div class="col-sm-2">

		</div> -->
		<!-- <div class="col-md-3">
			<?php echo dorm_list_html($dormlist); ?>
		</div> -->
		
		<div class="col-sm-2">
			<!-- <?php echo type_list_html($typelist); ?> -->

		</div>
		<!-- <div class="col-sm-2">
			<input type="hidden" value="1" id="page_value">
			<a href="#" class="btn btn-default " onclick="pagemove(-1);" id="page_down" disabled="true"><span class=" glyphicon glyphicon-chevron-left"></span></a>
			<a href="#" class="btn btn-default " onclick="pagemove(0);" id="show_page">1</a>
			<a href="#" class="btn btn-default " onclick="pagemove(1);" id="page_up"><span class=" glyphicon glyphicon-chevron-right"></span></a>

		</div> -->
		<!-- <div class="col-sm-1 ">
			<div class="btn-group">
				<a href="#" class="btn btn-default" onclick="new_item()">新支出</a>
			</div>
		</div> -->
	</div>	
	<!-- <br>
	<br>
	<hr> -->
			<!-- 搜尋結果 -->

	<div class="table-responsive">
		<table class="table table-hover" >
				<thead>
					<tr>
						<th style="width:5%">#</th>
						<th>宿舍名稱</th>
						<th>報修地點</th>
						<th>報修項目</th>
						<th>報修人</th>
						<th>電話</th>
						<th>報修時間</th>
						<th style="width:5%">陪同否</th>
						<th style="width:5%">詳細</th>
						<!-- <th style="width:5%">解決</th> -->	
						<!-- <th style="width:5%">刪除</th> -->
						
					</tr>
				</thead>
				<tbody id="result_table" style="text-align:center">



		
				</tbody>
		</table>
	</div>
</div>
</div>

