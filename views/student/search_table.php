<!--item李dorm id 有 0 表示其他 在sql query前需攔截 -->
<h1 class="page-header">學生資料</h1>
<!-- 搜尋列 次導覽列 -->
	<div class="form-group">
		<div class="col-sm-3">
			<input type="text" id="txtkeyword"class="form-control" onchange="keyword_serach()" placeholder="Enter搜:姓名、手機" value="">
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
					<th>單位</th>
					<th>手機</th>
					<th>家電</th>
					<th>緊急聯絡人</th>
					<th>緊急聯絡電話</th>
					<th style="width:5%">詳細</th>
				</tr>
			</thead>
			<tbody id="result_table">
				
			</tbody>
		</table>
	</div>
</div>
</div>
<input type="hidden" value="<?=$stu_id?>" id="open_stu_id">
