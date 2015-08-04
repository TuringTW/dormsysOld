<h1 class="page-header">合約列表</h1>
<!-- 搜尋列 次導覽列 -->
	<div class="form-group">
		<div class="col-sm-4">
			<input type="text" id="txtkeyword"class="form-control" onchange="keyword_serach()" placeholder="按Enter搜尋:宿舍、房號、姓名、手機" value="">
		</div>
		<div class="col-md-3">
			<?php echo dorm_list_html($dormlist); ?>
		</div>
		<div class="col-sm-3">
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
		<table class="table table-hover" >
			
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
				<tbody id="result_table">



		
				</tbody>
		</table>
	</div>
</div>
</div>

