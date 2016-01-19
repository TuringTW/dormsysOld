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
		if (dorm_id>0) {
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
		};
			
	}
	function room_show_parse(data, type){

		for (var i = 0; i < data.length; i++) {
			if (type == '0') {

				$('#room_stu_select').append('<a href="#" class="btn btn-default roomstubtnlist" id="stu_select_'+data[i].stu_id+'" style="color:#003767; text-align:left; width:100%" onclick="stu_select('+data[i].stu_id+')">'+data[i].rname+'-'+data[i].sname+'</a>');
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
	function show_stu_list(id, type, contract_id){
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
							show_stu_info(data.result, type, contract_id)
							if (type==2) {
								$('.stubtnlist').attr('class', 'btn btn-default stubtnlist');
								$('#stu_info_'+contract_id).attr('class', 'btn btn-default stubtnlist active');						
							};
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
			$('#stu_select').append('<a href="#" class="btn btn-default stubtnlist" id="stu_info_'+data[i].contract_id+'" style="color:#003767; text-align:left; width:100%" onclick="show_stu_list('+data[i].stu_id+',2, '+data[i].contract_id+')">'+data[i].sname+'&nbsp;&nbsp;['+data[i].in_date+']</a>');
		};
	}
	function show_stu_info(data, type, contract_id){
		if (type == 0) {
			$('#stu_select').append('<a href="#" class="btn btn-default stubtnlist active" id="stu_info_'+data[0].stu_id+'" style="color:#003767; text-align:left; width:100%" onclick="show_stu_info('+data[0].stu_id+')">'+data[0].sname+'</a>')
		}
		$('#stu_info').html('<h5>聯絡資料</h5><table class="table table-hover">'
								+'<tr><th style="width:40%">姓名</th><td>'+data[0].sname+'</td><td><a href="#" id="stu_info_href"><span class="glyphicon glyphicon-user" title="學生資料"></span></a></td></tr>'
								+'<tr><th style="width:40%">單位</th><td colspan="2">'+data[0].school+'</td></tr>'
								+'<tr><th style="width:40%">手機</th><td>'+data[0].mobile+'</td><td><a id="stu_info_sms" onclick="sendsms(content, phone)"><span class="glyphicon glyphicon-comment" title="寄簡訊"></span></a></td></tr>'
								+'<tr><th style="width:40%">家電</th><td colspan="2">'+data[0].home+'</td></tr>'
								+'<tr><th style="width:40%">緊急聯絡</th><td colspan="2">'+data[0].emg_name+'</td></tr>'
								+'<tr><th style="width:40%">緊急電話</th><td colspan="2">'+data[0].emg_phone+'</td></tr>'
								+'<tr><th style="width:40%">通訊地址</th><td colspan="2">'+data[0].mailing_address+'</td></tr>'
								+'</table>'
								+'<h5>功能</h5><div class="row"><div class="col-sm-1"></div><div class="col-sm-10 btn-group"><a id="mail_btn" title="通知有信件或包裹到了" class="btn btn-default">信件通知&nbsp;&nbsp;<span class="glyphicon glyphicon-envelope"></span></a><a id="contract_btn" title="查看這筆聯絡資料對應的合約" class="btn btn-default">查看合約&nbsp;&nbsp;<span class="glyphicon glyphicon-file"></span></a></div></div>');
		$('#stu_info_href').attr('href', '<?=web_url("/student/index")?>?view='+data[0].stu_id);
		$('#stu_info_sms').click(function(){sendsms(data[0].sname+'同學你好,', data[0].mobile)});
		$('#mail_btn').click(function(){open_mail_modal(data[0].stu_id, data[0].sname, data[0].mobile)})
		if (contract_id==undefined) {
			contract_id = data[0].contract_id;
		}
		$('#contract_btn').attr('href', '<?=web_url("/contract/index")?>?contract_id='+contract_id)
	}

	function searchstu(){
		$('#room_stu_select').html('');
		$('#stu_select').html('');
		$('#stu_info').html('');
		keyword = $('#keyowrd_input').val();
		if (keyword.trim().length>0) {
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			var data = "keyword=" + keyword;  
			xhr.open("POST", "<?=web_url('/contact/searchnstu')?>");
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
			xhr.send(data);  
			function display_datas() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// alert(xhr.responseText);
						var data = JSON.parse(xhr.responseText.trim());
						stu_parse(data);

					} else {  
						errormsg('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}  
			xhr.onreadystatechange = display_datas
		};
			
	}
	function open_mail_modal(stu_id, sname, mobile){
		$('#mail_stu_select').html('');
		$('#mail_stu_select').append('<option id="mail_stu_select_'+stu_id+'" name="'+sname+'" phone="'+mobile+'" value="'+stu_id+'">'+sname+'-'+mobile+'</option>');
		$('#newmailModal').modal('toggle');

	}
	function add_mail_stu(){
		var stu_id = $('#mail_stu_select').val();
		var type = $('#type').val();
		var date = $('#date').val();
		var note = $('#note').val();

		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = 'stu_id='+stu_id+'&type='+type+'&date='+date+'&note='+note;

		xhr.open("POST", "<?=web_url('/service/add_stu_mail')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					// table_refresh();
					name = $('#mail_stu_select_'+stu_id).attr('name');
					phone = $('#mail_stu_select_'+stu_id).attr('phone');
					sendsms(name+"同學你好, 請到辦公室領取你的"+type, phone);
					$('#newmailModal').modal('toggle');
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;
	}
	function add_mail_nstu(){
		errormsg('這裡無法新增非學生信件')
	}
</script>


<?php } ?>

