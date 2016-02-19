<?php function js_section(){ ?>

<script type="text/javascript">
// for contractlist
	table_refresh();

	
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
						solution_table_refresh();
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
	function save_solution(method){
		var state = 1;
		var sr_id = document.getElementById('view_sr_id').value
		var fr_id = document.getElementById('view_fr_id').value
		var type = document.getElementById('soln_view_type').value
		var solution = document.getElementById('soln_view_solution').value
		var cost = document.getElementById('soln_view_cost').value
		var salary = document.getElementById('soln_view_salary').value
		var date = document.getElementById('soln_view_date').value
		var errorstate = '';
		if (type==null) {
			errorstate+='分類沒填<br>';
			state=0;
		}else if (solution=='') {
			errorstate+='處理方式沒填<br>';
			state=0;
		}else if (cost=='') {
			errorstate+='材料費沒填<br>';
			state=0;
		}else if (salary=='') {
			errorstate+='工資單位沒填<br>';
			state=0;
		}else if (date=='') {
			errorstate+='日期沒填<br>';
			state=0;
		}

		if (state) {
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			var data = 'type='+type+'&solution='+solution+'&cost='+cost+'&salary='+salary+'&date='+date+'&fr_id='+fr_id+'&sr_id='+sr_id;
			if (method==0) {
				xhr.open("POST", "<?=web_url('/service/save_solution')?>");
			}else{
				xhr.open("POST", "<?=web_url('/service/new_template')?>");
			}
			
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
			xhr.send(data);  
			function display_datas() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// alert(xhr.responseText);
						if (JSON.parse(xhr.responseText.trim()).state===true) {
							if (method==0) {
								document.getElementById('edit_btn').className = 'btn btn-info btn-lg';
								document.getElementById('edit_btn').innerHTML = '已儲存';
								// 更新表格裡的資訊
								solution_table_refresh();
							}else{
								successmsg('新增成功');
							}
								

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
	
	function new_solution(){
		//reset value
		document.getElementById('soln_view_type').value = null;
		document.getElementById('soln_view_solution').value = null;
		document.getElementById('soln_view_cost').value = null;
		document.getElementById('soln_view_salary').value = null;
		document.getElementById('soln_view_date').value = null;
		$('#view_sr_id').val(0);
		$('#soln_view_template').html('<option  class="form-control">請選擇...</option>');
		$('#soln_view_template').removeAttr('disabled');


		$("#soln_view_type").focus();

		//show item
		$("#view_new_solution_lbl").css("display", "inline");
		$("#add_to_template_btn").css("display", "none");

	}

	function solution_table_refresh(){
		var fr_id = $("#view_fr_id").val();
		// 傳送
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "fr_id="+fr_id;  
		xhr.open("POST", "<?=web_url('/service/show_solution_list')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					var data = JSON.parse(xhr.responseText);
					if (data.state == true) {

					};
					solution_tableparse(data.result);
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	function solution_tableparse(data){
		
		$('#solution_list').html('');
		for (var i = 0; i < data.length; i++) {
			$('#solution_list').append('<tr style="text-align:center"><td>'+(i+1)+'</td><td>'+data[i].type+'</td><td>'+data[i].solution+'</td><td>'+data[i].cost+'</td><td>'+data[i].salary+'</td><td><a onclick="showsoltion('+data[i].sr_id+')"><span class="glyphicon glyphicon-pencil"></span></a></td><td><a onclick="removesoltion('+data[i].sr_id+')"><span class="glyphicon glyphicon-remove"></span></a></td></tr>');				
		};
	}
	function showsoltion(sr_id){
		//turn off something
		$("#view_new_solution_lbl").css("display", "none");
		$("#add_to_template_btn").css("display", "inline");
		$('#soln_view_template').html('<option  class="form-control">請選擇...</option>');
		$('#soln_view_template').attr('disabled', 'true');
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "sr_id="+sr_id;  
		xhr.open("POST", "<?=web_url('/service/show_soltion_item')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					var data = JSON.parse(xhr.responseText);
					if (data.state == true) {
						var datum = data.result
						document.getElementById('soln_view_type').value = datum.type;
						document.getElementById('soln_view_solution').value = datum.solution;
						document.getElementById('soln_view_cost').value = datum.cost;
						document.getElementById('soln_view_salary').value = datum.salary;
						document.getElementById('soln_view_date').value = datum.date;
						$('#view_sr_id').val(datum.sr_id);
						$("#add_to_template_btn").css("display", "inline");
					};
					
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	function type_select(){
		var type = $('#soln_view_type').val();
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "type="+type;  
		xhr.open("POST", "<?=web_url('/service/show_template_by_type')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					var data = JSON.parse(xhr.responseText);
					if (data.state == true) {
						$('#soln_view_template').html('<option  class="form-control">請選擇...</option>');
						
						for (var i = data.result.length - 1; i >= 0; i--) {
							var datum = data.result;
							$('#soln_view_template').append('<option value="'+datum[i].st_id+'">'+datum[i].solution+'</option>');
						};
					}
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;
	}
	function type_select_auto_fill_in(){
		var template = $('#soln_view_template').val();
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "template="+template;  
		xhr.open("POST", "<?=web_url('/service/select_template')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					var data = JSON.parse(xhr.responseText);
					if (data.state === true) {
						datum = data.result;
						document.getElementById('soln_view_type').value = datum.type_id;
						document.getElementById('soln_view_solution').value = datum.solution;
						document.getElementById('soln_view_cost').value = datum.cost;
						document.getElementById('soln_view_salary').value = datum.salary;
						$('#soln_view_date').focus();
					}else{
						errormsg('模板標號可能錯誤');  	
					}
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;
	}
	function removesoltion(sr_id){
		var template = $('#soln_view_template').val();
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		} 
		if (confirm('確定要刪除嗎?')) {
			var data = "sr_id="+sr_id;  
			xhr.open("POST", "<?=web_url('/service/remove_soltion')?>");
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
			xhr.send(data);  
			function display_datas() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// alert(xhr.responseText);   
						var data = JSON.parse(xhr.responseText);
						if (data.state === true) {
							successmsg('刪除成功')
							solution_table_refresh();
						}else{
							errormsg('模板標號可能錯誤');  	
						}
					} else {  
						errormsg('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}  
			xhr.onreadystatechange = display_datas;
		}; 
			
	}
	function finish(){
		var fr_id = $('#view_fr_id').val();
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "fr_id="+fr_id;  
		xhr.open("POST", "<?=web_url('/service/fix_finish')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					var data = JSON.parse(xhr.responseText);
					if (data.state === true) {
						successmsg('處理完成');
						table_refresh();
						$('#viewModal').modal('toggle');
					}else{
						errormsg('模板標號可能錯誤');  	
					}
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;
	}
	
	$('#soln_view_date').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
</script>

<?php } ?>

