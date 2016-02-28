
<div class="modal fade " id="rentModal" tabindex="-1" role="dialog" data-show="1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" id="closebtn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">新增額外費用/獎金</h4>
			</div>
			<div class="modal-body">
				<table class="table" style="margin-bottom:0px">
					<input type="hidden" id="contract_id" value="0">
					<tr>
 						<td style="width:15%" align="right">類別</td>
 						<td>
 							<select class="form-control" id="new_rent_type_select">
 								<option value="1">租金</option>
 								<option value="2">額外</option>
 								<option value="3">獎勵</option>
 								<option value="4">其他+</option>
 								<option value="5">其他-</option>
 							</select>
 						</td>
 						
 					</tr>
 					<tr>
 						<td style="width:15%" align="right">金額</td>
 						<td style="width:30%">
 							<input class="form-control"   id="new_rent_value" required="required" style="width:100%" type="text"  >
 						</td>
 						
 					</tr>
 					
 					</tr>
 					<tr>
 						<td style="width:15%" align="right">新增日期</td>
 						<td style="width:30%">
 							<input class="form-control"  id="new_rent_date" required="required" style="width:100%" type="text"  >
 						</td>
 						
 					</tr>
 				
 					<tr>
 						<td style="width:15%" align="right">描述或備註</td>
 						<td colspan="3">
 							<textarea class="form-control" onchange="change_alert()" id="new_rent_description" style="resize: none;"  style="width:100%"  rows="2"></textarea>
 						</td>
 					</tr>
 				</table>
 				
			</div>
			<div class="modal-footer">
				<div class="row" style="width:100%">
					<div class="col-md-2 pull-right">
						
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					<div class="col-md-2 pull-right">
						
						<a href="#" class="btn btn-primary" onclick="submit_new_rent()">送出</a>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade " id="payrentModal" tabindex="-1" role="dialog" data-show="1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" id="closebtn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">新增繳費紀錄</h4>
			</div>
			<div class="modal-body">
				<table class="table" style="margin-bottom:0px">
					<input type="hidden" id="contract_id" value="0">
					<tr>
 						<td style="width:15%" align="right">來源</td>
 						<td>
 							<select class="form-control" id="new_pay_rent_source">
 								<option value="1">匯款</option>
 								<option value="2">支票</option>
 								<option value="3">現金</option>
 							</select>
 						</td>
 						
 					</tr>
 					<tr>
 						<td style="width:15%" align="right">金額</td>
 						<td style="width:30%">
 							<input class="form-control"   id="new_pay_rent_value" required="required" style="width:100%" type="text"  >
 						</td>
 						
 					</tr>
 					<tr>
 						<td style="width:15%" align="right">繳款人</td>
 						<td style="width:30%">
 							<input class="form-control"  id="new_pay_rent_from" required="required" style="width:100%" type="text"  >
 						</td>
 						
 					</tr>
 					<tr>
 						<td style="width:15%" align="right">新增日期</td>
 						<td style="width:30%">
 							<input class="form-control"  id="new_pay_rent_date" required="required" style="width:100%" type="text"  >
 						</td>
 						
 					</tr>
 					<tr>
 						<td style="width:15%" align="right">收據編號</td>
 						<td style="width:30%">
 							<input class="form-control"  id="new_pay_rent_r_id" required="required" style="width:100%" type="text"  >
 						</td>
 					</tr>	
 					<tr>
 						<td style="width:15%" align="right">描述或備註</td>
 						<td colspan="3">
 							<textarea class="form-control" onchange="change_alert()" id="new_pay_rent_description" style="resize: none;"  style="width:100%"  rows="2"></textarea>
 						</td>
 					</tr>
 				</table>
 				
			</div>
			<div class="modal-footer">
				<div class="row" style="width:100%">
					<div class="col-md-2 pull-right">
						
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					<div class="col-md-2 pull-right">
						
						<a href="#" class="btn btn-primary" onclick="submit_new_pay_rent()">送出</a>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->