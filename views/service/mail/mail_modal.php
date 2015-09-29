<div class="modal fade " id="newmailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">新增信件</h4>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs">
							<li class="active"><a href="#student" data-toggle="tab">學生信件</a></li>
							<li><a href="#nstudent" data-toggle="tab">非學生信件</a></li>
							
						</ul>
						<div class="tab-content">
							
							<div class="tab-pane active" id="student">
									<table class="table table-hover">
				     					<tr>
											<td style="width:15%" align="right">搜尋姓名</td>
				     						<td>
												<input id="searchname" class="form-control" placeholder="請輸入姓名或手機搜尋，結果會出現在下一行"  style="width:100%" onChange="stu_suggestion_contract();">						
				     						</td>
										</tr>
				     					<tr>
				     						<td style="width:15%" align="right">收件人</td>
				     						<td>
				     							<select class="form-control" id="stu_select" required="required" style="width:100%" type="text" name="new[]">
				     								
				     									
				     							</select>
				     							
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:15%" align="right">類型</td>
				     						<td>
				     							<select id="type" class="form-control" required="required" style="width:100%" type="text" name="new[]">
				     								<option class="form-control" value="平信">平信</option>
				     								<option class="form-control" value="掛號">掛號</option>
				     								<option class="form-control" value="明信片">明信片</option>
				     								<option class="form-control" value="包裹">包裹</option>
				     							</select>
				     							
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:15%" align="right">收件時間</td>
				     						<td>
				     							<input id="date" class="form-control" id="datepicker5" required="required" style="width:100%" type="text" name="new[]" value="<?=date('Y-m-d')?>">
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:15%" align="right">備註</td>
				     						<td>
				     							<textarea id="note" class="form-control" style="resize: none;"  style="width:100%" name="new[]" row="3"></textarea>
				     						</td>
				     					</tr>
				     				
				     				</table>
			     					<hr>
									<button name="addsubmit" class="btn btn-primary"  onclick="add_mail_stu()">新增</button>
			     					<button type="reset" class="btn btn-danger">清除</button>
			     					
							</div>
							<div class="tab-pane" id="nstudent">
									<table class="table table-hover">
				     					<tr>
				     						<td style="width:15%" align="right">收件人</td>
				     						<td>
				     							<input id="recname" class="form-control"  required="required" style="width:100%" type="text" name="new[]" value="">
				     							
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:15%" align="right">電話</td>
				     						<td>
				     							<input id="phone" class="form-control"  required="required" style="width:100%" type="text" name="new[]" value="">
				     							
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:15%" align="right">類型</td>
				     						<td>
				     							<select id="type_1" class="form-control" required="required" style="width:100%" type="text" name="new[]">
				     								
				     								<option class="form-control" value="平信">平信</option>
				     								<option class="form-control" value="掛號">掛號</option>
				     								<option class="form-control" value="明信片">明信片</option>
				     								<option class="form-control" value="包裹">包裹</option>
				     								
				     									
				     							</select>
				     							
				     						</td>
				     					</tr>
				     					<tr>
				     						<td style="width:15%" align="right">收件時間</td>
				     						<td>
				     							<input id="date_1" class="form-control" id="datepicker6" required="required" style="width:100%" type="text" name="new[]" value="<?=date('Y-m-d')?>">
				     						</td>
				     					</tr>
				     					
				     					<tr>
				     						<td style="width:15%" align="right">備註</td>
				     						<td>
				     							<textarea id="note_1" class="form-control" style="resize: none;"  style="width:100%" name="new[]" row="3"></textarea>
				     						</td>
				     					</tr>
				     					
				     				</table>
				     				<hr>
									<button name="addsubmit" class="btn btn-primary" onclick="add_mail_nstu()">新增</button>
			     					<button type="reset" class="btn btn-danger">清除</button>
			     					
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->