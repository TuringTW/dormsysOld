

<?php function js_section(){ ?>
<script type="text/javascript">

	$(function() {
		$( "#dpBirthday" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	});	
</script>
<script type="text/javascript">
	table_refresh();
	function keyword_serach(){
		pagemove(0);
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
		var keyword = $('#txtkeyword').val();
		var page = $('#page_value').val();
		$('#txtkeyword').focus();

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
		var data = "keyword=" + keyword+"&page="+page;  
		xhr.open("POST", "<?=web_url('/student/show')?>");
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
			$('#result_table').append('<tr><td>'+(page*30+i-29)+'</td><td>'+data[i].name+'</td><td>'+data[i].school+'</td><td>'+data[i].mobile+'</td><td>'+data[i].home+'</td><td>'+data[i].emg_name+'</td><td>'+data[i].emg_phone+'</td><td><a href="#" onclick="showstuinfo('+data[i].stu_id+')"><span class="glyphicon glyphicon-pencil"></span></a></td></tr>');				
		};
		if (data.length<30) {
			$('#page_up').attr( "disabled", true );
		}else{
			$('#page_up').attr( "disabled", false );
		}	
	}
	function showstuinfo(stu_id){
		
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "stu_id=" + stu_id;  
		xhr.open("POST", "<?=web_url('/student/show_stu_info')?>", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					var data = JSON.parse(xhr.responseText);
					if (data.state==true) {
						var datum = data.stu_info[0];
						document.getElementById('stu_id').value = datum.stu_id;			
						document.getElementById('view_name').value = datum.name;
						document.getElementById('view_school').value = datum.school;
						document.getElementById('view_mobile').value = datum.mobile;
						document.getElementById('view_sms').href = '#'+datum.stu_id;
						$('#view_sms').attr('onclick','sendsms("'+datum.name+'同學你好,", "'+datum.mobile+'")')
						document.getElementById('view_home').value = datum.home;
						document.getElementById('view_email').value = datum.email;
						document.getElementById('view_id_num').value = datum.id_num;
						document.getElementById('dpBirthday').value = datum.birthday;
						document.getElementById('view_emg_name').value = datum.emg_name;
						document.getElementById('view_emg_phone').value = datum.emg_phone;
						document.getElementById('view_reg_address').value = datum.reg_address;
						document.getElementById('view_mailing_address').value = datum.mailing_address;
						document.getElementById('view_note').value = datum.note;
						document.getElementById('view_car_id').value = datum.car_id;

						$('#view_contract_list').html('');
						if (data.countc>0) {
							datum = data.cdata;

							for (var i = 0; i< datum.length; i++) {
								item = datum[i];
								var text = ''
								switch(parseInt(item.seal)){
									case -1:
										text = '退宿';
										break;
									case 0:
										text = '正常';
										break;
									case 2:
										text = '待結算';
										break;
									case 3:
										text = '封存';
										break;
								}
								$('#view_contract_list').append('<tr><td>'+(i+1)+'</td><td>'+text+'</td><td>'+item.dname+'</td><td>'+item.rname+'</td><td>'+item.s_date+'</td><td>'+item.e_date+'</td><td>'+item.in_date+'</td><td>'+item.out_date+'</td><td><a href="#" id="contract_info_href_'+i+'"><span class="glyphicon glyphicon-file"></span></a></td></tr>');
								$('#contract_info_href_'+i).attr('href', '<?=web_url("/contract/index")?>?contract_id='+item.contract_id);
							};
						}
						$('#viewModal').modal('toggle');
					}else{
						errormsg('無法取得此筆資料，可能已遭刪除');  
					}

				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
	}
	function editstuinfo(){
		var name = $('#view_name').val();
		var school = $('#view_school').val();
		var mobile = $('#view_mobile').val();
		var home = $('#view_home').val();
		var email = $('#view_email').val();
		var id_num = $('#view_id_num').val();
		var birthday = $('#dpBirthday').val();
		var emg_name = $('#view_emg_name').val();
		var emg_phone = $('#view_emg_phone').val();		
		var reg_address = $('#view_reg_address').val();
		var mailing_address = $('#view_mailing_address').val();
		var note = $('#view_note').val();
		var car_id = $('#view_car_id').val();

		
		var stu_id = $('#stu_id').val();
		data = 'name=' + name + '&school=' + school + '&mobile=' + mobile +  '&home=' + home + '&email=' + email + '&id_num=' + id_num + '&birthday=' + birthday + '&emg_name=' + emg_name + '&emg_phone=' + emg_phone +'&reg_address=' +reg_address + '&mailing_address=' + mailing_address+'&note='+note+'&car_id='+car_id+'&stu_id='+stu_id;
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		xhr.open("POST", "<?=web_url('/student/edit')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					if (JSON.parse(xhr.responseText.trim())===true) {
						document.getElementById('btnSubmit').className = 'btn btn-info';
						document.getElementById('btnSubmit').innerHTML = '已儲存';
						$('#btnSubmit').attr('title','所有變更已儲存');
						// 更新表格裡的資訊
						table_refresh();
					}else{

						errormsg('儲存錯誤，請再試一次'+xhr.responseText);  
					}
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	function showedit(){
		document.getElementById('btnSubmit').className = 'btn btn-warning';
		document.getElementById('btnSubmit').innerHTML = '修改';
		$('#btnSubmit').attr('title','變更尚未儲存');
	}

	function showurlstu(){
		var open_stu_id = $('#open_stu_id').val();
		if (open_stu_id>0) {
			showstuinfo(open_stu_id);
		}
	}
	showurlstu();
</script>

<?php } ?>