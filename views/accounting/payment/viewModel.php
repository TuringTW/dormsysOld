
<div class="modal fade " id="viewModal" tabindex="-1" role="dialog" data-show="1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:60%">
		<div class="modal-content">

				<div class="modal-header">
					<button type="button" id="closebtn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">支出資料</h4>
				</div>
				<div class="modal-body">

						<div class="row">
							<div class="col-sm-5">
								<table class="table table-hover">
									<tr>
			     						<td style="width:40%" align="right">*收據類型</td>
			     						<td>
			     							<select id="view_rtype" onchange="change_alert()"class="form-control" required="required" style="width:100%" type="text">
			     								<option class="form-control" value="1">發票</option>
			     								<option class="form-control" value="2">費用</option>
			     								<option class="form-control" value="3">估價單</option>
			     							</select>
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:40%" align="right">*支出名稱</td>
			     						<td>
			     							<input id="view_item" placeholder="請輸入支出名稱" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text" >
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:40%" align="right">*類別</td>
			     						<td>
			     							<select id="view_type" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text">
			     								<?php echo type_list_select($typelist); ?>
			     							</select>
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:40%" align="right">操作人員</td>
			     						<td>
			     							<select disabled id="view_manager" class="form-control" required="required" style="width:100%" type="text">
			     								<?php foreach ($manager as $key => $value): ?>
			     									<option value="<?=$value['m_id']?>"><?=$value['name']?></option>
			     								<?php endforeach ?>
			     							</select>
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:40%" align="right">備註</td>
			     						<td>
			     							<textarea id="view_note" onchange="change_alert()" class="form-control" style="resize: none;"  style="width:100%"row="10"></textarea>

			     						</td>
			     					</tr>
			     				</table>
							</div>
							<div class="col-md-7">
								<table class="table table-hover">
									<tr>
			     						<td style="width:20%" align="right">*請款單位</td>
			     						<td>
			     							<input id="view_company" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text">
			     						</td>
			     					</tr>
				     				<tr>
			     						<td style="width:20%" align="right">*廠商請款</td>
			     						<td>
											<input id="view_money" onchange="change_alert()" class="form-control" placeholder="廠商請款金額" required="required" style="width:100%" type="text">
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:20%" align="right">*房東請款</td>
			     						<td>
			     							<div class="row">
												<div class="col-xs-4">
													<label class="radio-inline"><input onchange="change_alert()" name="isrequest"required="required" class="" type="radio" value="1" >服務費+廠商</label>
												</div>
												<div class="col-xs-3">
													<label class="radio-inline"><input onchange="change_alert()" name="isrequest"required="required" class="" type="radio" value="2" >服務費</label>
												</div>
												<div class="col-xs-3">
													<label class="radio-inline"><input onchange="change_alert()" name="isrequest"required="required" class="" type="radio" value="3" >廠商</label>
												</div>
												<div class="col-xs-2">
													<label class="radio-inline"><input onchange="change_alert()" name="isrequest"required="required" class="" type="radio" value="0" >否</label>
												</div>
											</div>
			     						</td>
			     					</tr>
			     					<tr>
			     						<td></td>
			     						<td>
			     							<div class="row">
												<div class="col-xs-3">
													<label>*服務費</label>
												</div>
												<div class="col-xs-9">
													<input class="form-control" onchange="change_alert()" id="view_billing" placeholder="好家在服務費"  style="width:100%" type="text">
												</div>
											</div>
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:20%" align="right">*請款時間</td>
			     						<td>
			     							<input class="form-control" onchange="change_alert()" id="view_date" required="required" style="width:100%" type="text"  >
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:20%" align="right">*使用宿舍</td>
			     						<td>
			     							<select id="view_dorm" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text" >
			     								<option class="form-control" value="">請選擇宿舍...</option>
			     								<option class="form-control"  value="33">管理中心</option>
			     								<option class="form-control"  value="34">其他</option>
			     								<option class="form-control" value="" disabled>---宿舍---</option>
			     								<?php foreach ($dormlist as  $dorm) { ?>
			     									<?php if ($dorm['dorm_id']!=33&&$dorm['dorm_id']!=34): ?>
			     										<option class="form-control" value="<?=$dorm['dorm_id']?>"><?=$dorm['name']?></option>
			     									<?php endif ?>
			     								<?php } ?>
			     							</select>
			     						</td>
			     					</tr>

								</table>
							</div>

						</div>

    					<input type="hidden" id="view_item_id" value="0">

				</div>
				<div class="modal-footer">
					<div class="row" style="width:100%">
						<div class="col-md-3">
						</div>

						<div class="col-md-1 pull-right">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
						<div class="col-md-1 pull-right">

							<a id="edit_btn" href="#" class="btn btn-info" onclick="edititem()">儲存</a>
						</div>


						<div class="col-md-2 pull-right">

						</div>




					</div>

				</div>

		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
