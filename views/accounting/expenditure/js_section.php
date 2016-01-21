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
		var page = $('#page_value').val();
		var dorm = $('#dorm_select_value').val();
		var type = $('#type_select_value').val();
		var rtype = $('#rtype_select_value').val();
		$('#txtkeyword').focus();
		// if(due_value*ofd_value==1){
		// 	due_value = 0;
		// 	ofd_value = 0;
		// }

		if (page < 0) {
			page = 1;
		}

		// 傳送
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "keyword=" + keyword+"&page="+page+"&type="+type+"&dorm="+dorm+"&rtype="+rtype;  
		xhr.open("POST", "<?=web_url('/accounting/show_item_list')?>");
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

			$('#result_table').append('<tr><td>'+(page*30+i-29)+'</td><td>'+data[i].rtype+'</td><td>'+(data[i].item.length>11?data[i].item.substr(0,10):data[i].item)+'</td><td>'+data[i].cate+'</td><td>'+data[i].company+'</td><td>'+data[i].money+'</td><td>'+0+'</td><td>'+data[i].date+'</td><td>'+data[i].dname+'</td><td><a onclick="showitem('+data[i].item_id+')"><span class="glyphicon glyphicon-pencil"></span></a></td><td><a onclick=""><span class="glyphicon glyphicon-remove"></span></a></td></tr>');				
		};
		if (data.length<30) {
			$('#page_up').attr( "disabled", true );
		}else{
			$('#page_up').attr( "disabled", false );
		}	
	}
// for 詳細合約資料
	// AJAX產生合約資料
	function showitem(item_id){
		$('#viewModal').modal('toggle');
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "item_id=" + item_id;  
		xhr.open("POST", "<?=web_url('/accounting/show_item')?>", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					var data = JSON.parse(xhr.responseText);
					if (data.state === true) {
						var datum = data.data[0];
						document.getElementById('view_rtype').value = datum.rtype;
						document.getElementById('view_item').value = datum.item;
						document.getElementById('view_type').value = datum.type;
						document.getElementById('view_note').value = datum.note;
						document.getElementById('view_company').value = datum.company;
						document.getElementById('view_money').value = datum.money;
						document.getElementById('view_date').value = datum.date;
						document.getElementById('view_dorm').value = datum.dorm_id;
						document.getElementById('view_billing').value = datum.billing;
						$("input[name='isrequest']").attr("checked",datum.isrequest);

						document.getElementById('view_manager').value = datum.m_id;
						document.getElementById('view_item_id').value = datum.item_id;
						//document.getElementById("room_select").innerHTML = xhr.responseText;  
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
					}
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
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
</script>

<?php } ?>

