<?php function js_section(){ ?>
<script type="text/javascript">
	function dorm_select(dorm_id){
		// refresh dorm list
		$('.dormbtnlist').attr('class', 'btn btn-default dormbtnlist');
		$('#dorm_select_'+dorm_id).attr('class', "btn btn-default dormbtnlist active");
		$('#dorm_select_id').val(dorm_id);
		room_show(dorm_id);
	}
	function add_new_room(){
		clean_room_data();
		$('#new_option').css('display', 'inline');
		$('#room_name').focus();

	}
	function clean_room_data(){
		$('#room_name').val("");
		$('#rent').val("");
		$('#type_select').val();
		$('#note').val("");
		$('#room_id').val(0);
		$('#new_option').css('display', 'none');

	}
	function room_show(dorm_id){
		$('#room_select').html('');
		clean_room_data();
		if (dorm_id>0) {
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			var data = "dorm_id=" + dorm_id;  
			xhr.open("POST", "<?=web_url('/Utility/room_suggestion')?>");
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
			xhr.send(data);  
			function display_datas() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// alert(xhr.responseText);
						var data = JSON.parse(xhr.responseText.trim());

						if (data.state===true) {
							// 更新表格裡的資訊
							room_show_parse(data.result);
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
			$('#room_select').append('<a href="#" class="btn btn-default roomstubtnlist" id="room_select_'+data[i].room_id+'" style="color:#003767; text-align:left; width:100%" onclick="room_select('+data[i].room_id+')">'+data[i].name+'&nbsp;&nbsp;&nbsp;&nbsp;'+data[i].type+'&nbsp;&nbsp;&nbsp;&nbsp;'+data[i].rent+'元</a>');
		};
	}
	
	function room_select(room_id){  
		clean_room_data();
		$('.roomstubtnlist').attr('class', 'btn btn-default roomstubtnlist');
		$('#room_select_'+room_id).attr('class', 'btn btn-default roomstubtnlist active');

		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "room_id=" + room_id;  
		xhr.open("POST", "<?=web_url('/utility/get_room_info')?>", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);    
					data = JSON.parse(xhr.responseText);    
					$('#room_name').val(data.rname);
					$('#rent').val(data.rent);
					$('#type_select').val(data.type);
					$('#note').val(data.note);
					$('#room_id').val(room_id);
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
	}

	function edit_room_info(){
		var room_name = $('#room_name').val();
		var rent = $('#rent').val();
		var type_select = $('#type_select').val();
		var note = $('#note').val();
		var room_id = $('#room_id').val();
		var dorm_id = $('#dorm_select_id').val();
		
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "room_name="+room_name+"&rent="+rent+"&type_select="+type_select+"&note="+note+"&room_id="+room_id+"&dorm_id="+dorm_id;
		xhr.open("POST", "<?=web_url('/database/edit_room_info')?>", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);    
					data = JSON.parse(xhr.responseText);    
					if (data.state == true) {
						successmsg("更新成功");
						room_show(dorm_id);

					}else{
						errormsg("更新時發生錯誤"+xhr.responseText);
					}
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		
	}


</script>


<?php } ?>

