<!--item李dorm id 有 0 表示其他 在sql query前需攔截 -->

<h1 class="page-header">新合約/續約</h1>
<!-- 搜尋列 次導覽列 -->
<input type="hidden" id="new_contract_id" value="0">
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li class="active"><a id="tab_contract"  href="#contract" role="tab" data-toggle="tab">Step1.訂單資料</a></li>
	<li><a id="tab_print" href="#print" role="tab" data-toggle="none" onClick="errormsg('請先送出')">Step2.列印</a></li>
</ul>

<br>
<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="contract">
		<form method="POST" action="_add_contract.php" >
			<div id="stuinfosubmit">

			</div>
			<div class="row">
				<div class="col-md-4">
					<h4>學生資料</h4>
					<table class="table" style="width:100%">
						<tr  id="dormtd">
							<td style="width:30%" align="right">*姓名</td>
							<td>
								<input class="form-control"  id="new_sname" required="required" style="width:100%" type="text">
							</td>
						</tr>
						<tr  id="roomtd">
							<td style="width:30%" align="right">*電話</td>
							<td>
								<input class="form-control"  id="new_mobile" required="required" style="width:100%" type="text">
							</td>
						</tr>
					</table>
				</div>
				<div class="col-md-4">
					<h4>訂房資料</h4>
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
								<select class="form-control" id="room_select" onclick="" required="required" style="width:100%" type="text" name="room_id" onChange="">
										<?php if (isset($sroom)): ?>
											<option value="<?=$sroom['room_id']?>" selected><?=$sroom['rname']?></option>
										<?php endif ?>
									</select>
							</td>
						</tr>
						<tr id="rentd">
							<td style="width:30%;font-size:12px" align="right">*有效期限</td>
							<td>
									<input class="form-control" id="d_date" required="required" style="width:100%" type="text" value="<?=date('Y-m-d', mktime(0,0,0,date('m'), date('d')+3, date('Y')))?>" name="rent" onchange="get_rent_cal()">
							</td>
						</tr>
						<tr>
							<td style="width:30%" align="right">帶看人</td>
							<td>
								<select class="form-control" id="sales" required="required" style="width:100%" name="manager">
 									<option  class="form-control">請選擇...</option>

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
					<h4>訂金</h4>
					<table class="table" style="width:100%">
						<tr id="sdatetd">
							<td style="width:30%" align="right">*訂金金額</td>
							<td>
								<input class="form-control"  id="res_deposit" required="required" style="width:100%" type="text" name="sdate"  onChange="">
							</td>
						</tr>

					</table>
					<div class="row">

						<div class="col-md-12">
							<div class="btn-group pull-right">
								<a class="btn btn-primary btn-lg" title="檢查遷入遷出日期是否重疊" style="" id="btncheck" onClick="checknotoverlap();">送出</a>
							</div>

						</div>
					</div>
				</div>
			</div>

		</form>
	</div>
	<div class="tab-pane" id="print">
		<div class="row">
			<div class="col-md-4">
				<h2>列印</h2>
				<hr>
				<br>
			</div>
			<div class="col-md-8" >
				<div class="well" style="width:100%;">
					<h2>列印預覽</h2>
					<hr>
					<iframe id="printFrame" src="" style="width:100%;height:630px"></iframe>
				</div>
			</div>
		</div>
	</div>
</div>
