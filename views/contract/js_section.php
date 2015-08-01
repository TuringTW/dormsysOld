<?php function js_section(){ ?>

<script type="text/javascript">
	function dorm_select(dorm_id, dorm_name){
		$('#lbldorm').html(dorm_name);
		$('#dorm_select_value').val(dorm_id);
		table_refresh();
	}

	function table_refresh(){
		var keyword = $('#txtkeyword').val();
		var page = $('#page_value').val();
		var due_value = $('#due_value').val();
		var ofd_value = $('#ofd_value').val();
		var dorm = $('#dorm_select_value').val();

		if(due_value*ofd_value==1){
			due_value = 0;
			ofd_value = 0;
		}

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
		var data = "keyword=" + keyword+"&page="+page+"&due_value="+due_value+"&ofd_value="+due_value+"&dorm="+dorm;  
		xhr.open("POST", "<?=web_url('/contract/show')?>");
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
		if (data.length !== 0) {
			$('#result_table').html('');
			for (var i = 0; i < data.length; i++) {
				$('#result_table').append('<tr><td>'+(page*30+i-29)+'</td><td>'+data[i].sname+'</td><td>'+data[i].dname+'</td><td>'+data[i].rname+'</td><td>'+data[i].s_date+'</td><td>'+data[i].e_date+'</td><td>'+data[i].in_date+'</td><td>'+data[i].out_date+'</td><td><a href="#"><span class="glyphicon glyphicon-pencil"></span></a></td></tr>');
				
			};
		};
		
	}
</script>

<?php } ?>