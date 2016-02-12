<?php function js_section(){ ?>
<script type="text/javascript">
	table_refresh();
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
		var data = "";  
		xhr.open("POST", "<?=web_url('/service/show_sms_collection')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					tableparse(xhr.responseText);
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	function tableparse(json){
		data = JSON.parse(json);
		$('#result_table').html('');
		for (var i = 0; i < data.length; i++) {

			var type_text = '';
			switch(data[i].type){
				case "0":
					type_text = '一般';
					break;
			}
			$('#result_table').append('<tr><td>'+(i+1)+'</td><td>'+type_text+'</td><td style="text-align:left;">'+data[i].content+'</td></tr>');				
		};
		if (data.length<30) {
			$('#page_up').attr( "disabled", true );
		}else{
			$('#page_up').attr( "disabled", false );
		}	
	}

	function add_sms_collection(){
		var content = $('#content').val();
		var type = $('#type').val();

		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = 'content='+content+'&type='+type;

		xhr.open("POST", "<?=web_url('/service/add_sms_collection')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);   
					table_refresh();
					successmsg("新增成功");
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;
	}


	
</script>
<?php } ?>

