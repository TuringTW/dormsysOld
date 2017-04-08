<?php function js_section(){ ?>

<script type="text/javascript">
// for contractlist

	function printmodel(){

		r_id = $('#r_idforRes').val();
		$('#print_iframe').attr('src', '<?=web_url("/reservation/pdf_gen?r_id=")?>'+r_id);
		$('#printModal').modal('toggle');
	}

	table_refresh();

	function remove_str_date(){
		$("#txtSetStartday").val('');
		pagemove(0);//page move has table_refresh()
	}


	function remove_end_date(){
		$("#txtSetendday").val('');
		pagemove(0);//page move has table_refresh()
	}
	// 關鍵字搜尋

	function keyword_serach(){
		pagemove(0);//page move has table_refresh()
	}
	// 限制開始結束時間
	function set_start(){
		pagemove(0);//page move has table_refresh()
	}
	function set_end(){
		pagemove(0);//page move has table_refresh()
	}

	// 宿舍選擇
	function dorm_select(dorm_id, dorm_name){
		$('#lbldorm').html(dorm_name);
		$('#dorm_select_value').val(dorm_id);
		pagemove(0);
	}
	// 頁碼
	function pagemove(action){
		var page = parseInt($('#page_value').val());
		if (action == 0|| page < 1) {
			$('#page_value').val(1);
			$('#page_down').attr( "disabled", true );

		}else if(action == -1){
			if (page !== 1) {
				$('#page_value').val(page-1);
			}
			if (page-1 == 1) {

				$('#page_down').attr( "disabled", true );
			};
		}else{
			$('#page_value').val(page+1);
			$('#page_down').attr( "disabled", false );
		}
		$('#show_page').html($('#page_value').val());
		table_refresh();
	}
	function btn_value_reset(){
		$('#ofd_value').val(0);
		$('#btnDue').removeClass('active');
		$('#wait_value').val(0);
		$('#btnWait').removeClass('active');
	}
	// 等待簽約的按鈕
	function wait_select(){
		var value = $('#wait_value').val();
		if (value==1) {
			$('#wait_value').val(0);
			$('#btnWait').removeClass('active');
		}else{
			btn_value_reset();
			// =====
			$('#wait_value').val(1);
			$('#btnWait').addClass('active');
		}
		pagemove(0);
	}
	// 逾期的按鈕
	function ofd_select(){
		var value = $('#ofd_value').val();
		if (value==1) {
			$('#ofd_value').val(0);
			$('#btnOFD').removeClass('active');
		}else{
			btn_value_reset();
			// =====
			$('#ofd_value').val(1);
			$('#btnOFD').addClass('active');
		}
		pagemove(0);
		table_refresh();
	}
	// 更新本月到期跟下月到期的數量
	function due_ofd_refresh(keyword, dorm, start_value, end_value){
		var data = "keyword=" + keyword+"&dorm="+dorm+"&startval="+start_value+"&endval="+end_value;
		post('/reservation/due_ofd_refresh', data, callback, 0);
		function callback(data) {
			$('#view_ofd').html(data.countofd);
			$('#view_wait').html(data.count_wait);
		}
	}
	// 更新排列方式
	function table_order(order_method){
		$('.order_marker').html("+");
		$('.order_marker').css("display", "none");

		if (order_method==$('#order_method').val()) {
			var law_now = $("#order_law").val();
			if (law_now=="true") { //same law and flip + to -
				law_now=1;
				if (order_method!=0) {
					$('#order_marker_'+order_method).html('-');
					$("#order_marker_"+order_method).css("display", "inline");
				};
			}else{
				law_now=0;
				if (order_method!=0) {
					$('#order_marker_'+order_method).html('+');
					$("#order_marker_"+order_method).css("display", "inline");
				};
			}
			$('#order_law').val(!law_now);
		}else{
			$("#order_method").val(order_method);
			$("#order_law").val(0);
			$('#order_marker_'+order_method).html('-');
			$("#order_marker_"+order_method).css("display", "inline");
		}
		table_refresh();
	}
	// 更新想式的數量
	function table_refresh(){
		var keyword = $('#txtkeyword').val();
		var page = $('#page_value').val();
		var ofd_value = $('#ofd_value').val();
		var wait_value = $('#wait_value').val();
		var dorm = $('#dorm_select_value').val();
		var order_method = $('#order_method').val();//排序方法
		var order_law = $('#order_law').val(); //遞增或遞減
		var start_value = $('#txtSetStartday').val();
		var end_value = $('#txtSetendday').val();

		if (order_law=="true") {
			order_law=1;
		}else{
			order_law=0;
		}

		$('#txtkeyword').focus();
		if (page < 0) {
			page = 1;
		}
		// 更新DUE & OFD
		due_ofd_refresh(keyword, dorm, start_value, end_value);

		// 傳送

		var data = "keyword=" + keyword+"&page="+page+"&ofd_value="+ofd_value+"&wait_value="+wait_value+"&dorm="+dorm+"&order_method="+order_method+"&order_law="+order_law+"&startval="+start_value+"&endval="+end_value;
		post('/reservation/show', data, callback, 0)
		function callback(data) {
			tableparse(data);
		}
	}
	function tableparse(data){
		var page = $('#page_value').val();
		$('#result_table').html('');
		for (var i = 0; i < data.length; i++) {
			var text = '';

			var classrule = "";
			var state = '';
			var d_date = new Date(data[i].d_date);
			//正常
			classrule="";
			if (((d_date.getTime()-Date.now())/1000/86400)+1>0) {
				state = "有效";
				// classrule = "class='info'"
			}else if(data[i].is_deposit===true){
				state = "<b>待</b>簽約";
				classrule = "class='info'"
			}else{
				state = "<b>過</b>期";
				classrule = "class='danger'"
			}

			$('#result_table').append('<tr '+classrule+'><td>'+(page*30+i-29)+'</td><td>'+state+'</td><td>'+data[i].dname+'</td><td>'+data[i].rname+'</td><td>'+data[i].sname+'</td><td>'+data[i].mobile+'</td><td>'+data[i].s_date+'</td><td>'+data[i].e_date+'</td><td>'+data[i].d_date+'</td><td>'+data[i].deposit+'</td><td>'+data[i].is_deposit+'</td><td><a onclick="showreservation('+data[i].id+')"><span class="glyphicon glyphicon-pencil"></span></a></td></tr>');
		};
		if (data.length<30) {
			$('#page_up').attr( "disabled", true );
		}else{
			$('#page_up').attr( "disabled", false );
		}
	}
// for 詳細合約資料
	// AJAX產生合約資料
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
	// 檢查合約日期
	function check_room(){
		$('#edit_btn').attr( "disabled", true );
		document.getElementById('view_s_date_check').className = "glyphicon glyphicon-refresh";
		document.getElementById('view_e_date_check').className = "glyphicon glyphicon-refresh";
		var in_date = $('#view_s_dateforRes').val();
		var out_date = $('#view_e_dateforRes').val();
		var room_id = $('#room_idforRes').val();
		var r_id = $('#r_idforRes').val();

		var data = "room_id=" + room_id+"&in_date=" + in_date+"&out_date=" + out_date + '&r_id='+r_id+'&res=1';
		function callback(data){
			if (data == true) {
				$('#edit_btn').attr( "disabled", false );
				document.getElementById('view_s_date_checkforRes').className = "glyphicon glyphicon-ok";
				document.getElementById('view_e_date_checkforRes').className = "glyphicon glyphicon-ok";
			}else{
				document.getElementById('view_s_date_checkforRes').className = "glyphicon glyphicon-remove";
				document.getElementById('view_e_date_checkforRes').className = "glyphicon glyphicon-remove";
			}
		}
		post('/contract/date_check_by_room', data, callback, 0)
	}
	// 提示表單有變更
	function change_alert(){

		var $btn = $('#edit_btn');
		$btn.html("未儲存");
		// $('#edit_btn').addClass('active');
		// alert($('#edit_btn').attr('class'));
		// $('#edit_btn').attr('class', 'btn btn-warning btn-lg');
		// $('#edit_btn').html('未儲存');
		// alert($('#edit_btn').html());
	}
	// 修改合約資料
	function editcontract(){
		var r_id = $('#r_idforRes').val();
		var s_date = $('#view_s_dateforRes').val();
		var e_date = $('#view_e_dateforRes').val();
		var d_date = $('#view_d_dateforRes').val();
		var sales = $('#view_salesforRes').val();
		var note = $('#view_noteforRes').val();
		var sname = $('#view_snameforRes').val();
		var mobile = $('#view_mobileforRes').val();
		var data = "r_id=" + r_id+"&s_date="+s_date+"&e_date="+e_date+"&d_date="+d_date+"&sales="+sales+"&note="+note+"&sname="+sname+"&mobile="+mobile;
		post('/reservation/edit', data, callback, 0)
		function callback(data){
			if (data===true) {
				document.getElementById('edit_btnforRes').className = 'btn btn-info btn-lg';
				document.getElementById('edit_btnforRes').innerHTML = '已儲存';
				// 更新表格裡的資訊
				table_refresh();
			}
		}
	}
	// 詳細資料裡的日期選擇
	$('#view_s_dateforRes').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$('#view_e_dateforRes').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$('#view_d_dateforRes').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});


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
        			showreservation(contract_id);

          	}else{
          		var b_date = $('#keep_b_date').val();
          		var tomorrow = new Date(Date.parse(b_date));
							tomorrow.setDate(tomorrow.getDate()+1);
          		window.location.assign('<?=web_url("/contract/newcontract")?>?keep='+contract_id);
          	}
        }
      }
    });

// 續約
	// 檢查可否續約
	function bind_contract(){
		$('#dialog-bind-comfirm').dialog( "open" );
		$('#kcontract_id').val($('#contract_id').val());
		$(document).ready(function() {
	        $('#viewModalforRes').modal('toggle');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
	    });
	}
	dialogbreakdone = $( "#dialog-bind-comfirm" ).dialog({
		autoOpen: false,
		modal: true,
		width: "50%",
		resizable: false,
		dialogClass: "alert",
		buttons: {
        '簽新合約': function() {
          	$( this ).dialog( "close" );
          	var r_id = $('#r_idforRes').val();

          	sign_contract(r_id);
        },
				'連結現有合約': function() {
          	$( this ).dialog( "close" );
          	var contract_id = $('#bind_res_id').val();
          	bind_existed_contract(r_id);
        },
        '取消': function(){
        	$( this ).dialog( "close" );
        }
      }
    });
	function sign_contract(r_id){
			window.location.assign('<?=web_url("/contract/newcontract")?>?r_id='+r_id);
	}
	function bind_existed_contract(r_id){

	}
// view

	if ($("#view_r_id").val()==-1) {
		errormsg("查看訂單代碼錯誤，請紀錄步驟，通知Kevin");
	}else if($("#view_r_id").val()!=0){
		showreservation($("#view_r_id").val());
	}
</script>

<?php } ?>
