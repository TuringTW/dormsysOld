<h1 class="page-header">房間資料</h1>
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

		<div class="col-md-3" style="height:100%;">

			<div class="btn-group" role="group" aria-label="..." style=" width:100%">
				<a href="#" id="show_type_btn_0" class="btn btn-default show_type_btn" style="width:50%" disabled>房間</a>
				<a href="#" id="show_type_btn_1" class="btn btn-default show_type_btn" onclick="add_new_room()" style="width:50%">新增</a>
			</div>
			<hr>
			<div class="btn-group-vertical well" style="height:100%;width:100%;overflow-y:scroll;overflow-x:hidden" role="group" aria-label="..." id="room_select">

			</div>
		</div>

		<div class="col-md-6" style="height:100%;">
			<div class="btn-group" role="group" aria-label="..." style=" width:100%">
				<a class="btn btn-default show_type_btn" id="tab_rentinfo" href="#rentinfo" role="tab" data-toggle="tab" style="width:33%">租屋資料</a>
				<a class="btn btn-default show_type_btn" id="tab_feature" href="#feature" role="tab" data-toggle="tab" onclick="" style="width:33%">房間特色</a>
				<a class="btn btn-default show_type_btn" id="tab_contract" href="#contract" role="tab" data-toggle="tab" onclick="" style="width:34%">合約紀錄</a>
			</div>
			<hr>
			<div class="btn-group-vertical well tab-content" style="height:100%;width:100%;overflow-y:scroll;overflow-x:hidden" role="group" aria-label="..." id="stu_select">
				<div class="tab-pane active row" id="rentinfo">
					<div class="col-sm-8">
						<h4>租屋資料 <span id="new_option" style="display:none">(新增房間)</span>	</h4>
						<input type="hidden" id="room_id" value="0">
						<table class="table table-hover">
	     					<tr>
	     						<td style="width:15%" align="right">房號</td>
	     						<td><input id="room_name" placeholder="請設一個簡短好記的" class="form-control" required="required" style="width:100%" type="text" value=""></td>
	     					
	     						</td>
	     					</tr>
	     					<tr>	
	     						<td style="width:15%" align="right">類型</td>
	     						<td>
	     							<select class="form-control" id="type_select" required="required" style="width:100%" type="text" name="new[]" onchange="autofill();">							
	     								<option class="form-control"   value="雅房">雅房</option>
	     								<option class="form-control"   value="套房">套房</option>
	     								<option class="form-control"   value="公寓">公寓</option>
	     								<option class="form-control"   value="透天">透天</option>
	     							</select>
	     						</td>
	     						

	     					</tr>
	     					<tr>
	     						<td style="width:15%" align="right">房租</td>
	     						<td><input id="rent" class="form-control" placeholder="每人每月房租" required="required" style="width:100%" type="text" value=""></td>
	     					
	     						</td>
	     					</tr>
	     					<tr>	
	     						<td style="width:15%" align="right">描述備註</td>
	     				
	     						
	     						<td><textarea id="note" class="form-control" style="resize: none;height:120px"  style="width:100%" name="new[]" row="10"></textarea></td>
	     					</tr>
						</table>
						<table class="">
							<tr>
								<td style="width:10%" align="right"><a class="btn btn-danger" onclick="" disabled>刪除</a></td>
								<td style="width:10%" align="right"><a class="btn btn-default" onclick="edit_room_info()">儲存</a></td>
	     					</tr>
	     					
						</table>
					</div>
					
						

				</div>
				<div class="tab-pane" id="feature"></div>
				<div class="tab-pane" id="contract"></div>
			</div>
			<input type="hidden" id="stu_select_id" value="0">
		</div>

		<!-- <div class="col-md-4" style="height:100%;">
			<a href="#" class="btn btn-default" style="width:100%" disabled>學生資料</a>
			<hr>
			<div class=" well" style="height:100%;width:100%" role="group" aria-label="...">
				<div class="btn-group-vertical" style=";width:100%"id="stu_info"></div>
				
			</div>
		</div> -->
	</div>
	
</div>
</div>

