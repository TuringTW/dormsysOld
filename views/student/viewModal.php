<div id="editon" class="navbar-form navbar-right" role="new">
	<button  class="btn btn-default" data-toggle="modal" data-target="#viewModal" style="display: none;">
	  新增房客
	</button>
	
</div>	
	<div class="modal fade " id="viewModal" tabindex="-1" role="dialog" data-show="1" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">學生詳細資料</h4>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#profile" data-toggle="tab">學生資料</a></li>
						<li><a href="#contract" data-toggle="tab">合約記錄</a></li>
						
					</ul>
					<div class="tab-content">
						
						<div class="tab-pane active" id="profile">
							<div class="row">
								<div class="col-sm-6">
									<table class="table">
										<tr>
				     						<td style="width:25%" align="right">*姓名</td>
				     						<td><input class="form-control" id="view_name" required="required" style="width:100%" type="text" onclick="showedit()" value=""></td>
				     					</tr>
				     					<tr>
				     						<td style="width:25%" align="right">學校單位</td>
				     						<td>
				     							<input class="form-control" id="view_school"  style="width:100%" type="text" onclick="showedit()" value="">
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:25%" align="right">*身分證字號</td>
				     						<td>
				     							<input class="form-control"  id="view_id_num" required="required"  style="width:100%" type="text" onclick="showedit()" value="">

				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:25%" align="right">*生日</td>
				     						<td>
				     							<input class="form-control" id="dpBirthday" required="required"  style="width:100%" type="text" onclick="showedit()" value="">

				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:25%" align="right">*戶籍地址</td>
				     						<td>
				     							<input class="form-control"  id="view_reg_address" required="required"  style="width:100%" type="text" onclick="showedit()" value="">

				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:25%" align="right">*通訊地址</td>
				     						<td>
				     							<input class="form-control"  id="view_mailing_address" required="required"  style="width:100%" type="text" onclick="showedit()" value="">

				     						</td>
				     					</tr>
									</table>
								</div>
								<div class="col-sm-6">
									<table class="table">
										<tr>
				     						<td style="width:30%" align="right">*手機</td>
				     						<td style="width:70%">
				     							<div class="row" style="width:100%">
				     								<div class="col-sm-10">
				     									<input class="form-control" id="view_mobile"required="required" style="width:100%" type="text" onclick="showedit()" value="">
				     								</div>
				     								<div class="col-sm-2">
				     									<a href="#" id="view_sms" class="btn btn-default" title="寄簡訊到這支手機">
				     										<span class="glyphicon glyphicon-comment"></span>
				     									</a>
				     								</div>
				     							</div>
				     							
				     							
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:30%" align="right">家電</td>
				     						<td>
				     							<input class="form-control" id="view_home" style="width:100%" type="text" onclick="showedit()" value="">
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:30%" align="right">E-mail</td>
				     						<td>
				     							<input class="form-control" id="view_email"  style="width:100%" type="text" onclick="showedit()" value="">
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:30%" align="right">*緊急連絡人</td>
				     						<td>
				     							<input class="form-control" id="view_emg_name" required="required"  style="width:100%" type="text" onclick="showedit()" value="">

				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:30%" align="right">*緊急連絡人電話</td>
				     						<td>
				     							<input class="form-control" id="view_emg_phone" required="required"  style="width:100%" type="text" onclick="showedit()" value="">

				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:30%" align="right">備註</td>
				     						<td>
				     							<textarea class="form-control" id="view_note"  style="width:100%"  onclick="showedit()" value=""></textarea>

				     						</td>
				     					</tr>
									</table>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="contract">	
							<table class="table table-hover">
								<thead>
									<th>#</th>
									<th>狀態</th>
									<th>宿舍</th>
									<th>房號</th>
									<th>開始日期</th>
									<th>結束日期</th>
									<th>遷入日期</th>
									<th>遷出日期</th>
									<th>合約資料</th>
								</thead>
								<tbody id="view_contract_list"></tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="stu_id" onclick="showedit()" value="0">
					<button type="submit" name="editstuinfosubmit" id="btnSubmit" onclick="editstuinfo()" class="btn btn-info">已儲存</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				
				</div>
			</div><!-- /.modal-content -->
			
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->