<?php function js_section(){ ?>

<script type="text/javascript">
// for contractlist
	table_refresh();

	// 宿舍選擇
	function dorm_select(dorm_id, dorm_name){
		$('#lbldorm').html(dorm_name);
		$('#dorm_select_value').val(dorm_id);
		table_refresh();
	}
	Date.prototype.addDays = function(days)
	{
	    var dat = new Date(this.valueOf());
	    dat.setDate(dat.getDate() + days);
	    return dat;
	}

	function date_refresh(method){
		var end_date = $('#end_date').val();
		var edat = new Date(end_date);
		var str_date = $('#str_date').val();
		var dat = new Date(str_date);
		if (method==0) {
			if ($('#end_date').val()=='') {

				dat = dat.addDays(1);
				var end_date = dat.getFullYear()+'-'+(dat.getMonth()+1)+'-'+dat.getDate();
				$('#end_date').val(end_date);
			}

		}else if ($('#str_date').val()=='') {

			edat = edat.addDays(-1);
			var str_date = edat.getFullYear()+'-'+(edat.getMonth()+1)+'-'+edat.getDate();
			$('#str_date').val(str_date);
		}

		if (edat-dat<=0) {
			dat = dat.addDays(1);
			var end_date = dat.getFullYear()+'-'+(dat.getMonth()+1)+'-'+dat.getDate();
			$('#end_date').val(end_date);
		}

	}



	// 更新想式的數量
	function table_refresh(){
		var str_date = $('#str_date').val();
		var end_date = $('#end_date').val();
		var lprice = $('#lprice').val();
		var hprice = $('#hprice').val();
		var type = $('#room_type_value').val();
		var dorm = $('#dorm_select_value').val();
		$('#txtkeyword').focus();
		// if(due_value*ofd_value==1){
		// 	due_value = 0;
		// 	ofd_value = 0;
		// }


		// 傳送
		var xhr;
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // IE 8 and older
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = "str_date="+str_date+"&end_date="+end_date+"&lprice="+lprice+"&hprice="+hprice+"&type="+type+"&dorm="+dorm;
		xhr.open("POST", "<?=web_url('/roomengine/show_avail_room')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send(data);
		function display_datas() {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					// alert(xhr.responseText);
					tableparse(xhr.responseText);
				} else {
					alert('資料傳送出現問題，等等在試一次.');
				}
			}
		}
		xhr.onreadystatechange = display_datas;
	}
	function tableparse(json){
		data = JSON.parse(json);
		$('#result_table').html('');
		for (var i = 0; i < data.length; i++) {

			$('#result_table').append('<tr><td>'+(i+1)+'</td><td>'+data[i].dname+'</td><td>'+data[i].rname+'</td><td>'+data[i].type+'</td><td>'+data[i].out_date+'</td><td>'+(data[i].premin>=4000?'':data[i].premin)+'</td><td><a style="'+((data[i].pre_id==''||data[i].pre_id==undefined)?'display:none':'')+'" href="#" onclick="showthing('+data[i].pre_id+','+(data[i].pre_ctype=='con'?1:(data[i].pre_ctype=='res'?2:''))+')" title="前'+(data[i].pre_ctype=='con'?'合約':(data[i].pre_ctype=='res'?'訂單':''))+'資料"><span class="'+(data[i].pre_ctype=='con'?'glyphicon glyphicon-file':(data[i].pre_ctype=='res'?'glyphicon glyphicon-bookmark':''))+'"></span></a></td><td>'+data[i].in_date+'</td><td>'+(data[i].postmin>=4000?'':data[i].postmin)+'</td><td><a href="#" style="'+((data[i].post_id==''||data[i].post_id==undefined)?'display:none':'')+'" title="後'+(data[i].post_ctype=='con'?'合約':(data[i].post_ctype=='res'?'訂單':''))+'資料" onclick="showthing('+data[i].post_id+','+(data[i].post_ctype=='con'?1:(data[i].post_ctype=='res'?2:''))+')"><span class="'+(data[i].post_ctype=='con'?'glyphicon glyphicon-file':(data[i].post_ctype=='res'?'glyphicon glyphicon-bookmark':''))+'"></span></a></td><td>'+data[i].rent+'</td><td><a href="#" title="房間詳細資料"><span class="glyphicon glyphicon-pencil"></span></a></td></tr>');
		};

	}
// for 詳細合約資料
	// AJAX產生合約資料
	function showthing(id, type){
		if (type==1) {
			showcontract(id);
		}else{
			showreservation(id);
		}
	}
	function showreservation(r_id){
		$('#viewModalforRes').modal('toggle');
		var data = "r_id=" + r_id;
		function callback(data) {
			var datum = data[0];
			$('#view_smsforRes').attr('onclick','sendsms("'+datum.sname+'同學你好,", "'+datum.mobile+'")')
			$('#view_snameforRes').val(datum.sname);
			$('#view_mobileforRes').val(datum.mobile);
			$('#view_dorm_hrefforRes').attr('href','dorm.php?view='+datum.dorm_id);
			$('#view_dormforRes').val(datum.dname);
			$('#view_roomforRes').val(datum.rname);
			$('#view_room_hrefforRes').attr('href','room.php?view='+datum.room_id);
			$('#view_s_dateforRes').val(datum.s_date);
			$('#view_e_dateforRes').val(datum.e_date);
			$('#view_d_dateforRes').val(datum.d_date);
			$('#view_timestampforRes').val(datum.timestamp);
			$('#view_salesforRes').val(datum.sales);
			$('#view_managerforRes').val(datum.mname);
			$('#view_noteforRes').val(datum.note);
			$('#room_idforRes').val(datum.room_id);
			$('#view_change_btnforRes').attr('data-cnum',datum.contract_id);
			$('#r_idforRes').val(datum.id);
			//document.getElementById("room_select").innerHTML = xhr.responseText;

			// show_deposit_detail(contract_id);
		}
		post('/reservation/show_reservation', data, callback, 0)
	}
	function showcontract(contract_id){
		$('#viewModal').modal('toggle');
		var xhr;
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // IE 8 and older
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = "contract_id=" + contract_id;
		xhr.open("POST", "<?=web_url('/contract/show_contract')?>", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(data);
		xhr.onreadystatechange = display_data;
		function display_data() {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					// alert(xhr.responseText);
					var data = JSON.parse(xhr.responseText);
					document.getElementById('view_stu_info').innerHTML = '';
					for (var i = 0; i < data.length; i++) {
						datum = data[i];
						var stu_url = "<?=web_url('/student/index')?>";
						document.getElementById('view_stu_info').innerHTML+='<tr>'
		     						+'<td style="width:15%" align="right" >'+((i==0)?'立約人':'')+'</td>'
		     						+'<td>'
		     						+'	<div class="row">'
		     						+'		<div class="col-md-4"><input class="form-control"  disabled required="required" style="width:100%" type="text" name="stu[]" value="'+datum.sname+'"></div>'
		     						+'		<div class="col-md-4"><input class="form-control"  disabled required="required" style="width:100%" type="text" name="stu[]" value="'+datum.mobile+'"></div>'
		     						+'		<div class="col-md-2"><a title="學生資料" href="'+stu_url+'?view='+datum.stu_id+'" class="btn btn-default" style="width:100%"><span class="glyphicon glyphicon-user"></span></a></div>'
		     						+'		<div class="col-md-2"><a title="寄簡訊" id="view_sms_'+i+'" class="btn btn-default" style="width:100%"><span class="glyphicon glyphicon-comment"></span></a></div>'
		     						+'	</div>'
		     						+'</td>'
		     						+'<input type="hidden" name="contract[]" value="'+datum.contract_id+'">'
		     					+'</tr>';
		     			$('#view_sms_'+i).attr('onclick','sendsms("'+datum.sname+'同學你好,", "'+datum.mobile+'")')
					};
					var datum = data[0];

					document.getElementById('view_dorm_href').href = 'dorm.php?view='+datum.dorm_id;
					document.getElementById('view_dorm').value = datum.dname;
					document.getElementById('view_room').value = datum.rname;
					document.getElementById('view_room_href').href = 'room.php?view='+datum.room_id;
					document.getElementById('view_s_date').value = datum.s_date;
					document.getElementById('view_e_date').value = datum.e_date;
					document.getElementById('view_in_date').value = datum.in_date;
					document.getElementById('view_out_date').value = datum.out_date;
					document.getElementById('view_c_date').value = datum.c_date;
					document.getElementById('view_rent').value = datum.rent;
					document.getElementById('view_sales').value = datum.sales;
					document.getElementById('view_manager').value = datum.mname;
					document.getElementById('view_note').value = datum.note;
					document.getElementById('room_id').value = datum.room_id;
					document.getElementById('view_change_btn').setAttribute('data-cnum',datum.contract_id);
					document.getElementById('contract_id').value = datum.contract_id;
					//document.getElementById("room_select").innerHTML = xhr.responseText;
				} else {
					alert('資料傳送出現問題，等等在試一次.');
				}
			}
		}
	}
	// 檢查遷入遷出日期
	function check_room(){
		$('#edit_btn').attr( "disabled", true );
		document.getElementById('view_out_date_check').className = "glyphicon glyphicon-refresh";
		document.getElementById('view_in_date_check').className = "glyphicon glyphicon-refresh";
		var in_date = $('#view_in_date').val();
		var out_date = $('#view_out_date').val();
		var room_id = $('#room_id').val();
		var contract_id = $('#contract_id').val();

		var xhr;
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // IE 8 and older
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = "room_id=" + room_id+"&in_date=" + in_date+"&out_date=" + out_date+"&contract_id=" + contract_id;
		xhr.open("POST", "<?=web_url('/contract/date_check_by_room')?>", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(data);
		xhr.onreadystatechange = display_data;
		function display_data() {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					// alert(xhr.responseText);
					var result = JSON.parse(xhr.responseText);
					if (result == true) {
						$('#edit_btn').attr( "disabled", false );
						document.getElementById('view_out_date_check').className = "glyphicon glyphicon-ok";
						document.getElementById('view_in_date_check').className = "glyphicon glyphicon-ok";
					}else{
						document.getElementById('view_out_date_check').className = "glyphicon glyphicon-remove";
						document.getElementById('view_in_date_check').className = "glyphicon glyphicon-remove";
					}
				} else {
					alert('資料傳送出現問題，等等在試一次.');
				}
			}
		}
	}
	// 提示表單有變更
	function change_alert(){
		document.getElementById('edit_btn').className = 'btn btn-warning btn-lg';
		document.getElementById('edit_btn').innerHTML = '未儲存';
	}
	// 修改合約資料
	function editcontract(){
		var contract_id = $('#contract_id').val();
		var in_date = $('#view_in_date').val();
		var out_date = $('#view_out_date').val();
		var sales = $('#view_sales').val();
		var note = $('#view_note').val();
		var xhr;
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // IE 8 and older
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = "contract_id=" + contract_id+"&in_date="+in_date+"&out_date="+out_date+"&sales="+sales+"&note="+note;
		xhr.open("POST", "<?=web_url('/contract/edit')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send(data);
		function display_datas() {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					// alert(xhr.responseText);
					if (JSON.parse(xhr.responseText.trim())===true) {
						document.getElementById('edit_btn').className = 'btn btn-info btn-lg';
						document.getElementById('edit_btn').innerHTML = '已儲存';
						// 更新表格裡的資訊
						table_refresh();
					}
				} else {
					alert('資料傳送出現問題，等等在試一次.');
				}
			}
		}
		xhr.onreadystatechange = display_datas;
	}
	// 詳細資料裡的日期選擇
	$('#str_date').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$('#end_date').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	// 合約終止
	dialogbreak = $( "#dialog-breakcontracr" ).dialog({
		autoOpen: false,
		width: 600,
		modal: true,
		resizable: false,
		dialogClass: "alert",
		buttons: {
		"原合約終止後續約":breaknkeep,
		"原合約終止": breakonly,
		"取消": function() {
				dialogbreak.dialog( "close" );
			}
		},
		close: function() {

		}
    });
    //
    $( "#view_change_btn" ).on( "click", function() {

      	$(document).ready(function() {
	        $('#viewModal').modal('toggle');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
	    });


	    var element = $( this );
	    if ( element.is( "[data-cnum]" ) ) {
			var contract_id = element.attr('data-cnum');
			getbcontract(contract_id);
			$('#bcontract_id').val(contract_id);
	    }
	    dialogbreak.dialog( "open" );
    });
    function getbcontract(contract_id){
		var xhr;
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // IE 8 and older
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = "contract_id=" + contract_id;
		xhr.open("POST", "<?=web_url('/contract/show_contract')?>", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(data);
		function display_datas() {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					// alert(xhr.responseText);
					data = JSON.parse(xhr.responseText);


					document.getElementById("break_stu_info").innerHTML = '';
					for (var i = data.length - 1; i >= 0; i--) {
						document.getElementById("break_stu_info").innerHTML += '<tr><td>'+data[i].sname+'</td><td>'+data[i].mobile+'</td><td>'+data[i].id_num+'</td></tr>';
					};
					document.getElementById("break_contract_info").innerHTML = '<tr><td>'+data[0].dname+'</td><td>'+data[0].rname+'</td><td>'+data.length+'</td><td>'+data[0].s_date+'</td><td>'+data[0].e_date+'</td></tr>'+"<input type='hidden' name='bs_date' id='bs_date' value='"+data[0].s_date+"'>"+"<input type='hidden' name='be_date' id='be_date' value='"+data[0].e_date+"'>";

				} else {
					alert('資料傳送出現問題，等等在試一次.');
				}
			}
		}
		xhr.onreadystatechange = display_datas;
	}
	function breakcontract(contract_id,b_date,wtdo){
		var xhr;
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // IE 8 and older
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = "contract_id=" + contract_id+"&b_date=" + b_date;
		xhr.open("POST", "<?=web_url('/contract/break_contract')?>", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(data);
		function display_datas() {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					// alert(xhr.responseText);

					if (JSON.parse(xhr.responseText)==true) {
						$('#dialog-breakcontracr').dialog( "close" );
						if (wtdo) {
							$('#keep_bcontract_id').val(contract_id);
 							$('#keep_b_date').val(b_date);
 							$('#bkeepalert').html('接下來進行續約');
 							$('#bkeepalert').css('display','inline');
						}

						$('#dialog-update-done').dialog( "open" );
					}else{
						$('#dialog-update-failed').dialog( "open" );
					}


				} else {
					alert('資料傳送出現問題，等等在試一次.');
				}
			}
		}
		xhr.onreadystatechange = display_datas;
	}
	function breaknkeep () {
		var contract_id = $('#bcontract_id').val();
		var b_date = $('#bdate').val();
		if(checkdate(bdate)){
			$('#bstate').html('');
			breakcontract(contract_id,b_date,1);
		}else{
			$('#bstate').html('中止日期須在原合約日期內');
		}
	}
	function breakonly () {
		var contract_id = $('#bcontract_id').val();
		var b_date = $('#bdate').val();
		if(checkdate(b_date)){
			$('#bstate').html('');
			breakcontract(contract_id,b_date,0);
		}else{
			$('#bstate').html('中止日期須在原合約日期內');
		}
	}
	function checkdate () {
		var bs_date = Date.parse($('#bs_date').val());
		var be_date = Date.parse($('#be_date').val());
		var b_date = Date.parse($('#bdate').val());
		if (be_date-b_date>0&&bs_date-b_date<0) {
			return 1;
		}else{
			return 0;
		}
	}

	dialogbreakfailed = $( "#dialog-update-failed" ).dialog({
		autoOpen: false,

		modal: true,
		resizable: false,
		dialogClass: "alert",
		buttons: {

        '確定': function() {
          $( this ).dialog( "close" );
          location.reload();
        }
      }
    });
    dialogbreakdone = $( "#dialog-update-done" ).dialog({
		autoOpen: false,

		modal: true,
		width: "50%",
		resizable: false,
		dialogClass: "alert",
		buttons: {

        '確定': function() {
          	$( this ).dialog( "close" );
          	var contract_id = $('#keep_bcontract_id').val();
          	if (contract_id=='0') {
          		var contract_id = $('#bcontract_id').val();
          		table_refresh();
        		showcontract(contract_id);

          	}else{
          		var b_date = $('#keep_b_date').val();
          		var tomorrow = new Date(Date.parse(b_date));
				tomorrow.setDate(tomorrow.getDate()+1);
          		window.location.assign('newContract.php?keep='+contract_id+'&sdate='+(tomorrow.getFullYear())+'-'+(tomorrow.getMonth()+1)+'-'+(tomorrow.getDate())+'&searchsubmit=')

          	}

        }
      }
    });
	// 合約終止 日期選擇
	$('#bdate').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});

// 結算
	// 檢查可否結算
	function checkout_check(){
		$('#dialog-check-out-comfirm').dialog( "open" );
		$('#ccontract_id').val($('#contract_id').val());
		$(document).ready(function() {
	        $('#viewModal').modal('toggle');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
	    });
	}
	// 確認結算
	dialogbreakdone = $( "#dialog-check-out-comfirm" ).dialog({
		autoOpen: false,

		modal: true,
		width: "50%",
		resizable: false,
		dialogClass: "alert",
		buttons: {

        '確定結算': function() {
          	$( this ).dialog( "close" );
          	var contract_id = $('#ccontract_id').val();
          	checkout_contract(contract_id);

        },
        '取消': function(){
        	$( this ).dialog( "close" );
        }
      }
    });
    dialogbreakdone = $( "#dialog-universal-alert" ).dialog({
		autoOpen: false,

		modal: true,
		width: "30%",
		resizable: false,
		dialogClass: "alert",
		buttons: {

        '確定': function() {
          	$( this ).dialog( "close" );
        }
      }
    });
    // 結算
    function checkout_contract(contract_id){
    	var xhr;
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // IE 8 and older
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = "contract_id=" + contract_id;
		xhr.open("POST", "<?=web_url('/contract/checkout_contract')?>", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(data);
		function display_datas() {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					// alert(xhr.responseText);
					table_refresh();
					if (JSON.parse(xhr.responseText) == true ) {
						$('#dialog-universal-alert').html('<div class="alert alert-success"><h2><span class="glyphicon glyphicon-ok"></span>成功!!!</h2></div>')
						$('#dialog-universal-alert').dialog( "open" );
					}
				} else {
					alert('資料傳送出現問題，等等在試一次.');
				}
			}
		}
		xhr.onreadystatechange = display_datas;
    }
// 續約
	// 檢查可否續約
	function keep_check(){
		$('#dialog-keep-comfirm').dialog( "open" );
		$('#kcontract_id').val($('#contract_id').val());
		$(document).ready(function() {
	        $('#viewModal').modal('toggle');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
	    });
	}
	dialogbreakdone = $( "#dialog-keep-comfirm" ).dialog({
		autoOpen: false,

		modal: true,
		width: "50%",
		resizable: false,
		dialogClass: "alert",
		buttons: {

        '確定續約': function() {
          	$( this ).dialog( "close" );
          	var contract_id = $('#kcontract_id').val();
          	keep_contract(contract_id);

        },
        '取消': function(){
        	$( this ).dialog( "close" );
        }
      }
    });
    function keep_contract(contract_id){
    	// 傳送
		var xhr;
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // IE 8 and older
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = "contract_id=" + contract_id;
		xhr.open("POST", "<?=web_url('/contract/keep_contract_check')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send(data);
		function display_datas() {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					// alert(xhr.responseText);
					data = JSON.parse(xhr.responseText);
					if (data==true) {
						window.location = "<?=web_url('/contract/newcontract')?>?keep="+contract_id;
					}else{
						errormsg('續約時發生錯誤，可能是租金尚未結清。');
					}
				} else {
					errormsg('資料傳送出現問題，等等在試一次.');
				}
			}
		}
		xhr.onreadystatechange = display_datas;
    }
	function printmodel(){

		contract_id = $('#contract_id').val();
		$('#print_iframe').attr('src', '<?=web_url("/contract/pdf_gen?contract_id=")?>'+contract_id);
		$('#printModal').modal('toggle');
	}

</script>

<?php } ?>
