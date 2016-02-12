<h1 class="page-header">罐頭簡訊列表</h1>
<!-- 搜尋列 次導覽列 -->
	<div class="form-group">
		<!-- <div class="col-sm-5">
			<input type="text" id="txtkeyword"class="form-control" onchange="keyword_serach()" placeholder="Enter電話、內容" value="">
		</div> -->
		<div class="col-sm-2 btn-group">
			<a href="#" class="btn btn-default" onclick="sendsms('', '')" >新簡訊</a>

			<a href="#" class="btn btn-default" onclick="$('#newcollectionModal').modal('toggle')" >新罐頭簡訊</a>
		</div>
 	</div>	
	<br>
	<br>
	<hr>
			<!-- 搜尋結果 -->

	<div class="table-responsive">
		<table class="table table-hover" >
			
				<thead>
					<tr>
						<th style="text-align:center; width:5%">#</th>
						<th style="text-align:center; width:10%">類型</th>
						<th style="text-align:center; width:85%">內容</th>
					</tr>
				</thead>
				<tbody id="result_table" style="text-align:center">

				</tbody>
		</table>
	</div>
</div>
</div>
