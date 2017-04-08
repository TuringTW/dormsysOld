	<?php function js_section(){ ?>
<script type="text/javascript">
// 學生資料
	function room_suggestion(keeproom){
		var dorm = document.getElementById("dorm_select").value;
		var data = "dorm_id=" + dorm;
		post('/utility/room_suggestion', data, callback, 0);
		function callback(data){
			if (data.state==true) {
				var data = data.result;
				var htmltext = "<option class='form-control'>請選擇...</option>";
				for (var i = data.length - 1; i >= 0; i--) {
					htmltext += "<option class='form-control' value='"+data[i].room_id+"'>"+data[i].name+"</option>";
				};

				document.getElementById("room_select").innerHTML = htmltext;
				document.getElementById("room_select").focus();
				if (typeof(keeproom)!=='undefined') { //for keep room
					document.getElementById('room_select').value = keeproom;
				};
			}else{
				errormsg("傳輸出現問題"+xhr.responseText);
			}
		}
	}

	function get_rent_cal(){
		var rpm = $('#rent').val();
		var s_date = $('#datepickerStart').val();
		var e_date = $('#datepickerEnd').val();
		var countpeo = $('input[name*="stu_id[]"]').length;

		if (checkSE()) {
			var data = 'rpm='+rpm+'&s_date='+s_date+'&e_date='+e_date+'&countpeo='+countpeo;
			post('/contract/get_rent_cal', data, callback, 0)
			function callback(data){
				if (data!==false) {
					$('#total_days').html(data.date_result.td);
					$('#total_peo').html(countpeo);
					$('#mib').html(data.date_result.mib);
					$('#ROD').html(data.date_result.rod);
					$('#mib_rent').html(data.rent_result.mib_rent);
					$('#ROD_rent').html(data.rent_result.ROD_rent);
					$('#total_rent').html(data.rent_result.total_rent);
					$('#final_tr').html(data.rent_result.total_rent);
				}
			}
		}
	}
	function checkSE(){
		var s_date = $('#datepickerStart').val();
		var e_date = $('#datepickerEnd').val();
		if (s_date!==''&&e_date!=='') {
			if (date_diff(s_date, e_date)<=0) {
				errormsg('合約日期錯誤');
				$('#final_sd').html('合約日期錯誤');
				$('#final_ed').html('合約日期錯誤');
				$('#final_tr').html('合約日期錯誤');
				return false;
			}else{
				$('#final_sd').html($('#datepickerStart').val());
				$('#final_ed').html($('#datepickerEnd').val());

				return true;
			}
		}else{
			$('#final_sd').html('合約日期未填');
			$('#final_ed').html('合約日期未填');
			$('#final_tr').html('合約日期未填');
			return false;
		}
	}
	function checkInOut(){
		var s_date = $('#datepickerIn').val();
		var e_date = $('#datepickerOut').val();
		if (s_date!==''&&e_date!=='') {
			if (date_diff(s_date, e_date)<=0) {
				errormsg('遷入遷出日期錯誤');

				return false;
			}else{

				return true;
			}
		}else{
			return false;
		}
	}
	function date_diff(s_date, e_date){
		var start = new Date(s_date);
		var end = new Date(e_date);
		return (end-start)/86400000;
	}
	function submitreservation(){


		var new_sname = $('#new_sname').val()
		var new_mobile = $('#new_mobile').val()
		var dorm_select = $('#dorm_select').val()
		var room_select = $('#room_select').val()
		var d_date = $('#d_date').val()
		var sales = $('#sales').val()
		var note = $('#note').val()
		var datepickerStart = $('#datepickerStart').val()
		var datepickerEnd = $('#datepickerEnd').val()
		var res_deposit = $('#res_deposit').val();

		var status = 1;
		if (new_sname == '') {
			status = 0;
			errormsg('姓名未填');
		}else if (new_mobile == '') {
			status = 0;
			errormsg('電話未填');
		}else if (dorm_select == '') {
			status = 0;
			errormsg('宿舍未填');
		}else if (room_select == '') {
			status = 0;
			errormsg('房間未填');
		}else if (d_date == '') {
			status = 0;
			errormsg('有效期限沒填');
		}else if (res_deposit == '') {
			status = 0;
			errormsg('訂金沒填');
		}


		if (status == 1) {
			var data = "res_deposit="+res_deposit+"&new_sname="+new_sname+"&new_mobile="+new_mobile+"&dorm_select="+dorm_select+"&room_select="+room_select+"&d_date="+d_date+"&sales="+sales+"&note="+note+"&datepickerStart="+datepickerStart+"&datepickerEnd="+datepickerEnd;
			post('/reservation/submit_reservation', data, callback, 0);
			function callback(data){
				if (data.state == 1) {
					var r_id = data.id;
					final_check(r_id);
					checkOK();

				}else{
					errormsg('儲存失敗，再試一次')
				}
			}
		}
	}


	function checknotoverlap(){
		var s_date = $('#datepickerStart').val();
		var e_date = $('#datepickerEnd').val();
		var room_id = $('#room_select').val();

		var status = 1;
		if (s_date == ''||typeof s_date=='undefined') {
			status = 0;
			errormsg('開始日期未填');
		}else if (e_date == ''||typeof e_date=='undefined') {
			status = 0;
			errormsg('結束日期未填');
		}

		if (room_id!==''&&room_id!==null&&room_id!==0&&status==1) {
			var data = 's_date='+s_date+'&e_date='+e_date+'&room_id='+room_id;
			post('/contract/check_not_over_lap', data, callback, 0);
			function callback(data){
				if (data.state ===true) {
					submitreservation();
				}else if(data.state ===false){
					$('#over_lap_dorm').html(data.result[0].dname);
					$('#over_lap_room').html(data.result[0].rname);
					$('#over_lap_list').html('');
					for (var i = 0;i < data.result.length; i++) {
						datum = data.result[i];
						$('#over_lap_list').append('<tr><td>'+(i+1)+'</td><td>'+((datum.source=='res')?'預定單':((datum.source=='con')?'合約':''))+'</td><td>'+datum.sname+'</td><td>'+datum.mobile+'</td><td>'+datum.s_date+'</td><td>'+datum.e_date+'</td><td>'+datum.in_date+'</td><td>'+datum.out_date+'</td></tr>')
					};
					$('#overlapModal').modal('toggle');
					recheck();
				}else if(data.state ===-1){
					errormsg('房間日期資料輸入不完整或格式錯誤');
					recheck();
				}
			}
		}else{
			errormsg('房號、遷入、遷出日期請填寫完整');
		}
	}
	function checkOK(){
		$('#btncheck').html('送出');
		$('#btncheck').attr('class','btn btn-success  btn-lg');
		$('#InOutcheck').attr('class', 'glyphicon glyphicon-ok-circle');
		$('#final_id').html($('#datepickerIn').val());
		$('#final_od').html($('#datepickerOut').val());
		$('#checkInOutval').val(1);
		$('#btncheck').attr('disabled', true);
	}
	function recheck(){
		$('#btncheck').attr('disabled', false);
		$('#btncheck').html('送出');
		$('#btncheck').attr('class','btn btn-primary btn-lg');
		$('#InOutcheck').attr('class', '');
		$('#final_id').html('檢查未通過');
		$('#final_od').html('檢查未通過');
		$('#checkInOutval').val(0);
	}

// final check
	function final_check(r_id){

		$('#tab_print').attr('data-toggle','tab');
		$('#tab_print').attr('onclick','');
		$('#tab_print').trigger('click');
		$('#printFrame').attr('src', '<?=web_url("/reservation/pdf_gen")?>?r_id='+r_id);
		$('#btn-view-res').attr('href', '<?=web_url("/reservation/index")?>?r_id='+r_id);
	}

	$( '#datepickerStart' ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			onClose: function( selectedDate ) {
				$( "#datepickerEnd" ).datepicker( "option", "minDate", selectedDate );
			}});
	$( '#datepickerEnd' ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			onClose: function( selectedDate ) {
				$( "#datepickStart" ).datepicker( "option", "maxDate", selectedDate );
			}});
	$( '#datepickerIn' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true,
		onClose: function( selectedDate ) {
			$( "#datepickerOut" ).datepicker( "option", "minDate", selectedDate );
		}});
	$( '#datepickerOut' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true,
		onClose: function( selectedDate ) {
			$( "#datepickerIn" ).datepicker( "option", "maxDate", selectedDate );
		}});
	$( '#new_rent_date' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$( '#d_date' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});

</script>
<?php } ?>
