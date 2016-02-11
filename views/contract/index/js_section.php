<?php function js_section(){ ?>

<script type="text/javascript">
// for contractlist
	
	function printmodel(){

		contract_id = $('#contract_id').val();
		$('#print_iframe').attr('src', '<?=web_url("/contract/pdf_gen?contract_id=")?>'+contract_id);
		$('#printModal').modal('toggle');
	}
	
	table_refresh();
	// 關鍵字搜尋

	function keyword_serach(){
		pagemove(0);
		table_refresh();
	}
	// 宿舍選擇
	function dorm_select(dorm_id, dorm_name){
		$('#lbldorm').html(dorm_name);
		$('#dorm_select_value').val(dorm_id);
		pagemove(0);
		table_refresh();
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
	// 即將到期的按鈕
	function due_select(){
		var value = $('#due_value').val();
		if (value==1) {
			$('#due_value').val(0);
			$('#btnDue').removeClass('active');
		}else{
			$('#due_value').val(1);
			$('#btnDue').addClass('active');
			$('#ofd_value').val(0);
			$('#btnOFD').removeClass('active');

		}
		pagemove(0);
		table_refresh();
	}
	// 逾期的按鈕
	function ofd_select(){
		var value = $('#ofd_value').val();
		if (value==1) {
			$('#ofd_value').val(0);
			$('#btnOFD').removeClass('active');
		}else{
			$('#ofd_value').val(1);
			$('#btnOFD').addClass('active');
			$('#due_value').val(0);
			$('#btnDue').removeClass('active');
		}
		pagemove(0);
		table_refresh();
	}
	// 更新本月到期跟下月到期的數量
	function due_ofd_refresh(keyword, dorm){
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "keyword=" + keyword+"&dorm="+dorm;  
		xhr.open("POST", "<?=web_url('/contract/due_ofd_refresh')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText); 
					data = JSON.parse(xhr.responseText) ;
					$('#view_ofd').html(data.countofd);
					$('#view_due').html(data.countdue);
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	// 更新排列方式
	function table_order(order_method){
		$('.order_marker').html("+");
		$('.order_marker').css("display", "none");
		
		if (order_method==$('#order_method').val()) {
			var law_now = $("#order_law").val();	
			if (law_now=="true") {
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
		var due_value = $('#due_value').val();
		var ofd_value = $('#ofd_value').val();
		var dorm = $('#dorm_select_value').val();
		var order_method = $('#order_method').val();//排序方法
		var order_law = $('#order_law').val(); //遞增或遞減

		if (order_law=="true") {
			order_law=1;
		}else{
			order_law=0;
		}

		$('#txtkeyword').focus();
		// if(due_value*ofd_value==1){
		// 	due_value = 0;
		// 	ofd_value = 0;
		// }

		if (page < 0) {
			page = 1;
		}
		// 更新DUE & OFD
		due_ofd_refresh(keyword, dorm);

		// 傳送
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "keyword=" + keyword+"&page="+page+"&due_value="+due_value+"&ofd_value="+ofd_value+"&dorm="+dorm+"&order_method="+order_method+"&order_law="+order_law;  
		xhr.open("POST", "<?=web_url('/contract/show')?>");
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
		var page = $('#page_value').val();
		$('#result_table').html('');
		for (var i = 0; i < data.length; i++) {
			var text = '';
			if (data[i].countp>1) {
				text = '等'+data[i].countp+'人';
			};
			$('#result_table').append('<tr><td>'+(page*30+i-29)+'</td><td>'+data[i].sname+text+'</td><td>'+data[i].dname+'</td><td>'+data[i].rname+'</td><td>'+data[i].s_date+'</td><td>'+data[i].e_date+'</td><td>'+data[i].in_date+'</td><td>'+data[i].out_date+'</td><td>'+data[i].c_date+'</td><td><a onclick="showcontract('+data[i].contract_id+')"><span class="glyphicon glyphicon-pencil"></span></a></td></tr>');				
		};
		if (data.length<30) {
			$('#page_up').attr( "disabled", true );
		}else{
			$('#page_up').attr( "disabled", false );
		}	
	}
// for 詳細合約資料
	// AJAX產生合約資料
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

					show_rent_detail(contract_id);
					show_pay_rent_detail(contract_id);
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
		var data = "room_id=" + room_id+"&in_date=" + in_date+"&out_date=" + out_date + '&contract_id='+contract_id;  
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
	$('#view_in_date').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$('#view_out_date').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$('#new_rent_date').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$('#new_pay_rent_date').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	
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
		var e_date = Date.parse($('#view_e_date').val()+' 00:00:00');
		var today = new Date();
		if (Math.round((today - e_date)/1000000)<0) {
			errormsg('合約尚未到期!!!');
		}else{
			$('#dialog-check-out-comfirm').dialog( "open" );
			$('#ccontract_id').val($('#contract_id').val());
			$(document).ready(function() {
		        $('#viewModal').modal('toggle');
				$('body').removeClass('modal-open');
				$('.modal-backdrop').remove();
		    });
		}
			
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
					alert(xhr.responseText);
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


// 租金
	function show_rent_detail(contract_id){

		// 傳送
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "contract_id=" + contract_id;  
		xhr.open("POST", "<?=web_url('/accounting/show_rent_detail')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					data = JSON.parse(xhr.responseText);
					$('#rent_detail').html('');
					var total_rent = 0;
					if (data.state===true) {
						for (var i = 0; i < data.data.length; i++) {
						  	var datum = data.data[i];
						  	switch(datum.type){
						  		case '1':
						  			datum.typename = '租金';
						  			break;
						  		case '2':
						  			datum.typename = '額外';
						  			break;
						  		case '3':
						  			datum.typename = '獎學金';
						  			break;
						  		case '4':
						  			datum.typename = '其他+';
						  			break;
						  		case '5':
						  			datum.typename = '其他-';
						  			break;
						  		default:
						  			datum.typename = '';
						  	}
						  	$('#rent_detail').append('<tr><td>'+(i+1)+'</td><td>'+datum.typename+'</td><td>'+((datum.pm==1)?'<span class="glyphicon glyphicon-plus"></span>':'<span class="glyphicon glyphicon-minus"></span>')+'</td><td>'+datum.value+'</td><td>'+datum.description+'</td><td>'+datum.date+'</td></tr>');
							total_rent = total_rent + ((datum.pm=='1')?1:-1)*parseInt(datum.value);
						};  
						$('#rent_total').html(total_rent);
					}
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	
	}
	function submit_new_rent(){
		var type = $('#new_rent_type_select').val();
		var value = parseInt($('#new_rent_value').val());
		var date = $('#new_rent_date').val();
		var description = $('#new_rent_description').val();
		var contract_id = $('#contract_id').val();

		var state = 1;
		if ((type==4||type==5)&&description=='') {
			errormsg('選擇"其他"請輸入描述或備註');
			state = 0;
		};
		if (date=='') {
			errormsg('請輸入日期');
			state = 0;
		};
		if (!Number.isInteger(value)||value<=0||value=='') {
			errormsg('請輸入正整數金額');
			state = 0;
		}
		if (type=='') {
			errormsg('請選擇類別');
			state = 0;
		};
		
// 傳送
		if (state == 1) {
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			var data = "contract_id=" + contract_id+'&type='+type+'&value='+value+'&date='+date+'&description='+description;  	
			xhr.open("POST", "<?=web_url('/accounting/add_rent_record')?>");
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
			xhr.send(data);  
			function display_datas() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// alert(xhr.responseText);
						data = JSON.parse(xhr.responseText);

						if (data.state===true) {
							successmsg('新增成功');
							show_rent_detail(contract_id);
							$('#rentModal').modal('toggle');
						}else{
							errormsg('新增失敗');
						}
					} else {  
						alert('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}  
			xhr.onreadystatechange = display_datas;  
		};
	}

	function show_pay_rent_detail(contract_id){

		// 傳送
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "contract_id=" + contract_id;  
		xhr.open("POST", "<?=web_url('/accounting/show_pay_rent_detail')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					data = JSON.parse(xhr.responseText);
					$('#pay_rent_detail').html('');
					var total_rent = 0;
					if (data.state===true) {
						for (var i = 0; i < data.data.length; i++) {
						  	var datum = data.data[i];
						  	switch(datum.source){
						  		case '1':
						  			datum.sourcename = '轉帳';
						  			break;
						  		case '2':
						  			datum.sourcename = '支票';
						  			break;
						  		case '3':
						  			datum.sourcename = '現金';
						  			break;
						  		
						  		default:
						  			datum.sourcename = '';
						  	}
						  	$('#pay_rent_detail').append('<tr><td>'+(i+1)+'</td><td>'+datum.sourcename+'</td><td>'+datum.from+'</td><td>'+datum.value+'</td><td>'+(datum.receipt_id==0?'':datum.receipt_id)+'</td><td>'+datum.description+'</td><td>'+datum.date+'</td></tr>');
							total_rent = total_rent + parseInt(datum.value);
						};  
						$('#pay_rent_total').html(total_rent);
					}
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	
	}
	function submit_new_pay_rent(){
		var source = $('#new_pay_rent_source').val();
		var value = parseInt($('#new_pay_rent_value').val());
		var from = $('#new_pay_rent_from').val();
		var date = $('#new_pay_rent_date').val();
		var r_id = $('#new_pay_rent_r_id').val();
		var description = $('#new_pay_rent_description').val();
		var contract_id = $('#contract_id').val();
		var state = 1;
		if ((source==3)&&r_id=='') {
			errormsg('選擇"現金"請輸入收據編號');
			state = 0;
		};
		if (date=='') {
			errormsg('請輸入日期');
			state = 0;
		};
		if (from=='') {
			errormsg('請輸入繳款人');
			state = 0;
		};
		if (!Number.isInteger(value)||value<=0||value=='') {
			errormsg('請輸入正整數金額');
			state = 0;
		}
		if (source=='') {
			errormsg('請選擇類別');
			state = 0;
		};
		
// 傳送
		if (state == 1) {
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			var data = "contract_id=" + contract_id+ '&source='+source+'&value='+value+'&from='+from+'&date='+date+'&r_id='+r_id+'&description='+description;
			xhr.open("POST", "<?=web_url('/accounting/add_pay_rent_record')?>");
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
			xhr.send(data);  
			function display_datas() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// alert(xhr.responseText);
						data = JSON.parse(xhr.responseText);

						if (data.state===true) {
							successmsg('新增成功');
							show_pay_rent_detail(contract_id);
							$('#payrentModal').modal('toggle');
						}else{
							errormsg('新增失敗');
						}
					} else {  
						alert('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}  
			xhr.onreadystatechange = display_datas;  
		};
	}
	




	if ($("#view_contract_id").val()==-1) {
		errormsg("查看合約代碼錯誤，請紀錄步驟，通知Kevin");
	}else if($("#view_contract_id").val()!=0){
		showcontract($("#view_contract_id").val());
	}

	if ($("#view_option").val()==1) {
		ofd_select();
	}
	if ($("#view_option").val()==2) {
		due_select();
	}

	
</script>

<?php } ?>

