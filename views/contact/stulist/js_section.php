<?php function js_section(){ ?>
<script type="text/javascript">
	function dorm_select(dorm_id){
		// refresh dorm list
		$('.dormbtnlist').attr('class', 'btn btn-default dormbtnlist');
		$('#dorm_select_'+dorm_id).attr('class', "btn btn-default dormbtnlist active");
		var type = $('#show_type_select').val();
		room_stu_show(type, dorm_id);
	}
	function room_stu_show(type, dorm_id){
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
	}
	function room_show_parse(data){
		$('#room_stu_select').html('');
		for (var i = data.length - 1; i >= 0; i--) {
			$('#room_stu_select').append('<a href="#" class="btn btn-default roomstubtnlist" id="stu_room_select_'+data[i].stu_id+'" style="color:#003767; text-align:left; width:100%" onclick="stu_select('+data[i].stu_id+')">'+data[i].rname+'-'+data[i].sname+'</a>');
		};
	}
</script>


<?php } ?>

