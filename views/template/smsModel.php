
<div class="modal fade modal-sms" id="smsModal" tabindex="-1" role="dialog" data-show="1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">
					<button type="button" id="closebtn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">寄簡訊</h4>
				</div>
				<div class="modal-body">
					<h5>簡訊內容</h5>
					<textarea class="form-control" id="sms_content" style="resize: none;"  style="width:100%" name="new[]" rows="5"></textarea>	
    				<br>
    				<h5>收件人(逗號隔開)</h5>
    				<textarea class="form-control" id="sms_receiver" style="resize: none;"  style="width:100%" name="new[]" rows="5"></textarea>	
     				
				</div>
				<div class="modal-footer">
					<div class="row" style="width:100%">
						<div class="col-md-3">
						</div>
						<div class="col-md-6 pull-right">
							<button id="sms_clean_btn" type = "reset" class="btn btn-danger btn-lg">清除</button>
							<a id="edit_btn" onclick="editcontract()" class="btn btn-info btn-lg ">寄送</a>
							<button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
						</div>

						
						
						
						<div class="col-md-2 pull-right">
							
						</div>
						
						

						
					</div>
					
				</div>
			</form>
		</div><!-- /.modal-content -->
		
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->