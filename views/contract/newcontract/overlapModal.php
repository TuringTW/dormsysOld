
<div class="modal fade " id="overlapModal" tabindex="-1" role="dialog" data-show="1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:60%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" id="closebtn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">此期間已有人入住</h4>
			</div>
			<div class="modal-body">
				<h4><span id="over_lap_dorm"></span>-<span id="over_lap_room"></span></h4>
				<table class="table table-hover">
					<thead>
						<th>#</th>
						<th>類型</th>
						<th>姓名</th>
						<th>手機</th>
						<th>合約開始</th>
						<th>合約結束</th>
						<th>遷入日期</th>
						<th>遷出日期</th>
					</thead>
					<tbody id="over_lap_list">
					</tbody>
				</table>

			</div>
			<div class="modal-footer">
				<div class="row" style="width:100%">
					<div class="col-md-2 pull-right">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
