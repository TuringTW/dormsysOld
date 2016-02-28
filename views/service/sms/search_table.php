<h1 class="page-header">簡訊紀錄</h1>
<!-- 搜尋列 次導覽列 -->
	<div class="form-group">
		<div class="col-sm-5">
			<input type="text" id="txtkeyword"class="form-control" onchange="keyword_serach()" placeholder="Enter電話、內容" value="">
		</div>
		<div class="col-sm-2">
			<a href="#" class="btn btn-default" onclick="sendsms('', '')" >新簡訊</a>
		</div>
		<div class="col-sm-2 pull-right">
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
						<th style="text-align:center; width:5%">#</th>
						<th style="text-align:center; width:20%">電話</th>
						<th style="text-align:center; width:15%">寄送時間</th>
						<th style="text-align:center; width:60%">內容</th>
					</tr>
				</thead>
				<tbody id="result_table" style="text-align:center">

				</tbody>
		</table>
	</div>
</div>
</div>
