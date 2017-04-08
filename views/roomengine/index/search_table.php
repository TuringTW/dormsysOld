<h1 class="page-header">房間搜尋</h1>
<!-- 搜尋列 次導覽列 -->
	<div class="form-group row">
		<label class="col-sm-1 control-label">宿舍</label>
		<div class="col-md-4">

			<div class="btn-group" style="width:75%">
				<?php echo dorm_list_html($dormlist); ?>
			</div>
		</div>

		<label class="col-sm-1 control-label">日期</label>
		<div class="col-sm-2">
			<input class="form-control" type="text" id="str_date" id="strdate" placeholder="開始日期" onchange="date_refresh(0);table_refresh()" style="width:100" value="">
		</div>
		<div class="col-sm-2">
			<input class="form-control" type="text" id="end_date" id="enddate" placeholder="結束日期" onchange="date_refresh(1);table_refresh()" style="width:100" value="">
		</div>



	</div>

	<div class="form-group row">

		<div class="form-inline">
			<label class="col-sm-1 control-label">價格</label>
			<div class="form-inline col-sm-2">
				<input class="form-control" type="text" id="lprice" placeholder="價格下限" onchange="table_refresh()" style="width:100%" value="0">
			</div>
			<div class="form-inline col-sm-2">
				<input class="form-control" type="text" id="hprice" placeholder="價格上線" onchange="table_refresh()" style="width:100%" value="50000">
			</div>
<!-- 			<label for="inputPassword3" class="col-sm-1 control-label">日期快捷</label>
			<div class="col-sm-4">
				<a href="#" class="btn btn-sm btn-default" onclick="syearchange(,0)">學年度</a>
				<a href="#" class="btn btn-sm btn-default" onclick="syearchange(,0)">學年度</a>
				<a href="#" class="btn btn-sm btn-default" onclick="syearchange(,1)">年暑假</a>
			</div> -->

		</div>
	</div>
<!-- 	<div class="form-group row">

		<div class="form-inline">

			<label for="inputPassword3" class="col-sm-1 control-label">類型</label>
			<div class="btn-group col-sm-4">
				<a  class="btn btn-default active" style="font-weight: bold;">全部</a>
				<a  class="btn btn-default">雅房</a>
				<a  class="btn btn-default">套房</a>
				<a  class="btn btn-default">公寓</a>
				<a  class="btn btn-default">透天</a>
			</div>
			<input type="hidden" id="room_type_value" value="0">
		</div>
	</div> -->

	<hr>
			<!-- 搜尋結果 -->

	<div class="table-responsive">
		<table class="table table-hover" style="text-align:center">
			<input type="hidden" id="order_law" value="false"> <?php //0是遞增 1是遞減 ?>
			<input type="hidden" id="order_method" value="0"> <?php // ?>
				<thead style="text-align:center;">
					<tr>

						<th style="width:5%"><a href="#" title="依預設方式排列" onclick="table_order(0)">#</a></th>
						<th><a href="#" title="依照'宿舍'遞增/遞減排列" onclick="table_order(1)">宿舍<span  class="order_marker" id="order_marker_1" style="display:none;"></span></a></th>
						<th><a href="#" title="依照'房號'遞增/遞減排列" onclick="table_order(2)">房號<span  class="order_marker" id="order_marker_2" style="display:none;"></span></a></th>
						<th><a href="#" title="依照'類型'遞增/遞減排列" onclick="table_order(3)">類型<span  class="order_marker" id="order_marker_3" style="display:none;"></span></a></th>
						<th><a href="#" title="依照'前合約遷出'遞增/遞減排列" onclick="table_order(4)">前合約遷出<span  class="order_marker" id="order_marker_4" style="display:none;"></span></a></th>
						<th style="width:7%"><a href="#" title="依照'前合約天數'遞增/遞減排列" onclick="table_order(5)">天數<span  class="order_marker" id="order_marker_5" style="display:none;"></span></a></th>
						<th style="width:7%">前合約</th>
						<th><a href="#" title="依照'後合約遷入'遞增/遞減排列" onclick="table_order(7)">後合約遷入<span  class="order_marker" id="order_marker_7" style="display:none;"></span></a></th>
						<th style="width:7%"><a href="#" title="依照'後合約天數'遞增/遞減排列" onclick="table_order(8)">天數<span  class="order_marker" id="order_marker_8" style="display:none;"></span></a></th>
						<th style="width:7%">後合約</th>
						<th><a href="#" title="依照'租金'遞增/遞減排列" onclick="table_order(10)">租金<span class="order_marker" id="order_marker_10" style="display:none;"></span></a></th>
						<th style="width:5%">詳細</th>
					</tr>
				</thead>
				<tbody id="result_table">




				</tbody>
		</table>
	</div>
</div>
</div>
