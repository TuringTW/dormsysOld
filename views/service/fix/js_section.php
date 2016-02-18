<?php function js_section(){ ?>

<script type="text/javascript">
// for contractlist
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
	function type_select(cate_id, cate){
		$('#lbltype').html(cate);
		$('#type_select_value').val(cate_id);
		pagemove(0);
		table_refresh();
	}
	function rtype_select(rtype_id, rtype){
		$('#lblrtype').html(rtype);
		$('#rtype_select_value').val(rtype_id);
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
	
	// 更新想式的數量
	function table_refresh(){
		var keyword = $('#txtkeyword').val();
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
		var data = "keyword=" + keyword;  
		xhr.open("POST", "<?=web_url('/service/show_fix_list')?>");
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
			switch(data[i].receipttype){
				case '1':
					data[i].rtype = '發票';
					break;
				case '2':
					data[i].rtype = '費用';
					break;
				case '3':
					data[i].rtype = '估價單';
					break;
				default:
					data[i].rtype = '';
					break;
			}

			$('#result_table').append('<tr><td>'+(i+1)+'</td><td>'+data[i].dname+'</td><td>'+data[i].room+'</td><td>'+data[i].fix_item+'</td><td>'+data[i].sname+'</td><td>'+data[i].mobile+'&nbsp;&nbsp;<a id="item_click_'+data[i].fr_id+'" title="寄簡訊"><span class="glyphicon glyphicon-comment"></span></a></td><td>'+data[i].timestamp+'</td><td>'+(data[i].is_allow==0?'否':'<b>是</b>')+'</td><td><a onclick="showitem('+data[i].fr_id+')"><span class="glyphicon glyphicon-pencil"></span></a></td></tr>');				
			$('#item_click_'+data[i].fr_id).attr('onclick', 'sendsms("'+data[i].sname+'同學你好,", "'+data[i].mobile+'")');
		};

	}
// for 詳細合約資料
	// AJAX產生合約資料
	showitem(1);
	function showitem(fr_id){
		$('#viewModal').modal('toggle');
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "fr_id=" + fr_id;  
		xhr.open("POST", "<?=web_url('/service/show_fix_item')?>", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					var data = JSON.parse(xhr.responseText);
					if (data.state === true) {
						var datum = data.result;
						document.getElementById('view_dorm').value = datum.dname;
						document.getElementById('view_room').value = datum.room;
						document.getElementById('view_timestamp').value = datum.timestamp;
						document.getElementById('view_fix_item').value = datum.fix_item;
						document.getElementById('view_detail').value = datum.fix_detail;
						document.getElementById('view_is_allow').value = (datum.is_allow==0?'否':'是');
						document.getElementById('view_sname').value = datum.sname;
						document.getElementById('view_mobile').value = datum.mobile;


						document.getElementById('view_fr_id').value = datum.fr_id;
						//document.getElementById("room_select").innerHTML = xhr.responseText;  
						$('#view_sms').attr('onclick', 'sendsms("'+datum.sname+'同學你好,", "'+datum.mobile+'")');
					}else{
						errormsg('該筆資料不存在，請稍後在試');
					}
						
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
	}
	
	// 提示表單有變更
	function change_alert(){


		$('#edit_btn').attr('className', 'btn btn-warning btn-lg');
		$('#edit_btn').html('未儲存');
	}
	// 修改合約資料
	function edititem(){
		var state = 1;
		var rtype = document.getElementById('view_rtype').value
		var item = document.getElementById('view_item').value
		var type = document.getElementById('view_type').value
		var note = document.getElementById('view_note').value
		var company = document.getElementById('view_company').value
		var money = document.getElementById('view_money').value
		var date = document.getElementById('view_date').value
		var dorm = document.getElementById('view_dorm').value
		var billing = document.getElementById('view_billing').value
		var item_id = document.getElementById('view_item_id').value
		var errorstate = '';
		if (rtype==0) {
			errorstate+='收據類型沒填<br>';
			state=0;
		}else if (item==0) {
			errorstate+='名稱沒填<br>';
			state=0;
		}else if (type==0) {
			errorstate+='類別沒填<br>';
			state=0;
		}else if (company==0) {
			errorstate+='請款單位沒填<br>';
			state=0;
		}else if (money==0) {
			errorstate+='支出金額沒填<br>';
			state=0;
		}else if (date==0) {
			errorstate+='請款日期沒填<br>';
			state=0;
		}else if (dorm==0) {
			errorstate+='宿舍沒填<br>';
			state=0;
		}

		if (state) {
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			var data = 'rtype='+rtype+'&item='+item+'&type='+type+'&note='+note+'&company='+company+'&money='+money+'&date='+date+'&dorm='+dorm+'&billing='+billing+'&item_id='+item_id;
			xhr.open("POST", "<?=web_url('/accounting/itemedit')?>");
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
			xhr.send(data);  
			function display_datas() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// alert(xhr.responseText);
						if (JSON.parse(xhr.responseText.trim()).state===true) {
							document.getElementById('edit_btn').className = 'btn btn-info btn-lg';
							document.getElementById('edit_btn').innerHTML = '已儲存';
							// 更新表格裡的資訊
							table_refresh();
							$('#viewModal').modal('toggle');
						}
					} else {  
						alert('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}  
			xhr.onreadystatechange = display_datas;  
		}else{
			errormsg(errorstate);
		}
	}
	// 詳細資料裡的日期選擇
	$('#view_date').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	
	function new_item(){
		document.getElementById('view_rtype').value = null;
		document.getElementById('view_item').value = null;
		document.getElementById('view_type').value = null;
		document.getElementById('view_note').value = null;
		document.getElementById('view_company').value = null;
		document.getElementById('view_money').value = null;
		document.getElementById('view_date').value = null;
		document.getElementById('view_dorm').value = null;
		document.getElementById('view_billing').value = null;
		$("input[name='isrequest']").attr("checked",5);

		document.getElementById('view_manager').value = 0;
		document.getElementById('view_item_id').value = 0;
		$('#viewModal').modal('toggle');
	}
	function solution_table_refresh(){
		// 傳送
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "";  
		xhr.open("POST", "<?=web_url('/service/show_fix_list')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					solution_tableparse(xhr.responseText);
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	function solution_tableparse(json){
		data = JSON.parse(json);
		$('#solution_list').html('');
		for (var i = 0; i < data.length; i++) {


			$('#solution_list').append('<tr><td>'+(i+1)+'</td><td>'+data[i].dname+'</td><td>'+data[i].room+'</td><td>'+data[i].fix_item+'</td><td>'+data[i].sname+'</td><td>'+data[i].mobile+'&nbsp;&nbsp;<a id="item_click_'+data[i].fr_id+'" title="寄簡訊"><span class="glyphicon glyphicon-comment"></span></a></td><td>'+data[i].timestamp+'</td><td>'+(data[i].is_allow==0?'否':'<b>是</b>')+'</td><td><a onclick="showitem('+data[i].fr_id+')"><span class="glyphicon glyphicon-pencil"></span></a></td></tr>');				
			$('#item_click_'+data[i].fr_id).attr('onclick', 'sendsms("'+data[i].sname+'同學你好,", "'+data[i].mobile+'")');
		};
	}
</script>

<?php } ?>

