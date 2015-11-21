<?php function js_section(){ ?>
<script type="text/javascript">

	// 更新想式的數量
	function table_refresh(){
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = '';
		xhr.open("POST", "<?=web_url('/service/show_mail')?>");
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

			$('#result_table').append('<tr><td>'+(i+1)+'</td><td>'+((data[i].sname==null)?'':data[i].sname)+((data[i].recname==null)?'':data[i].recname)+'</td><td>'+((data[i].mobile==null)?'':data[i].mobile)+((data[i].phone==null)?'':data[i].phone)+'</td><td><a href="#" id="table_'+i+'_sms" onclick="sendsms('+data[i].sname+'同學你好, 請到辦公室領取你的'+data[i].type+', '+data[i].mobile+')"><span class="glyphicon glyphicon-comment"></span></a></td><td>'+data[i].type+'</td><td>'+data[i].date+'</td><td>'+data[i].delay+'</td><td><a href="#" id="table_'+i+'_done"><span class="glyphicon glyphicon-ok"></span></a></td><td><a href="#"  id="table_'+i+'_remove"><span class="glyphicon glyphicon-remove"></span></a></td></tr>');				
			$('#table_'+i+'_sms').attr('onclick', 'sendsms("'+data[i].sname+'同學你好, 請到辦公室領取你的'+data[i].type+'", "'+data[i].mobile+'")');
			$('#table_'+i+'_done').attr('onclick', 'mail_done('+data[i].mail_id+')');
			$('#table_'+i+'_remove').attr('onclick', 'mail_remove('+data[i].mail_id+')');			
		}

	}


	function mail_done(mail_id){

		// 傳送
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "mail_id=" + mail_id;  
		xhr.open("POST", "<?=web_url('/service/mail_done')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					table_refresh();
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}

	function mail_remove(mail_id){

		// 傳送
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "mail_id=" + mail_id;  
		xhr.open("POST", "<?=web_url('/service/mail_remove')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					table_refresh();
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	function stu_suggestion_contract(){
		var keyword = $('#searchname').val();
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "keyword=" + keyword;  
		xhr.open("POST", "<?=web_url('/student/search_name')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					$('#mail_stu_select').html('');
					var data = JSON.parse(xhr.responseText).all;

					for (var i = data.length - 1; i >= 0; i--) {
						$('#mail_stu_select').append('<option id="mail_stu_select_'+data[i].stu_id+'" name="'+data[i].name+'" phone="'+data[i].mobile+'" value="'+data[i].stu_id+'">'+data[i].name+'-'+data[i].mobile+'</option>');
					};
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;
	}
	table_refresh();

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
					table_refresh();
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
		var recname = $('#recname').val();
		var phone = $('#phone').val();
		var type = $('#type_1').val();
		var date = $('#date_1').val();
		var note = $('#note_1').val();
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = 'recname='+recname+'&phone='+phone+'&type='+type+'&date='+date+'&note='+note; 
		xhr.open("POST", "<?=web_url('/service/add_nstu_mail')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					table_refresh();
					sendsms(recname+"同學你好, 請到辦公室領取你的平信", phone);
					$('#newmailModal').modal('toggle');
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;
	}
</script>
<?php } ?>

