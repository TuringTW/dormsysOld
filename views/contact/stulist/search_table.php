<h1 class="page-header">學生通訊錄</h1>
<!-- 搜尋列 次導覽列 -->
	<!-- <div class="form-group">
		<div class="col-sm-3">
			<input type="text" id="txtkeyword"class="form-control" onchange="keyword_serach()" placeholder="Enter搜:宿舍、房號、姓名、手機" value="">
		</div>
	</div>	
	<br>
	<br>
	<hr> -->
			<!-- 搜尋結果 -->
	<div class="row" style="height:400px; ">
		<div class="col-md-3 " style="height:100%;">
			<a href="#" class="btn btn-default" style="width:100%" disabled>宿舍</a>
			<input type="hidden" id="dorm_select_id" value="0">
			<hr>
			<div class="btn-group-vertical well" style="height:100%;width:100%;overflow-y:scroll;overflow-x:hidden" role="group" aria-label="..." id="dorm_select">
				<?=dorm_button_btnlist($dormlist)?>
			</div>
		</div>

		<div class="col-md-3" style="height:100%;">

			<div class="btn-group" role="group" aria-label="..." style=" width:100%">
				<a href="#" class="btn btn-default active" style="width:50%">現在房客</a>
				<a href="#" class="btn btn-default" style="width:50%">房間</a>
			</div>
			<input type="hidden" id="show_type_select" value="0">
			<hr>
			<div class="well" style="height:100%;width:100%;" role="group" aria-label="...">	
				<div class="btn-group-vertical" style="height:100%;width:100%;overflow-y:scroll;overflow-x:hidden" role="group" aria-label="..." id="room_stu_select">

				</div>
			</div>
			<input type="hidden" id="room_stu_select_id" value="0">
		</div>

		<div class="col-md-2" style="height:100%;">
			<a href="#" class="btn btn-default" style="width:100%" disabled>學生</a>
			<hr>
			<div class="btn-group-vertical well" style="height:100%;width:100%;overflow-y:scroll;overflow-x:hidden" role="group" aria-label="..." id="stu_select">

			</div>
			<input type="hidden" id="stu_select_id" value="0">
		</div>

		<div class="col-md-4" style="height:100%;">
			<a href="#" class="btn btn-default" style="width:100%" disabled>學生資料</a>
			<hr>
			<div class="btn-group-vertical well" style="height:100%;width:100%" role="group" aria-label="..." id="stu_info">

			</div>
		</div>
	</div>
	
</div>
</div>

