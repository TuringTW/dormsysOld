
<div class="modal fade " id="viewModalforRes" tabindex="-1" role="dialog" data-show="1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width:75%;">
		<div class="modal-content">

				<div class="modal-header">
					<button type="button" id="closebtnforRes" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabelforRes">預定單詳細資料</h4>
				</div>
				<div class="modal-body">

						<div class="row">
							<div class="col-sm-8">
								<table class="table"  style="margin-bottom:0px">
									<tbody>
										<tr>
												<td style="width:15%" align="right" >立約人</td>
												<td>
													<div class="row">
														<div class="col-md-5"><input class="form-control" id="view_snameforRes"  required="required" style="width:100%" type="text" name="stu[]" value=""></div>
														<div class="col-md-5"><input class="form-control" id="view_mobileforRes"  required="required" style="width:100%" type="text" name="stu[]" value=""></div>
														<div class="col-md-2"><a title="寄簡訊" id="view_smsforRes" class="btn btn-default" style="width:100%"><span class="glyphicon glyphicon-comment"></span></a></div>
													</div>
												</td>
										</tr>

									</tbody>
								</table>
								<table class="table" style="margin-bottom:0px">
									<input type="hidden" id="r_idforRes" value="0">

									<tr>
			     						<td style="width:15%" align="right">宿舍</td>
			     						<td>
			     							<div class="row">
			     								<div class="col-md-8"><input class="form-control" id="view_dormforRes" disabled required="required" style="width:100%" type="text" name="new[]" value=""></div>
			     								<div class="col-md-4"><a href="#" id="view_dorm_hrefforRes" class="btn btn-default" style="width:100%" title="檢視宿舍資訊"><span class="glyphicon glyphicon-tower"></span></a></div>
			     							</div>
			     						</td>
			     						<td style="width:15%" align="right">房號</td>
			     						<td>
			     							<div class="row">
			     								<input type="hidden" id="room_idforRes" value="0">
			     								<div class="col-md-8"><input class="form-control" id="view_roomforRes" disabled required="required" style="width:100%" type="text" name="new[]" ></div>
			     								<div class="col-md-4"><a href="#" id="view_room_hrefforRes" class="btn btn-default" style="width:100%" title="檢視房間資訊"><span class="glyphicon glyphicon-home"></span></a></div>
			     							</div>
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:15%" align="right">下訂日期</td>
			     						<td style="width:30%">
			     							<input class="form-control"  disabled id="view_timestampforRes" required="required" style="width:100%" type="text" name="new[]" >
			     						</td>
			     						<td style="width:15%" align="right">有效期限</td>
			     						<td style="width:30%">
			     							<input class="form-control"  id="view_d_dateforRes" required="required" style="width:100%" type="text" name="new[]" >
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:15%" align="right">開始時間</td>
			     						<td style="width:30%">
			     							<div class="row">
			     								<div class="col-sm-8"><input class="form-control"  onchange="check_room();change_alert();" id="view_s_dateforRes" required="required" style="width:100%" type="text" name="new[]" ></div>
			     								<div class="col-sm-4"><span class="glyphicon glyphicon-ok" id="view_s_date_checkforRes"></span></div>
			     							</div>


			     						</td>
			     						<td style="width:15%" align="right">結束時間</td>
			     						<td style="width:30%">
			     							<div class="row">
			     								<div class="col-sm-8"><input class="form-control" onchange="check_room();change_alert();"  id="view_e_dateforRes" required="required" style="width:100%" type="text" name="new[]" ></div>
			     								<div class="col-sm-4"><span class="glyphicon glyphicon-ok" id="view_e_date_checkforRes"></span></div>
			     							</div>

			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:15%" align="right">帶看人</td>
			     						<td style="width:30%">
			     							<select class="form-control" onchange="change_alert();" id="view_salesforRes" required="required" style="width:100%" name="new[]">
		     									<option  class="form-control">請選擇...</option>
			     								<?php foreach ($saleslist as $key => $value): ?>
			     									<option  class="form-control" value="<?=$value['m_id']?>" ><?=$value['name']?></option>
			     								<?php endforeach ?>
			     							</select>
			     						</td>
			     						<td style="width:15%" align="right">訂單管理員</td>
			     						<td style="width:30%">
			     							<input class="form-control " id="view_managerforRes"disabled required="required" style="width:100%" type="text" name="new[]" >
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:15%" align="right">備註</td>
			     						<td colspan="3">
			     							<textarea class="form-control" onchange="change_alert()" id="view_noteforRes" style="resize: none;"  style="width:100%" name="new[]" rows="2"></textarea>
			     						</td>
			     					</tr>
			     				</table>
							</div>
							<div class="col-sm-4">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#status" data-toggle="tab">預訂單狀態</a></li>
								</ul>
								<div class="tab-content"  style="overflow-y:auto;overflow-x:hidden;">
									<div class="tab-pane active" id="statusforRes">
										<h3>訂金</h3>
										<table class="table">
											<tr>
												<th>金額</th>
												<th>入帳日期</th>
											</tr>
										</table>
										<div class="" style="display:none">
											<h3>押金</h3>
											<table class="table">
												<tr>
													<th>金額</th>
													<th>入帳日期</th>
												</tr>
											</table>
										</div>
										</div>

									</div>
							</div>
						</div>



				</div>
				<div class="modal-footer">
					<div class="row" style="width:100%">
						<div class="col-md-2">
						</div>
						<div class="col-md-3">
							<a id="view_print_btnforRes"  class="btn btn-default btn-lg" onclick="printmodel()">列印</a>
							<a  href="#" id="edit_btnforRes" class="btn btn-info btn-lg" onclick="editcontract();">已儲存</a>
						</div>
						<div class="col-md-2 pull-right">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>

						<div class="col-md-5 pull-right">
							<a id="view_sign_btnforRes"  name="checkoutsubmit" title="簽約，把押金訂金移到合約裡，並封存這筆訂單(還是會有紀錄但不會出現在表上)" onclick="bind_contract()"class="btn btn-success btn-lg keep">簽約</a>
							<a id="view_confiscate_btnforRes"  name="checkoutsubmit" title="沒收押金，封存這筆訂單(還是會有紀錄但不會出現在表上)" onclick="checkout_check()" class="btn btn-warning btn-lg checkout">沒收訂金</a>
							<a id="view_change_btnforRes"  name="checkoutsubmit" data-cnum="0" title="手滑打錯要刪除"class="btn  btn-lg btn-danger">刪除</a>
						</div>
  					<div class="col-md-3 pull-right">
						</div>
					</div>
				</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
