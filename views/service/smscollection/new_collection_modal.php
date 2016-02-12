<div class="modal fade " id="newcollectionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">新增罐頭簡訊</h4>
				</div>
				<div class="modal-body">
					<table class="table table-hover">
     					<tr>
     						<td style="width:15%" align="right">類型</td>
     						<td>
     							<select id="type" class="form-control" required="required" style="width:100%" type="text" name="new[]">
     								<option class="form-control" value="0">一般</option>

     							</select>
     							
     						</td>
     					</tr>
     					
     					<tr>
     						<td style="width:15%" align="right">內容</td>
     						<td>
     							<p>XXX同學你好,...</p>
     							<textarea id="content" class="form-control" style="resize: none;" placeholder="輸入剩下要打的東西" style="width:100%" name="new[]" row="3"></textarea>
     						</td>
     					</tr>
     				
     				</table>
 					<hr>
					<button name="addsubmit" class="btn btn-primary"  onclick="add_sms_collection()">新增</button>
 					<button type="reset" class="btn btn-danger">清除</button>
 					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->