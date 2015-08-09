<!--item李dorm id 有 0 表示其他 在sql query前需攔截 -->

<h1 class="page-header">新合約/續約</h1>
<!-- 搜尋列 次導覽列 -->

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li class="active "><a href="#stuinfo" role="tab" data-toggle="tab">Step1.房客資料</a></li>
	<li><a href="#contract" role="tab" data-toggle="tab" onClick="recheck()">Step2.合約資料</a></li>
	<li><a href="#count" role="tab" data-toggle="tab" onClick="">Step3.付款計畫</a></li>
	<li><a href="#print" role="tab" data-toggle="tab" onClick="">Step4.確認合約</a></li>
	<li><a href="#print" role="tab" data-toggle="tab" onClick="">Step5.列印</a></li>
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
				<a href="#" id="add_stu_info_section" class="btn btn-default" style="width:100%" onClick="addstuinfo(0);"class=""><span class="glyphicon glyphicon-plus"></span></a>
				<input type="hidden" id="key" value="0">
			</div>
		</div>
	</div>
	<div class="tab-pane" id="contract">
		<form method="POST" action="_add_contract.php" >
			<div id="stuinfosubmit">
				
			</div>
			<div class="row">
				<div class="col-md-6">
					<h4>租約資料</h4>
					<table class="table" style="width:100%">
						<tr  id="dormtd">
							<td style="width:20%" align="right">*宿舍</td>
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
							<td style="width:20%" align="right">*房間</td>
							<td>
								<select class="form-control" id="room_select" onclick="" required="required" style="width:100%" type="text" name="room_id" onChange="room_data_suggestion();document.getElementById('roomtd').className='';document.getElementById('dormtd').className='';recheck();">
										<?php if (isset($sroom)): ?>
											<option value="<?=$sroom['room_id']?>" selected><?=$sroom['rname']?></option>
										<?php endif ?>
									</select>     	
							</td>
						</tr>
						<tr id="rentd">
							<td style="width:20%;font-size:12px" align="right">*每人每月租金</td>
							<td>
									<input class="form-control" id="rent" required="required" style="width:100%" type="text" value="<?=isset($sroom)?$sroom['rent']:''?>" name="rent">
							</td>
						</tr>
						<tr>
							<td style="width:20%" align="right">帶看人</td>
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
				</div>
				<div class="col-md-6">
					<h4>合約日期</h4>
					<table class="table" style="width:100%">
						<tr id="sdatetd">
							<td style="width:20%" align="right">*入住日期</td>
							<td>
								<input class="form-control"  id="datepickerIn" required="required" style="width:100%" type="text" name="sdate"  onChange="document.getElementById('sdatetd').className='';recheck();">
							</td>
						</tr>
						<tr id="edatetd">
							<td style="width:20%" align="right">*遷出日期</td>
							<td>
								<input class="form-control"  id="datepickerOut" required="required" style="width:100%" type="text" name="edate"  onChange="document.getElementById('edatetd').className='';recheck();">
							</td>
						</tr>
						
					</table>
					<h4>備註</h4>
					<table class="table" style="width:100%">
						
						<tr>
							<td style="width:100%" >
									<textarea class="form-control" style="resize: none;"  style="width:100%" name="note" row="3"></textarea>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3" id="stucheckresult">

				</div>
				<div class="col-md-4" id="checkresult">

				</div>
				<div class="col-md-2" id="wholeresult">

				</div>
				<div class="col-md-3">
					<a class="btn btn-default btn-lg" onClick="checkcontract();">CHECK</a>
				</div>
			</div>
		</form>
	</div>
	<div class="tab-pane" id="count">
		<a id="submitbtn" name="newcontractsubmit" class="btn btn-primary btn-lg" disabled>送出</a>

	</div>
	<div class="tab-pane" id="print">

	</div>
</div>


