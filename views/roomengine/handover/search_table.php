<h1 class="page-header">合約列表</h1>
<!-- 搜尋列 次導覽列 -->

	<div class="form-group row">
		<div class="col-sm-5">
			<input type="text" id="txtkeyword"class="form-control" onchange="keyword_serach()" placeholder="Enter搜:宿舍、房號、姓名、手機" value="">
		</div>
		<div class="col-md-3">
			<?php echo dorm_list_html($dormlist); ?>
		</div>

		<!-- <div class="col-sm-2"></div>
		<div class="col-sm-2">
			<input type="hidden" value="1" id="page_value">
			<a href="#" class="btn btn-default " onclick="pagemove(-1);" id="page_down" disabled="true"><span class=" glyphicon glyphicon-chevron-left"></span></a>
			<a href="#" class="btn btn-default " onclick="pagemove(0);" id="show_page">1</a>
			<a href="#" class="btn btn-default " onclick="pagemove(1);" id="page_up"><span class=" glyphicon glyphicon-chevron-right"></span></a>
		</div> -->
	</div>
	<!-- <input type="hidden" id="ns_value" value="0">
	<input type="hidden" id="diom_value" value="0">
	<input type="hidden" id="due_value" value="0">
	<input type="hidden" id="ofd_value" value="0">
	<input type="hidden" id="pne_value" value="0"> -->
	<div class="form-group row">
		<div class="col-md-5">
			<div class=" input-group" style="width:100%">
				<input type="text" id="txtSetStartday" title="開始時間" class="form-control" style="width:40%" onchange="set_start()" placeholder="某日以後開始的合約" value="">
				<a class="btn btn-default form-control" onclick="remove_str_date()" title="清除開始時間限制" style="width:10%"><span class="glyphicon glyphicon-remove"></span></a>
				<input type="text" id="txtSetendday" title="結束時間" class="form-control" style="width:40%" onchange="set_end()" placeholder="某日以前結束的合約" value="">
				<a class="btn btn-default form-control" onclick="remove_end_date()" title="清除結束時間限制" style="width:10%"><span class="glyphicon glyphicon-remove"></span></a>
			</div>

		</div>

		<!-- <div class="col-md-7">
			<div class="btn-group">
				<a href="#" id="btnNS" onclick="ns_select()" class="btn btn-info" title="還沒開始的合約">未開始&nbsp;&nbsp;<span class="badge" id="view_ns">1</span></a>
				<a href="#" id="btnDIOM" onclick="diom_select()" class="btn btn-default" title="遷出日期在一個月內的合約">一個月內遷出&nbsp;&nbsp;<span class="badge" id="view_due_in_one_m">1</span></a>
				<a href="#" id="btnDue" onclick="due_select()" class="btn btn-default" title="這個月份到期的合約(合約結束日期在這個月)">本月到期&nbsp;&nbsp;<span class="badge" id="view_due">1</span></a>
				<a href="#" id="btnOFD" onclick="ofd_select()" class="btn btn-danger" title="已經過期的合約(超過合約結束的日期)">過期&nbsp;&nbsp;<span class="badge" id="view_ofd">1</span></a>
			<a href="#" id="btnPNE" onclick="pne_select()" class="btn btn-warning" title="房租即將(30天內)/已經不足的合約">租金不足&nbsp;&nbsp;<span class="badge" id="view_pne">1</span></a>
			</div>
		</div> -->
	</div>
	<!-- <br> -->
	<!-- <br> -->
	<!-- <hr> -->
			<!-- 搜尋結果 -->

	<div class="table-responsive">
		<table class="table table-hover" style="text-align:center">
				<thead>
					<input type="hidden" id="order_law" value="false"> <?php //0是遞增 1是遞減 ?>
					<input type="hidden" id="order_method" value="0"> <?php // ?>
					<tr id="result_table_head">


					</tr>
					<tr id="result_table_date_head">

					</tr>
				</thead>
				<tbody id="result_table">




				</tbody>
		</table>
	</div>
</div>
</div>
