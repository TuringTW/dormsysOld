<h1 class="page-header">學生通訊錄</h1>
<!-- 搜尋列 次導覽列 -->
<!-- 	<div class="form-group">
		<div class="col-sm-3">
			<input type="text" id="txtkeyword"class="form-control" onchange="keyword_serach()" placeholder="Enter搜:宿舍、房號、姓名、手機" value="">
		</div>
	</div>	
	<br>
	<br>
	<hr> -->
			<!-- 搜尋結果 -->
	<div class="row" style="height:450px; ">
		<div class="col-md-3 " style="height:100%;">
			<a href="#" class="btn btn-default" style="width:100%" disabled>宿舍</a>
			<input type="hidden" id="dorm_select_id" value="0">
			<hr>
			<div class="btn-group-vertical well" style="height:100%;width:100%;overflow-y:scroll;overflow-x:hidden" role="group" aria-label="..." id="dorm_select">
				<?=dorm_button_btnlist($dormlist)?>
			</div>
		</div>

		<div class="col-md-2" style="height:100%;">

			<div class="btn-group" role="group" aria-label="..." style=" width:100%">
				<a href="#" id="show_type_btn_0" class="btn btn-default show_type_btn active" onclick="select_stu_room(0)" style="width:50%">現在房客</a>
				<a href="#" id="show_type_btn_1" class="btn btn-default show_type_btn" onclick="select_stu_room(1)" style="width:50%">房間</a>
			</div>
			<input type="hidden" id="show_type_select" value="0">
			<hr>
			<div class="btn-group-vertical well" style="height:100%;width:100%;overflow-y:scroll;overflow-x:hidden" role="group" aria-label="..." id="room_stu_select">

			</div>
			<input type="hidden" id="room_stu_select_id" value="0">
		</div>

		<div class="col-md-3" style="height:100%;">
			<input type="text" placeholder="學生&nbsp;&nbsp;[遷入日期]&nbsp;&nbsp;Enter搜:手機,姓名" id="keyowrd_input"onchange="searchstu()" class="form-control" style="width:100%">
			<hr>
			<div class="btn-group-vertical well" style="height:100%;width:100%;overflow-y:scroll;overflow-x:hidden" role="group" aria-label="..." id="stu_select">

			</div>
			<input type="hidden" id="stu_select_id" value="0">
		</div>

		<div class="col-md-4" style="height:100%;">
			<a href="#" class="btn btn-default" style="width:100%" disabled>學生資料</a>
			<hr>
			<div class=" well" style="height:100%;width:100%" role="group" aria-label="...">
				<div class="btn-group-vertical" style=";width:100%"id="stu_info"></div>
				
			</div>
		</div>
	</div>
	
</div>
</div>

