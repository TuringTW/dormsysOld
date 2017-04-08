<!--item李dorm id 有 0 表示其他 在sql query前需攔截 -->

<h1 class="page-header">新合約/續約</h1>
<!-- 搜尋列 次導覽列 -->
<input type="hidden" id="new_contract_id" value="0">
<input type="hidden" id="r_id" value="0">
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li class="active "><a id="tab_stuinfo" href="#stuinfo" role="tab" data-toggle="tab">Step1.房客資料</a></li>
	<li><a id="tab_contract" href="#contract" role="tab" data-toggle="tab">Step2.合約資料</a></li>
	<li><a id="tab_finalcheck" href="#finalcheck" role="tab" data-toggle="tab" onClick="">Step3.確認合約</a></li>
	<!-- <li><a id="tab_thingsplan" href="#thingsplan" role="tab" data-toggle="none" onClick="errormsg('請先送出合約')">Step4.房間物品</a></li> -->
	<li><a id="tab_financialplan" href="#financialplan" role="tab" data-toggle="none" onClick="errormsg('請先送出合約')">Step4.計算租金</a></li>
	<li><a id="tab_print" href="#print" role="tab" data-toggle="none" onClick="errormsg('請先計算租金')">Step5.列印</a></li>
</ul>
<br>
<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active " id="stuinfo">
		<!-- <hr> -->
		<div class="panel-group" id="accordion">
		</div>
		<div class="row">
			<div class="col-md-5">
				<input class="form-control dropdown-toggle"  id="add_stu_info_search" data-toggle="dropdown" style="width:100%" placeholder="請先輸入名字或手機，案Enter搜尋，若無資料直接按加號新增" style="" type="text"value="" onKeyClick="stu_suggestion()" onfocus="stu_suggestion()" onChange="stu_suggestion();" >
				<div class="btn-group"id="stu_search_result" style="width:100%;z-index:1000;">

				</div>
			</div>
			<div class="col-md-1" >
				<a href="#" id="add_stu_info_section" class="btn btn-default" title="新增一個空白的資料" style="width:100%" onClick="addstuinfo(0);"class=""><span class="glyphicon glyphicon-plus"></span></a>
				<input type="hidden" id="key" value="0">
			</div>
			<div class="col-md-1" >
				<a href="#"  class="btn btn-default" style="width:100%" onClick="refresh();" title="更新學生自己輸入的資料"><span class="glyphicon glyphicon-refresh"></span></a>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="contract">
		<form method="POST" action="_add_contract.php" >
			<div id="stuinfosubmit">

			</div>
			<div class="row">
				<div class="col-md-4">
					<h4>租約資料</h4>
					<table class="table" style="width:100%">
						<tr  id="dormtd">
							<td style="width:30%" align="right">*宿舍</td>
							<td>
								<select class="form-control" id="dorm_select" onChange="room_suggestion();document.getElementById('dormtd').className='';recheck();" required="required" style="width:100%" type="text" >
     								<option class="form-control" value="" >請選擇宿舍...</option>
     								<?php foreach ($dormlist as  $dorm) { ?>
     									<?php if ($dorm['dorm_id']!=33&&$dorm['dorm_id']!=34): ?>
     										<option class="form-control" <?=(isset($sroom)&&$dorm['dorm_id']==$sroom['dorm'])?'selected':''?> value="<?=$dorm['dorm_id']?>"><?=$dorm['name']?></option>
     									<?php endif ?>
     								<?php } ?>

     							</select>
							</td>
						</tr>
						<tr  id="roomtd">
							<td style="width:30%" align="right">*房間</td>
							<td>
								<select class="form-control" id="room_select" onclick="" required="required" style="width:100%" type="text" name="room_id" onChange="room_data_suggestion();document.getElementById('roomtd').className='';document.getElementById('dormtd').className='';recheck();">
										<?php if (isset($sroom)): ?>
											<option value="<?=$sroom['room_id']?>" selected><?=$sroom['rname']?></option>
										<?php endif ?>
									</select>
							</td>
						</tr>
						<tr id="rentd">
							<td style="width:30%;font-size:12px" align="right">*總租金</td>
							<td>
									<input class="form-control" id="rent" required="required" style="width:100%" type="text" value="<?=isset($sroom)?$sroom['rent']:''?>" name="rent" onchange="get_rent_cal()">
							</td>
						</tr>
						<tr>
							<td style="width:30%" align="right">帶看人</td>
							<td>
								<select class="form-control" id="sales" required="required" style="width:100%" name="manager">
<!--  									<option  class="form-control">請選擇...</option>
 -->
     								<?php foreach ($saleslist as $key => $value): ?>
     									<option  class="form-control" value="<?=$value['m_id']?>" ><?=$value['name']?></option>
     								<?php endforeach ?>
     							</select>
							</td>
						</tr>
					</table>
					<h4>備註</h4>
					<table class="table" style="width:100%">

						<tr>
							<td style="width:100%" >
									<textarea  id="note" class="form-control" style="resize: none;"  style="width:100%" name="note" row="3"></textarea>
							</td>
						</tr>
					</table>
				</div>
				<div class="col-md-4">
					<h4>合約日期</h4>
					<table class="table" style="width:100%">
						<tr id="sdatetd">
							<td style="width:30%" align="right">*合約開始</td>
							<td>
								<input class="form-control"  id="datepickerStart" required="required" style="width:100%" type="text" name="sdate"  onChange="document.getElementById('sdatetd').className='';get_rent_cal();">
							</td>
						</tr>
						<tr id="edatetd">
							<td style="width:30%" align="right">*合約結束</td>
							<td>
								<input class="form-control"  id="datepickerEnd" required="required" style="width:100%" type="text" name="edate"  onChange="document.getElementById('edatetd').className='';get_rent_cal();">
							</td>
						</tr>

					</table>
					<h4>遷入遷出 <span class="" id="InOutcheck"></span></h4>
					<input type="hidden" id="checkInOutval" value="0">
					<table class="table" style="width:100%">
						<tr id="sdatetd">
							<td style="width:30%" align="right">*遷入日期</td>
							<td style="width:50%">
								<input class="form-control"  id="datepickerIn" required="required" style="width:100%" type="text" name="sdate"  onChange="checkInOut();recheck();">
							</td>
							<td style="width:20%"><a class="btn btn-default" onclick="sameascontract(0)" >同合約</a></td>
						</tr>
						<tr id="edatetd">
							<td style="width:30%" align="right">*遷出日期</td>
							<td  style="width:50%">
								<input class="form-control"  id="datepickerOut" required="required" style="width:100%" type="text" name="edate"  onChange="checkInOut();recheck();">
							</td>
							<td style="width:20%"><a class="btn btn-default" onclick="sameascontract(1)">同合約</a></td>
						</tr>

					</table>
					<div class="row">

						<div class="col-md-5 pull-right">
							<a class="btn btn-warning btn-lg" title="檢查遷入遷出日期是否重疊" style="width:100%" id="btncheck" onClick="checknotoverlap();">CHECK</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<h4>租金試算</h4>
					<table class="table"  style="width:100%;text-align:center">
						<tr>
							<td style="width:30%">總天數</td>
							<td id="total_days">0</td>
							<td></td>
						</tr>
						<tr>
							<td style="width:30%">總人數</td>
							<td id="total_peo">0</td>
							<td></td>
						</tr>
						<tr>
							<td style="width:30%">月數</td>
							<td id="mib">0</td>
							<td>$<span id="mib_rent">0</span></td>
						</tr>
						<tr>
							<td style="width:30%">剩餘天數</td>
							<td id="ROD">0</td>
							<td>$<span id="ROD_rent">0</span></td>
						</tr>
						<tr>
							<td>總共</td>
							<td></td>
							<td>$<span id="total_rent">0</span></td>
						</tr>
					</table>

				</div>
			</div>

		</form>
	</div>

	<div class="tab-pane" id="finalcheck">
		<div clas="row">
			<div class="col-sm-3">
				<table style="width:100%">
					<tr>
						<td><h4>房客</h4></td>
						<td class=" pull-right"><a title="確認房客清單無誤" class="btn btn-warning" onclick="final_check(1)" id="btnfinalcheck_1">CHECK</a></td>
					</tr>
				</table>
				<table class="table table-hover">
					<thead>
						<th>姓名</th><th>手機</th>
					</thead>
					<tbody id="final_stu_list">

					</tbody>

				</table>
			</div>
			<div class="col-sm-3">
				<table style="width:100%">
					<tr>
						<td><h4>合約資料</h4></td>
						<td class=" pull-right"><a title="確認合約資料無誤" class="btn btn-warning" onclick="final_check(2)" id="btnfinalcheck_2">CHECK</a></td>
					</tr>
				</table>

				<table class="table table-hover">
					<tr><th style="width:30">宿舍</th><td id="final_dorm">宿舍未填</td></tr>
					<tr><th style="width:30">房號</th><td id="final_room">房號未填</td></tr>
					<tr><th style="width:30">租金</th><td id="final_rent">租金未填</td></tr>
				</table>
			</div>
			<div class="col-sm-3">
				<table style="width:100%">
					<tr>
						<td><h4>合約日期</h4></td>
						<td class=" pull-right"><a title="確認合約日期無誤" class="btn btn-warning" onclick="final_check(3)" id="btnfinalcheck_3">CHECK</a></td>
					</tr>
				</table>
				<table class="table table-hover">
					<tr><th style="width:30">合約開始</th><td id="final_sd">合約日期未填</td></tr>
					<tr><th style="width:30">合約結束</th><td id="final_ed">合約日期未填</td></tr>
				</table>
				<table style="width:100%">
					<tr>
						<td><h4>遷入遷出</h4></td>
						<td class=" pull-right"><a title="遷入遷出日期無誤" class="btn btn-warning" onclick="final_check(4)" id="btnfinalcheck_4">CHECK</a></td>
					</tr>
				</table>
				<table class="table table-hover">
					<tr><th style="width:30">遷入日期</th><td id="final_id">遷入遷出日期未填</td></tr>
					<tr><th style="width:30">遷出日期</th><td id="final_od">遷入遷出日期未填</td></tr>
				</table>
			</div>
			<div class="col-sm-3">
				<table style="width:100%">
					<tr>
						<td><h4>租金計算</h4></td>
						<td class=" pull-right"><a title="確認付款計畫無誤" class="btn btn-warning" onclick="final_check(5)" id="btnfinalcheck_5">CHECK</a></td>
					</tr>
				</table>
				<table class="table table-hover">
					<tr>
						<th>租金總額</th>
						<td id="final_tr">合約日期未填</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row" style="width:100%">
			<div class="col-md-5">

			</div>
			<div class="col-md-2 pull-right">
				<input type="hidden" id="prev_contract_id" value="0">
				<a id="submitbtn" name="newcontractsubmit"  class="btn btn-primary btn-lg" disabled onclick="submitcontract()">送出</a>
			</div>
		</div>


	</div>
	<!-- <div class="tab-pane" id="thingsplan"> -->
		<!-- <div class="row"> -->
			<!-- <div class="col-sm-6"> -->
				<!-- <div class="row"> -->
					<!-- <div class="col-sm-7"><h3>房間物品列表</h3></div> -->

					<!-- <div class="col-sm-1"><a href="#" class="btn btn-info" title="重新整理房間物品列表" onclick=""><span class="glyphicon glyphicon-refresh"></span></a></div> -->
					<!-- <div class="col-sm-4"><a href="#" class="btn btn-default" onclick="$('#rentModal').modal('toggle')">新增額外費用/獎勵</a></div> -->
				<!-- </div> -->

				<!--
				<table class='table table-hover' style="text-align:center">
					<thead>
						<th>#</th>
						<th>類型</th>
						<th>+/-</th>
						<th>費用</th>
						<th>描述</th>
						<th>新增日期</th>
					</thead>
					<tbody id="rent_detail"></tbody>
				</table> -->
			<!-- </div> -->
			<!-- <div class="col-sm-2"><a href="#" class="btn btn-primary btn-lg" onclick="things_check()">確認</a></div> -->

		<!-- </div> -->
	<!-- </div> -->
	<div class="tab-pane" id="financialplan">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-7"><h3>租金項目列表</h3></div>
					<div class="col-sm-1"><a href="#" class="btn btn-info" title="重新整理租金項目列表" onclick="show_rent_detail()"><span class="glyphicon glyphicon-refresh"></span></a></div>
					<div class="col-sm-4"><a href="#" class="btn btn-default" onclick="$('#rentModal').modal('toggle')">新增額外費用/獎勵</a></div>
				</div>


				<table class='table table-hover' style="text-align:center">
					<thead>
						<th>#</th>
						<th>類型</th>
						<th>+/-</th>
						<th>費用</th>
						<th>描述</th>
						<th>新增日期</th>
					</thead>
					<tbody id="rent_detail"></tbody>
				</table>
			</div>
			<div class="col-sm-6">
				<h3>租金總額:&nbsp;&nbsp;<span id="rent_total">0</span>元整</h3>
				<hr>
				<a href="#" class="btn btn-primary btn-lg pull-right" onclick="finance_check()">確認</a>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="print">
		<div class="row">
			<div class="col-md-4">
				<h2>列印</h2>
				<hr>
				<br>
				<h2>資料查看</h2>
				<hr>
				<div class="btn-group">
					<a class="btn btn-default" href="" id="href_contract">查看合約</a>

				</div>
			</div>
			<div class="col-md-8" >
				<div class="well" style="width:100%;">
					<h2>列印預覽</h2>
					<hr>
					<iframe id="printFrame" src="<?=web_url('/contract/pdf_gen')?>" style="width:100%;height:630px"></iframe>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	if (!is_null($keep)) {
		$keep_result[0][0] = (new DateTime($keep_result[0]['e_date']))-> modify('+1 day') -> format('Y-m-d');
		$keep_result[0][1] =(new DateTime($keep_result[0]['out_date']))-> modify('+1 day') -> format('Y-m-d');
	}
?>
<a class="btn" id="keepbtn" onclick="
<?php if(!is_null($keep)){ foreach ($keep_result as $key => $value) {?>
	addstuinfo(<?=$value['stu_id']?>);
<?php } ?>;
document.getElementById('dorm_select').value = <?=$keep_result[0]['dorm_id']?>;
room_suggestion(<?=$keep_result[0]['room_id']?>);

$('#datepickerStart').val('<?=$keep_result[0][0]?>');
$('#datepickerIn').val('<?=$keep_result[0][1]?>');
$('#prev_contract_id').val(0) <?php } ?>"></a>

<a class="btn" id="resbtn" onclick="<?php if(!is_null($r_id)){?>
document.getElementById('dorm_select').value=<?=$r_result[0]['dorm_id']?>;
room_suggestion(<?=$r_result[0]['room_id']?>);
$('#datepickerStart').val('<?=$r_result[0]['s_date']?>');
$('#datepickerEnd').val('<?=$r_result[0]['e_date']?>');
	$('#r_id').val('<?=$r_id?>');

 <?php } ?>"></a>
