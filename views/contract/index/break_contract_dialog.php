<div id="dialog-breakcontracr" title="違約設定">
	<form>
		<label>學生名單</label>
		<div style="width:100%">
			<table class="table table-hover">
				<thead>
					<th>姓名</th>
					<th>手機</th>
					<th>身分證字號</th>
				</thead>
				<tbody id="break_stu_info">

				</tbody>
			</table>
		</div>
		<hr>
		<label>原合約</label>
		<div style="width:100%">
			<table class="table table-hover">
				<thead>
					<th>宿舍</th>
					<th>房號</th>
					<th>人數</th>
					<th>合約開始日期</th>
					<th>合約結束日期</th>
				</thead>
				<tbody id="break_contract_info">
					
				</tbody>
			</table>
		</div>
		<hr>
		<table class="table">
			<tr>
				<td style="width:40%"><label for="bdate">更改合約終止日期</label></td>
				<td style="width:20%"><input type="text" name="bdate" id="bdate" value="<?=date('Y-m-d')?>" class="text ui-widget-content ui-corner-all"></td>
				<td style="width:40%"><span id="bstate"></span></td>
			</tr>
		</table>
		<input type="hidden" id="bcontract_id" name="bcontract_id" value="0">
	</form>
</div>

<div id="dialog-update-failed" title="違約設定狀態">
	<p><span class="glyphicon glyphicon-remove"></span>失敗!!!請在試一次</p>
</div>
<div id="dialog-update-done" title="違約設定狀態">
	<div class="alert alert-success"><h2><span class="glyphicon glyphicon-ok"></span>成功!!!<span id="bkeepalert"></span></h2></div>
	<div class="alert alert-warning"><h2><span class="glyphicon glyphicon-star-empty">注意!!!系統不會自動到期結算!!!<br>還是要完成結算的步驟</h2></div>
	<input type="hidden" id="keep_bcontract_id" name="bcontract_id" value="0">
	<input type="hidden" id="bcontract_id" name="bcontract_id" value="0">
	<input type="hidden" id="keep_b_date" name="b_date" value="0">
</div>