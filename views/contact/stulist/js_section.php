<?php function js_section(){ ?>
<script type="text/javascript">
	function dorm_select(dorm_id){
		// refresh dorm list
		$('.dormbtnlist').attr('class', 'btn btn-default dormbtnlist');
		$('#dorm_select_'+dorm_id).attr('class', "btn btn-default dormbtnlist active");
		$('#dorm_select_id').val(dorm_id);
		var type = $('#show_type_select').val();
		room_stu_show(type, dorm_id);
	}
	function room_stu_show(type, dorm_id){
		$('#room_stu_select').html('');
		$('#stu_select').html('');
		$('#stu_info').html('');
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "dorm_id=" + dorm_id + "&type="+type;  
		xhr.open("POST", "<?=web_url('/contact/room_stu_show')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					var data = JSON.parse(xhr.responseText.trim());

					if (data.state===true) {
						// 更新表格裡的資訊
						room_show_parse(data.result, type);
					}else{
						errormsg('傳送錯誤，請再試一次'+xhr.responseText);  
					}
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	function room_show_parse(data, type){

		for (var i = 0; i < data.length; i++) {
			if (type == '0') {

				$('#room_stu_select').append('<a href="#" class="btn btn-default roomstubtnlist" id="stu_select_'+data[i].contract_id+'" style="color:#003767; text-align:left; width:100%" onclick="stu_select('+data[i].contract_id+')">'+data[i].rname+'-'+data[i].sname+'</a>');
			}else{
				$('#room_stu_select').append('<a href="#" class="btn btn-default roomstubtnlist" id="room_select_'+data[i].room_id+'" style="color:#003767; text-align:left; width:100%" onclick="room_select('+data[i].room_id+')">'+data[i].name+'</a>');
			}
		};
	}
	function select_stu_room(type){
		var dorm_id = $('#dorm_select_id').val();
		$('.show_type_btn').attr('class', 'btn btn-default show_type_btn');
		$('#show_type_btn_'+type).attr('class', 'btn btn-default show_type_btn active');
		$('#show_type_select').val(type);

		room_stu_show(type, dorm_id);
	}
	function stu_select(contract_id){
		$('#stu_select').html('');
		$('#stu_info').html('');

		$('.roomstubtnlist').attr('class', 'btn btn-default roomstubtnlist');
		$('#stu_select_'+contract_id).attr('class', 'btn btn-default roomstubtnlist active');

		show_stu_list(contract_id, 0);		
	}
	function room_select(room_id){
		$('#stu_select').html('');
		$('#stu_info').html('');

		$('.roomstubtnlist').attr('class', 'btn btn-default roomstubtnlist');
		$('#room_select_'+room_id).attr('class', 'btn btn-default roomstubtnlist active');

		show_stu_list(room_id, 1);		
	}
	function show_stu_list(id, type){
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		if (type==2) {
			var data = "id=" + id + "&type="+0;  
		}else{
			var data = "id=" + id + "&type="+type; 
		}
		
		xhr.open("POST", "<?=web_url('/contact/stu_show')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					var data = JSON.parse(xhr.responseText.trim());
					if (data.state===true) {
						// 更新表格裡的資訊
						if (type == 1) {
							stu_parse(data.result);
						}else{
							show_stu_info(data.result, type)
						}
					}else{
						errormsg('傳送錯誤，請再試一次'+xhr.responseText);  
					}
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	function stu_parse(data){
		for (var i = 0; i < data.length ;  i++) {
			$('#stu_select').append('<a href="#" class="btn btn-default stubtnlist" id="stu_info_'+data[i].contract_id+'" style="color:#003767; text-align:left; width:100%" onclick="show_stu_list('+data[i].contract_id+',2)">'+data[i].sname+'</a>');
		};
	}
	function show_stu_info(data, type){
		if (type == 0) {
			$('#stu_select').append('<a href="#" class="btn btn-default stubtnlist active" id="stu_info_'+data[0].stu_id+'" style="color:#003767; text-align:left; width:100%" onclick="show_stu_info('+data[0].stu_id+')">'+data[0].sname+'</a>')
		}
		$('#stu_info').html('<table class="table table-hover">'
								+'<tr><th style="width:40%">姓名</th><td>'+data[0].sname+'</td></tr>'
								+'<tr><th style="width:40%">單位</th><td>'+data[0].school+'</td></tr>'
								+'<tr><th style="width:40%">手機</th><td>'+data[0].mobile+'</td></tr>'
								+'<tr><th style="width:40%">家電</th><td>'+data[0].home+'</td></tr>'
								+'<tr><th style="width:40%">緊急聯絡</th><td>'+data[0].emg_name+'</td></tr>'
								+'<tr><th style="width:40%">緊急電話</th><td>'+data[0].emg_phone+'</td></tr>'
								+'<tr><th style="width:40%">通訊地址</th><td>'+data[0].mailing_address+'</td></tr>'
								+'</table>')
	}
</script>


<?php } ?>

