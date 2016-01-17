<?php function js_section(){ ?>
<script type="text/javascript">
	function show_mail_modal(){
		$("#newmailModal").modal('toggle');
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

