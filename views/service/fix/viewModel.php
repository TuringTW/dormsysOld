
<div class="modal fade " id="viewModal" tabindex="-1" role="dialog" data-show="1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:60%">
		<div class="modal-content">

				<div class="modal-header">
					<button type="button" id="closebtn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">報修內容</h4>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs" role="tablist">
						<li class="active "><a id="tab_stuinfo" href="#fix_detail" role="tab" data-toggle="tab">報修內容</a></li>
						<li><a id="tab_contract" href="#solution" role="tab" data-toggle="tab">處理方式</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane " id="fix_detail">
							<div class="row">

								<div class="col-md-5">
									<table class="table table-hover">
										<tr>
				     						<td style="width:25%" align="right">宿舍</td>
				     						<td>
				     							<input disabled id="view_dorm" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text">
				     						</td>
				     					</tr>
					     				<tr>
				     						<td style="width:25%" align="right">報修地點</td>
				     						<td>
												<input disabled id="view_room" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text">
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:20%" align="right">報修時間</td>
				     						<td>
				     							<input disabled class="form-control" onchange="change_alert()" id="view_timestamp" required="required" style="width:100%" type="text"  >
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:25%" align="right">報修項目</td>
				     						<td>
												<input disabled id="view_fix_item" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text">
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:25%" align="right">問題描述</td>
				     						<td>
			     								<textarea disabled class="form-control" onchange="change_alert()" id="view_detail" style="resize: none;"  style="width:100%" name="new[]" rows="5"></textarea>
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:25%" align="right">陪同否</td>
				     						<td>
												<input disabled id="view_is_allow" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text">
				     						</td>
				     					</tr>
				     					
				     					
									</table>
								</div>
								<div class="col-sm-7">
									<h5>聯絡資料</h5>
									<table class="table">
										<tr>
											<th style="width:15%" align="right">報修人</th>
				     						<td>
												<input disabled id="view_sname" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text">
				     						</td>
				     						<th style="width:15%" align="right">電話</th>
				     						<td>
												<input disabled id="view_mobile" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text">
				     						</td>
				     						<td>
												<a onclick="" class="btn btn-default" title="寄簡訊" id="view_sms"><span class="glyphicon glyphicon-comment"></span></a>
				     						</td>
										</tr>
									</table>	
									<h5>照片</h5>
									<hr>
								</div>
							</div>
							
	    					<input type="hidden" id="view_fr_id" value="0">
						</div>
						<div class="tab-pane active " id="solution">
							<div class="row">
								<div class="col-sm-7">
									<h4>處理方式</h4>
									<hr>
									<div class="btn-group">
										<a href="#" class="btn btn-default">新增處理方式</a>
									</div>
									
									<a href="#" class="btn btn-danger" >標示為處理完成</a>
									<hr>
									<table class="table table-hover">
										<thead>
											<th style="width:5%">#</th>
											<th>類別</th>
											<th>處理方式</th>
											<th>材料費</th>
											<th>工資</th>
											<th>查看</th>
											<th>刪除</th>
										</thead>
										<tbody id="solution_list">

										</tbody>
									</table>
								</div>
								<div class="col-sm-5">
									<h4><span id="view_new_solution_lbl">新</span>處理方式細節</h4>
									<table class="table table-hover">
										<tr>
											<td style="width:25%">類別</td>
											<td>
												<select class="form-control" onchange="change_alert();" id="view_sales" required="required" style="width:100%" name="new[]">
			     									<option  class="form-control">請選擇...</option>
				     								<?php foreach ($saleslist as $key => $value): ?>
				     									<option  class="form-control" value="<?=$value['m_id']?>" ><?=$value['name']?></option>
				     								<?php endforeach ?>
				     							</select> 
											</td>
										</tr>
										<tr>
											<td style="width:25%">套用模板</td>
											<td>
												<select class="form-control" onchange="change_alert();" id="view_sales" required="required" style="width:100%" name="new[]">
			     									<option  class="form-control">請選擇...</option>
				     								<?php foreach ($saleslist as $key => $value): ?>
				     									<option  class="form-control" value="<?=$value['m_id']?>" ><?=$value['name']?></option>
				     								<?php endforeach ?>
				     							</select> 
											</td>
										</tr>
										<tr><td>&nbsp;</td><td></td></tr>
										
										<tr>
											<td style="width:25%">處理方式</td>
											<td><input id="view_mobile" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text"></td>
										</tr>
										<tr>
											<td style="width:25%">材料費</td>
											<td><input id="view_mobile" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text"></td>
										</tr>
										<tr>
											<td style="width:25%">工資</td>
											<td><input id="view_mobile" onchange="change_alert()" class="form-control" required="required" style="width:100%" type="text"></td>
										</tr>
										
									</table>
									<hr>
									<a href="#" class="btn btn-warning">儲存</a>
									<a href="#" class="btn btn-default">新增為模板</a>
								</div>
							</div>
						</div>
					</div>     				
				</div>
				<div class="modal-footer">
					<div class="row" style="width:100%">
						<div class="col-md-1 pull-right">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->