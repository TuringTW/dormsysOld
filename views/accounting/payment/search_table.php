<h1 class="page-header">房租繳納紀錄表</h1>
<!-- 搜尋列 次導覽列 -->
	<div class="form-group">
		<div class="col-sm-3">
			<div class="input-group" style="width:100%">
					<input type="text" style="width:85%" id="txtdate"class="form-control" onchange="date_serach()" placeholder="請款日期" value="">
					<a href="#" style="width:15%" class="form-control btn btn-default" onclick="resetdate()"><span class="glyphicon glyphicon-remove"></span></a>
			</div>

		</div>
		<!-- <div class="col-md-3"> -->
			<!-- <?php echo dorm_list_html($dormlist); ?> -->
		<!-- </div> -->
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
						<th style="width:5%">#</th>
						<th>宿舍</th>
						<th>房號</th>
						<th>查看合約</th>
						<th>繳款人</th>
						<th>金額</th>
						<th>描述</th>
						<th>入帳日期</th>
					</tr>
				</thead>
				<tbody id="result_table" style="text-align:center">
				</tbody>
		</table>
	</div>
</div>
</div>
