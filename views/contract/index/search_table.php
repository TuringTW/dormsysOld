<h1 class="page-header">合約列表</h1>
<!-- 搜尋列 次導覽列 -->
	<!-- for view -->
	<input type="hidden" id="view_contract_id" value="<?=$view_contract_id?>">
	<input type="hidden" id="view_option" value="<?=$view_ofd_contract?>">

	<div class="form-group">
		<div class="col-sm-3">
			<input type="text" id="txtkeyword"class="form-control" onchange="keyword_serach()" placeholder="Enter搜:宿舍、房號、姓名、手機" value="">
		</div>
		<div class="col-md-3">
			<?php echo dorm_list_html($dormlist); ?>
		</div>
		<div class="col-sm-4">
			<div class="btn-group">
				<input type="hidden" id="due_value" value="0">
				<input type="hidden" id="ofd_value" value="0">
				<a href="#" id="btnDue" onclick="due_select()" class="btn btn-default" >本月到期&nbsp;&nbsp;<span class="badge" id="view_due">1</span></a>
				<a href="#" id="btnOFD" onclick="ofd_select()" class="btn btn-default" >過期合約&nbsp;&nbsp;<span class="badge" id="view_ofd">1</span></a>
			</div>
		</div>

		<div class="col-sm-2">
			<input type="hidden" value="1" id="page_value">
			<a href="#" class="btn btn-default " onclick="pagemove(-1);" id="page_down" disabled="true"><span class=" glyphicon glyphicon-chevron-left"></span></a>
			<a href="#" class="btn btn-default " onclick="pagemove(0);" id="show_page">1</a>
			<a href="#" class="btn btn-default " onclick="pagemove(1);" id="page_up"><span class=" glyphicon glyphicon-chevron-right"></span></a>

		</div>
	</div>	
	<br>
	<br>
	<hr>
			<!-- 搜尋結果 -->

	<div class="table-responsive">
		<table class="table table-hover" style="text-align:center">
			
				<thead>
					<input type="hidden" id="order_law" value="false"> <?php //0是遞增 1是遞減 ?>
					<input type="hidden" id="order_method" value="0"> <?php // ?>
					<tr>
						<th style="width:5%"><a href="#" title="依預設方式排列" onclick="table_order(0)">#</a></th>
						<th style="width:7%">狀態</th>
						<th><a href="#" title="依照學生姓名遞增/遞減排列" onclick="table_order(1)">學生姓名<span class="order_marker" id="order_marker_1" style="display:none;"></span></a></th>
						<th><a href="#" title="依照宿舍遞增/遞減排列" onclick="table_order(2)">宿舍<span class="order_marker" id="order_marker_2" style="display:none;"></span></a></th>
						<th><a href="#" title="依照房號遞增/遞減排列" onclick="table_order(3)">房號<span class="order_marker" id="order_marker_3" style="display:none;"></span></a></th>
						<th><a href="#" title="依照合約開始遞增/遞減排列" onclick="table_order(4)">合約開始<span class="order_marker" id="order_marker_4" style="display:none;"></span></a></th>
						<th><a href="#" title="依照合約結束遞增/遞減排列" onclick="table_order(5)">合約結束<span class="order_marker" id="order_marker_5" style="display:none;"></span></a></th>
						<th><a href="#" title="依照遷入日期遞增/遞減排列" onclick="table_order(6)">遷入日期<span class="order_marker" id="order_marker_6" style="display:none;"></span></a></th>
						<th><a href="#" title="依照遷出日期遞增/遞減排列" onclick="table_order(7)">遷出日期<span class="order_marker" id="order_marker_7" style="display:none;"></span></a></th>
						<th><a href="#" title="依照新增日期遞增/遞減排列" onclick="table_order(8)">新增日期<span class="order_marker" id="order_marker_8" style="display:none;"></span></a></th>
						<th style="width:5%">詳細</th>
					</tr>
				</thead>
				<tbody id="result_table">



		
				</tbody>
		</table>
	</div>
</div>
</div>

