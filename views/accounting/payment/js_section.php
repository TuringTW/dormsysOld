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
	// 時間查詢
	function date_serach(){
		pagemove(0);
		table_refresh();
	}
	function resetdate(){
		$('#txtdate').val('');
		$('#txtdate').focus();
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
		// var keyword = $('#txtkeyword').val();
		var date = $('#txtdate').val();
		var page = $('#page_value').val();
		var dorm = $('#dorm_select_value').val();
		var type = $('#type_select_value').val();
		var rtype = $('#rtype_select_value').val();
		$('#txtkeyword').focus();
		if (page < 0) {
			page = 1;
		}
		var data = "date=" + date+"&page="+page;
		post('/accounting/show_pay_rent_list', data, callback, 0);
		function callback(data){
			tableparse(data);
		}
	}
	function tableparse(data){
		var page = $('#page_value').val();
		$('#result_table').html('');
		for (var i = 0; i < data.length; i++) {
			$('#result_table').append('<tr><td>'+(page*30+i-29)+'</td><td>'+data[i].dname+'</td><td>'+data[i].rname+'</td><td><a href="#" id="payment_href_'+data[i].id+'" title="查看合約"><span class="glyphicon glyphicon-file"></span></a></td><td>'+data[i].customer+'</td><td>'+data[i].value+'</td><td>'+data[i].description+'</td><td>'+data[i].date+'</td></tr>');
			$('#payment_href_'+data[i].id).attr('href', '<?=web_url('/contract/index')?>?contract_id='+data[i].contract_id);
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
		var data = "item_id=" + item_id;
		post('/accounting/show_item', data, callback, 0);
		function callback(data){
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
	$('#txtdate').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true, numberOfMonths: 3});

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
