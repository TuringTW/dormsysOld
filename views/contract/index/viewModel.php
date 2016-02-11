
<div class="modal fade " id="viewModal" tabindex="-1" role="dialog" data-show="1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width:90%;">
		<div class="modal-content">

				<div class="modal-header">
					<button type="button" id="closebtn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">合約詳細資料</h4>
				</div>
				<div class="modal-body">
					
						<div class="row">
							<div class="col-sm-6">
								<table class="table"  style="margin-bottom:0px">
									<tbody id = "view_stu_info"></tbody>
								</table>
								<table class="table" style="margin-bottom:0px">
									<input type="hidden" id="contract_id" value="0">
									<tr>
			     						<td style="width:15%" align="right">宿舍</td>
			     						<td>
			     							<div class="row">
			     								<div class="col-md-8"><input class="form-control" id="view_dorm" disabled required="required" style="width:100%" type="text" name="new[]" value=""></div>
			     								<div class="col-md-4"><a href="#" id="view_dorm_href" class="btn btn-default" style="width:100%" title="檢視宿舍資訊"><span class="glyphicon glyphicon-tower"></span></a></div>
			     							</div>
			     						</td>
			     						<td style="width:15%" align="right">房號</td>
			     						<td>
			     							<div class="row">
			     								<input type="hidden" id="room_id" value="0">
			     								<div class="col-md-8"><input class="form-control" id="view_room" disabled required="required" style="width:100%" type="text" name="new[]" ></div>
			     								<div class="col-md-4"><a href="#" id="view_room_href" class="btn btn-default" style="width:100%" title="檢視房間資訊"><span class="glyphicon glyphicon-home"></span></a></div>
			     	
			     							</div>
			     						</td>
			     					</tr>



			     					<tr>
			     						<td style="width:15%" align="right">合約開始</td>
			     						<td style="width:30%">
			     							<input class="form-control"  disabled id="view_s_date" required="required" style="width:100%" type="text" name="new[]" >
			     						</td>
			     						<td style="width:15%" align="right">合約結束</td>
			     						<td style="width:30%">
			     							<input class="form-control" disabled  id="view_e_date" required="required" style="width:100%" type="text" name="new[]" >
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:15%" align="right">遷入日期</td>
			     						<td style="width:30%">
			     							<div class="row">
			     								<div class="col-sm-8"><input class="form-control"  onchange="check_room();change_alert();" id="view_in_date" required="required" style="width:100%" type="text" name="new[]" ></div>
			     								<div class="col-sm-4"><span class="glyphicon glyphicon-ok" id="view_in_date_check"></span></div>
			     							</div>
			     							
			     							
			     						</td>
			     						<td style="width:15%" align="right">遷出日期</td>
			     						<td style="width:30%">
			     							<div class="row">
			     								<div class="col-sm-8"><input class="form-control" onchange="check_room();change_alert();"  id="view_out_date" required="required" style="width:100%" type="text" name="new[]" ></div>
			     								<div class="col-sm-4"><span class="glyphicon glyphicon-ok" id="view_out_date_check"></span></div>
			     							</div>
			     							
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:15%" align="right">簽約日期</td>
			     						<td style="width:30%">
			     							<input class="form-control" disabled id="view_c_date" required="required" style="width:100%" type="text" name="new[]" >
			     						</td>
			     						<td style="width:15%"  align="right">每人每月租金</td>
			     						<td style="width:30%">
			     							<input class="form-control" disabled id="view_rent" required="required" style="width:100%" type="text" name="new[]" >
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:15%" align="right">帶看人</td>
			     						<td style="width:30%">
			     							<select class="form-control" onchange="change_alert();" id="view_sales" required="required" style="width:100%" name="new[]">
		     									<option  class="form-control">請選擇...</option>
			     								<?php foreach ($saleslist as $key => $value): ?>
			     									<option  class="form-control" value="<?=$value['m_id']?>" ><?=$value['name']?></option>
			     								<?php endforeach ?>
			     							</select> 
			     						</td>
			     						<td style="width:15%" align="right">簽約管理員</td>
			     						<td style="width:30%">
			     							<input class="form-control " id="view_manager"disabled required="required" style="width:100%" type="text" name="new[]" >
			     						</td>
			     					</tr>
			     					<tr>
			     						<td style="width:15%" align="right">備註</td>
			     						<td colspan="3">
			     							<textarea class="form-control" onchange="change_alert()" id="view_note" style="resize: none;"  style="width:100%" name="new[]" rows="2"></textarea>
			     						</td>
			     					</tr>
			     				</table>
							</div>
							<div class="col-sm-6">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#contract" data-toggle="tab">租金明細</a></li>
									<li><a href="#pay_detail" data-toggle="tab">繳費明細</a></li>
									<li><a href="#deposit" data-toggle="tab">押金紀錄</a></li>
								</ul>
								<div class="tab-content"  style="overflow-y:scroll;overflow-x:hidden;height:450px">
									<div class="tab-pane active" id="contract">
										<br>
										<div class="row">
											<div class="col-sm-4"><a href="#" class="btn btn-default" onclick="$('#rentModal').modal('toggle');">新增額外費用/獎勵</a></div>
											<div class="col-sm-3"><h4>租金總額:</h4></div>
											<div class="col-sm-4"><h4><span id="rent_total">0</span>元</h4></div>
										</div>
										<!-- <hr> -->
										<table class="table">
											<thead>
												<th>#</th>
												<th>類型</th>
												<th>+/-</th>
												<th>費用</th>
												<th>描述</th>
												<th>新增日期</th>
											</thead>
											<tbody id="rent_detail" style="text-align:center"></tbody>
										</table>
									</div>
									<div class="tab-pane" id="pay_detail" >									
										<br>
										<div class="row">
											<div class="col-sm-4"><a href="#" class="btn btn-default" onclick="$('#payrentModal').modal('toggle');">新增繳費紀錄</a></div>
											<div class="col-sm-3"><h4>已繳租金總額:</h4></div>
											<div class="col-sm-4"><h4><span id="pay_rent_total">0</span>元</h4></div>
										</div>
										<!-- <hr> -->
										<table class="table">
											<thead>
												<th>#</th>
												<th>來源</th>
												<th>繳款人</th>
												<th>金額</th>
												<th>收據#</th>
												<th>描述</th>
												<th>入帳日期</th>
											</thead>
											<tbody id="pay_rent_detail" style="text-align:center"></tbody>
										</table>
									</div>
									<div class="tab-pane" id="deposit">									
									
									</div>
								</div>
							</div>
						</div>
						
    					
     				
				</div>
				<div class="modal-footer">
					<div class="row" style="width:100%">
						<div class="col-md-3">
						</div>
						<div class="col-md-3">
							<a id="view_print_btn"  class="btn btn-default btn-lg" onclick="printmodel()">列印</a>
							<a id="edit_btn" href="#" class="btn btn-info btn-lg" onclick="editcontract()">已儲存</a>
						</div>
						<div class="col-md-2 pull-right">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
						
						<div class="col-md-4 pull-right">
							<a id="view_keep_btn"  name="checkoutsubmit" onclick="keep_check()"class="btn btn-success btn-lg keep">續約</a>
							<a id="view_check_out_btn"  name="checkoutsubmit" onclick="checkout_check()" class="btn btn-primary btn-lg checkout">結算</a>
							<a id="view_change_btn"  name="checkoutsubmit" data-cnum="0" class="btn  btn-lg btn-danger">合約更動、取消</a>
						</div> 
    					<div class="col-md-1 pull-right">
							
						</div>
						
						
						
						<div class="col-md-2 pull-right">
							
						</div>
						
						

						
					</div>
					
				</div>

		</div><!-- /.modal-content -->
		
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->