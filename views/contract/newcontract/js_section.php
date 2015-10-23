<?php function js_section(){ ?>
<script type="text/javascript">
// 學生資料
	function stu_suggestion(){  
		var name =$('#add_stu_info_search').val(); 
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "keyword=" + name;
		xhr.open("POST", "<?=web_url('/student/search_name')?>", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// errormsg(xhr.responseText);        
					var data = JSON.parse(xhr.responseText);
					var htmltext = '';
					htmltext += "<div class='list-group' style='position: relative; width: 100%; max-height: 300px; overflow: auto;'>";
					if (data.today.length>0) {
						htmltext += "<a class='list-group-item' style='background-color:lightgray'>今日新增</a>";
						for (var i = data.today.length - 1; i >= 0; i--) {
							htmltext += "<a class='list-group-item' onclick='checkreselect("+data.today[i].stu_id+")'>"+data.today[i].name+'-'+data.today[i].mobile+"</a>";  
						};
					}
					if (data.all.length>0) {
						htmltext += "<a class='list-group-item' style='background-color:lightgray'>相關"+data.all.length+"筆</a>";
						for (var i = data.all.length - 1; i >= 0; i--) {
							htmltext += "<a class='list-group-item' onclick='checkreselect("+data.all[i].stu_id+")'>"+data.all[i].name+'-'+data.all[i].mobile+"</a>";  
						};
					}
					htmltext += '</div>';
					$('#stu_search_result').html(htmltext);
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
	} 
	// 檢查是否已新增此人
	function checkreselect(stu_id){
		document.getElementById('submitbtn').disabled=true;
		var x = document.getElementById('stuinfosubmit');
		//errormsg(x.childNodes.length);
		max = Number(x.childNodes.length);
		//errormsg('max='+max);
		var state =1;
		for (var i = 1; i < max; i++) {
			//errormsg(i+'='+x.childNodes[i].value);
			if (stu_id == x.childNodes[i].value) {
				state = 0;
			};
		};
		if (state) {
			addstuinfo(stu_id);
		}else{
			errormsg('已新增過此人');
			//清除搜尋結果
			document.getElementById('stu_search_result').innerHTML = "";
			document.getElementById('add_stu_info_search').value = "";

		}
	}
	// 檢查資料庫是否有重複
	function checkreadd(key, stu_id){
		if (1) {
			var name = document.getElementById('stu_'+key+'_name').value;
			var mobile = document.getElementById('stu_'+key+'_mobile').value;
			var idnum = document.getElementById('stu_'+key+'_idnum').value;
			var data = 'id_num='+idnum+'&name='+name+'&mobile='+mobile;
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			xhr.open("POST", "<?=web_url('/student/checkdoubleadd')?>", true);   
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
			xhr.send(data);  
			xhr.onreadystatechange = display_data;  
			function display_data() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// errormsg(xhr.responseText);
						data = JSON.parse(xhr.responseText);
						if (data == true) {
							errormsg('資料庫中已有此人!!!!\n請勿重複新增!!!!\n'+xhr.responseText);
							document.getElementById('stu_'+key+'_btn').disabled = true;
						}else{
							document.getElementById('stu_'+key+'_btn').disabled = false;

						}
							 
					} else {  
						errormsg('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}
		}			
	}
	function addstuinfo(stu_id){
		document.getElementById('submitbtn').disabled=true;
		var key = document.getElementById('key').value;
		key = Number(key)+1;
		document.getElementById('key').value = key;	
		// errormsg(stu_id+' '+key);
		if (stu_id == 0) {
			data = JSON.parse('{"stu_id":"","name":"","sex":"","school":"","mobile":"","home":"","reg_address":"","mailing_address":"","email":"","id_num":"","birthday":"","emg_name":"","emg_phone":"","note":""}')
			$('#accordion').append(stu_info_gen(data, key, stu_id));
			$(function() {$( '#stu_'+key+'_birthday' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});})
		}else{
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			var data = "stu_id=" + stu_id;
			xhr.open("POST", "<?=web_url('/student/add_stu_info')?>", true);   
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
			xhr.send(data);  
			xhr.onreadystatechange = display_data;  
			function display_data() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// errormsg(xhr.responseText);   
						data = JSON.parse(xhr.responseText);
						// errormsg(document.getElementById('accordion').innerHTML);
						$('#accordion').append(stu_info_gen(data, key, stu_id));
						if (stu_id!==0) {
							$('#final_stu_list').append('<tr id="final_stu_'+key+'"><td>'+data.name+'</td><td>'+data.mobile+'</td><tr>');		
						};

						$(function() {$( '#stu_'+key+'_birthday' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});})
					} else {  
						errormsg('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}

			//清除搜尋結果
			document.getElementById('stu_search_result').innerHTML = "";
			document.getElementById('add_stu_info_search').value = "";

			//新增submit的資料
			if (stu_id!=0) {
				document.getElementById('stuinfosubmit').innerHTML += "<input type='hidden' name='stu_id[]' id='stu_id_"+key+"_submit' value="+stu_id+">"
				get_rent_cal();
			};
		}			
	}
	function stu_info_gen(data, key, stu_id){

		var htmltext = '';
						htmltext+=' <div class="panel panel-default" id="stu_info_'+key+'">'
						htmltext+=' <div class="panel-heading">'
						htmltext+=' <h4 class="panel-title">'
						htmltext+=' <a data-toggle="collapse" data-parent="#accordion" href="#stu_info_detail_'+key+'">'
						htmltext+=' <!-- 簡要資料橫排 -->'
						htmltext+=' <table class="table-bordered" style="width:100%; text-align:center;">'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:10%"><h4><span id="stu_'+key+'_banner_name">'+((data.name=='')?'姓名':data.name)+'</span></h4></td>'
						htmltext+=' <td><h4><span id="stu_'+key+'_banner_mobile">'+((data.mobile=='')?'行動電話':data.mobile)+'</span></h4></td>'
						htmltext+=' <td style="width:15%"><h4><span id="stu_'+key+'_banner_home">'+((data.home=='')?'家裡電話':data.home)+'</span></h4></td>'
						htmltext+=' <td style="width:15%"><h4><span id="stu_'+key+'_banner_idnum">'+((data.id_num=='')?'身分證字號':data.id_num)+'</span></h4></td>'
						htmltext+=' <td style="width:10%"><h4><span id="stu_'+key+'_banner_birthday">'+((data.birthday=='')?'生日':data.birthday)+'</span></h4></td>'
						htmltext+=' <td style="width:10%"><h4><span id="stu_'+key+'_banner_emg_name">'+((data.emg_name=='')?'緊急聯絡人':data.emg_name)+'</span></h4></td>'
						htmltext+=' <td style="width:20%"><h4><span id="stu_'+key+'_banner_emg_phone">'+((data.emg_phone=='')?'緊急連絡電話':data.emg_phone)+'</span></h4></td>'
						htmltext+=' <td id="stu_'+key+'_remove" style="width:5%"><h4><a href="#" onClick="removestuinfo('+key+')"><span class="glyphicon glyphicon-remove"></span></a></h4></td>'
						htmltext+=' </tr></table></a></h4></div>'

						htmltext+=' <div id="stu_info_detail_'+key+'" class="panel-collapse collapse in" >'
						htmltext+=' <!-- 細步資料 -->'
						htmltext+=' <div class="panel-body">'
						htmltext+=' <div class="row" style="width:100%">'
						htmltext+=' <div class="col-md-5">'
						htmltext+=' <h5>個人資料</h5>'
						htmltext+=' <table class="table " style="100%">'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:25%" align="right">*名字</td>'
						htmltext+=' <td><input class="form-control" required id="stu_'+key+'_name" placeholder="請輸入承租戶姓名" style="" type="text"  value="'+data.name+'" onChange="bannerrefresh('+key+',0);checkreadd('+key+','+stu_id+');"></td>'
						htmltext+=' </tr>'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:25%" align="right">學校/單位</td>'
						htmltext+=' <td><input class="form-control"  id="stu_'+key+'_school" placeholder="學校系級或工作單位" style="" type="text"  value="'+data.school+'" onChange="bannerrefresh('+key+',-1)"></td>'
						htmltext+=' </tr>'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:25%" align="right">*身分證字號</td>'
						htmltext+=' <td><input class="form-control" required id="stu_'+key+'_idnum" placeholder="(ex:A123456789)" style="" type="text"  value="'+data.id_num+'" onChange="bannerrefresh('+key+',1);checkreadd('+key+','+stu_id+');"></td>'
						htmltext+=' </tr>'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:25%" align="right">*生日</td>'
						htmltext+=' <td><input class="form-control" required id="stu_'+key+'_birthday" placeholder="(1900-1-1)" style="" type="text"  value="'+data.birthday+'" onChange="bannerrefresh('+key+',2)"></td>'
						htmltext+=' </tr>'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:25%" align="right">備註</td>'
						htmltext+=' <td><textarea class="form-control" id="stu_'+key+'_note" rows="5" style="resize:none"></textarea></td>'
						htmltext+=' </tr>'
						htmltext+=' </table>'
						htmltext+=' </div>'
						htmltext+=' <div class="col-md-6">'
						htmltext+=' <h5>聯絡資料</h5>'
						htmltext+=' <table class="table " style="100%">'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:28%" align="right">*手機</td>'
						htmltext+=' <td><input class="form-control" required id="stu_'+key+'_mobile" placeholder="請輸入個人行動電話號碼" style="" type="text"  value="'+data.mobile+'" onChange="bannerrefresh('+key+',3);checkreadd('+key+','+stu_id+')"></td>'
						htmltext+=' </tr>'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:28%" align="right">家裡電話</td>'
						htmltext+=' <td><input class="form-control"  id="stu_'+key+'_home" placeholder="請輸入家中室內電話號碼" style="" type="text"  value="'+data.home+'" onChange="bannerrefresh('+key+',4)"></td>'
						htmltext+=' </tr>'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:28%" align="right">E-mail</td>'
						htmltext+=' <td><input class="form-control"  id="stu_'+key+'_email" placeholder="請輸入常用電子郵件號碼" style="" type="text"  value="'+data.email+'" onChange="bannerrefresh('+key+',-1)"></td>'
						htmltext+=' </tr>'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:28%" align="right">*戶籍地址</td>'
						htmltext+=' <td><input class="form-control"  id="stu_'+key+'_reg_address" placeholder="請輸入戶籍地址" style="" type="text"  value="'+data.reg_address+'" onChange="bannerrefresh('+key+',-1)"></td>'
						htmltext+=' </tr>'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:28%" align="right">*通訊地址</td>'
						htmltext+=' <td>'
						htmltext+=' <div class="row">'
						htmltext+=' 	<div class="col-md-9"><input class="form-control"  id="stu_'+key+'_mailing_address" placeholder="請輸入通訊地址" style="" type="text"  value="'+data.mailing_address+'" onChange="bannerrefresh('+key+',-1)"></div>'
						htmltext+=' 	<div class="col-md-3"><a class="form-control btn btn-default" onclick="sameasreg('+key+')">同上</a></div>'
						htmltext+=' </div></td></tr><tr>'

						htmltext+=' <td style="width:28%" align="right">*緊急聯絡人</td>'
						htmltext+=' <td><input class="form-control" required id="stu_'+key+'_emg_name" placeholder="請輸入緊急聯絡人姓名" style="" type="text"  value="'+data.emg_name+'" onChange="bannerrefresh('+key+',5)"></td>'
						htmltext+=' </tr>'
						htmltext+=' <tr>'
						htmltext+=' <td style="width:28%" align="right">*緊急聯絡人電話</td>'
						htmltext+=' <td><input class="form-control" required id="stu_'+key+'_emg_phone" placeholder="請輸入緊急聯絡人電話" style="" type="text"  value="'+data.emg_phone+'" onChange="bannerrefresh('+key+',6)"></td>'
						htmltext+=' </tr>'
						htmltext+=' </table>'
						htmltext+=' </div>'
						htmltext+=' <div class="col-md-1">'
						htmltext+=' <h5>控制</h5>'
						htmltext+=' <button id="stu_'+key+'_btn" style="width:100%" onClick="submitstuinfo('+key+');" class="btn btn-primary">儲存</button>'
						htmltext+=' <input type="hidden" value="'+stu_id+'" id="stu_'+key+'_stu_id">'
						htmltext+=' </div>'
						htmltext+=' </div>'
						htmltext+=' '
						htmltext+=' </div>'
						htmltext+=' </div>'
						htmltext+=' </div>'
		return htmltext;
	}
	function removestuinfo(key){
		document.getElementById('submitbtn').disabled=true;
		if(confirm("確定要刪除嗎？")){
			var remove_item = document.getElementById('stu_info_'+key);
			remove_item.parentElement.removeChild(remove_item);

			var remove_item = document.getElementById('stu_id_'+key+'_submit');
			remove_item.parentElement.removeChild(remove_item);

			var remove_item = document.getElementById('final_stu_'+key);
			remove_item.parentElement.removeChild(remove_item);


		}	
	}
	function bannerrefresh(key,item){
		document.getElementById('stu_'+key+'_btn').className = 'btn btn-warning';
		document.getElementById('submitbtn').disabled=true;
		switch(item){
			case 0:
				document.getElementById('stu_'+key+'_banner_name').innerHTML = document.getElementById('stu_'+key+'_name').value;
				break;
			case 1:
				document.getElementById('stu_'+key+'_banner_idnum').innerHTML = document.getElementById('stu_'+key+'_idnum').value;
				break;
			case 2:
				document.getElementById('stu_'+key+'_banner_birthday').innerHTML = document.getElementById('stu_'+key+'_birthday').value;
				break;
			case 3:
				document.getElementById('stu_'+key+'_banner_mobile').innerHTML = document.getElementById('stu_'+key+'_mobile').value;
				break;
			case 4:
				document.getElementById('stu_'+key+'_banner_home').innerHTML = document.getElementById('stu_'+key+'_home').value;
				break;
			case 5:
				document.getElementById('stu_'+key+'_banner_emg_name').innerHTML = document.getElementById('stu_'+key+'_emg_name').value;
				break;
			case 6:
				document.getElementById('stu_'+key+'_banner_emg_phone').innerHTML = document.getElementById('stu_'+key+'_emg_phone').value;
				break;

		}
	}
	function sameasreg(key){

		document.getElementById('stu_'+key+'_mailing_address').value = document.getElementById('stu_'+key+'_reg_address').value;	
	}	
	// 更新學生資料
	function submitstuinfo(key){
		document.getElementById('submitbtn').disabled=true;
		var name = document.getElementById('stu_'+key+'_name').value;
		var school = document.getElementById('stu_'+key+'_school').value;
		var idnum = document.getElementById('stu_'+key+'_idnum').value;
		var birthday = document.getElementById('stu_'+key+'_birthday').value;
		var note = document.getElementById('stu_'+key+'_note').value;
		var mobile = document.getElementById('stu_'+key+'_mobile').value;
		var home = document.getElementById('stu_'+key+'_home').value;
		var email = document.getElementById('stu_'+key+'_email').value;
		var reg_address = document.getElementById('stu_'+key+'_reg_address').value;
		var mailing_address = document.getElementById('stu_'+key+'_mailing_address').value;
		var emg_name = document.getElementById('stu_'+key+'_emg_name').value;
		var emg_phone = document.getElementById('stu_'+key+'_emg_phone').value;
		var stu_id = document.getElementById('stu_'+key+'_stu_id').value;



		var check = 1;
		var checkinfo = '請完整填寫以下:\n';
		if(name==''){
			checkinfo +='。姓名\n';
			check = 0;
		}
		if(school==''){
			// checkinfo +='\n';
			// check = 0;
		}
		if(idnum==''){
			checkinfo +='。身分證字號\n';
			check = 0;
		}
		if(birthday==''){
			checkinfo +='。出生年月日\n';
			check = 0;
		}
		if(mobile==''){
			checkinfo +='。手機號碼\n';
			check = 0;
		}
		if(reg_address==''){
			checkinfo +='。戶籍地址\n';
			check = 0;
		}
		if(mailing_address==''){
			checkinfo +='。通訊地址\n';
			check = 0;
		}
		if(emg_name==''){
			checkinfo +='。緊急聯絡人\n';
			check = 0;
		}
		if(emg_phone==''){
			checkinfo +='。緊急聯絡電話\n';
			check = 0;
		}

		if (check) {
			var data = 'key='+key+'&name='+name+'&school='+school+'&id_num='+idnum+'&birthday='+birthday+'&note='+note+'&mobile='+mobile+'&home='+home+'&email='+email+'&reg_address='+reg_address+'&mailing_address='+mailing_address+'&emg_name='+emg_name+'&emg_phone='+emg_phone+'&stu_id='+stu_id;  
			submitinfo(data,key,stu_id);
			
		}else{
			errormsg(checkinfo);
		};
	}
	function submitinfo(data,key,stu_id){

		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		xhr.open("POST", "<?=web_url('/student/submitstuinfo')?>", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// errormsg(xhr.responseText);  
					result = JSON.parse(xhr.responseText);
					if (result != false) {
						document.getElementById('stu_'+key+'_btn').className = 'btn btn-primary';
						if (stu_id==0) {
							// errormsg('key='+key);
							document.getElementById('stu_'+key+'_stu_id').value = xhr.responseText;
							document.getElementById('stuinfosubmit').innerHTML += "<input type='hidden' name='stu_id[]' id='stu_id_"+key+"_submit' value="+xhr.responseText+">"
							$('#final_stu_list').append('<tr id="final_stu_'+key+'"><td>'+$('#stu_'+key+'_name').val()+'</td><td>'+$('#stu_'+key+'_mobile').val()+'</td><tr>');		

							get_rent_cal();
						}else{
							var remove_item = document.getElementById('final_stu_'+key);
							remove_item.parentElement.removeChild(remove_item);
							$('#final_stu_list').append('<tr id="final_stu_'+key+'"><td>'+$('#stu_'+key+'_name').val()+'</td><td>'+$('#stu_'+key+'_mobile').val()+'</td><tr>');		

						}
					}else{
						errormsg('[儲存時發生錯誤，請再試一次]\n如果持續出現請聯絡Kevin\n');
					}      
						 
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}
	}
// 合約資料
	function room_suggestion(){  
		var dorm = document.getElementById("dorm_select").value;  
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "dorm_id=" + dorm;  
		xhr.open("POST", "<?=web_url('/utility/room_suggestion')?>", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// errormsg(xhr.responseText);        
					data = JSON.parse(xhr.responseText);
					var htmltext = '';
					for (var i = data.length - 1; i >= 0; i--) {
						htmltext += "<option class='form-control' value='"+data[i].room_id+"'>"+data[i].name+"</option>";
					};

					document.getElementById("room_select").innerHTML = htmltext;  
					room_data_suggestion();
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
	}
	function room_data_suggestion(){  
		var room = document.getElementById("room_select").value;  
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "room_id=" + room;  
		xhr.open("POST", "<?=web_url('/utility/get_room_info')?>", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// errormsg(xhr.responseText);    
					data = JSON.parse(xhr.responseText);    
					document.getElementById("rent").value = data.rent;  
					$('#final_dorm').html(data.dname);
					$('#final_room').html(data.rname);
					final_rent_check();
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
	}

	function sameascontract(item){
		if (item==0) {
			$('#datepickerIn').val($('#datepickerStart').val());
		}
		if (item==1) {
			$('#datepickerOut').val($('#datepickerEnd').val());
		}
		recheck();
	}
	function get_rent_cal(){
		var rpm = $('#rent').val();
		var s_date = $('#datepickerStart').val();
		var e_date = $('#datepickerEnd').val();
		var countpeo = $('input[name*="stu_id[]"]').length;

		if (final_rent_check()&&checkSE()) {
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			var data = 'rpm='+rpm+'&s_date='+s_date+'&e_date='+e_date+'&countpeo='+countpeo;
			xhr.open("POST", "<?=web_url('/contract/get_rent_cal')?>", true);   
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
			xhr.send(data);  
			xhr.onreadystatechange = display_data;  
			function display_data() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// errormsg(xhr.responseText);    
						data = JSON.parse(xhr.responseText);
						if (data!==false) {
							$('#total_days').html(data.date_result.td);
							$('#total_peo').html(countpeo);
							$('#mib').html(data.date_result.mib);
							$('#ROD').html(data.date_result.rod);
							$('#mib_rent').html(data.rent_result.mib_rent);
							$('#ROD_rent').html(data.rent_result.ROD_rent);
							$('#total_rent').html(data.rent_result.total_rent);
							$('#final_tr').html(data.rent_result.total_rent);
						}  
					} else {  
						errormsg('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}  
		}		
	}
	function checkSE(){
		var s_date = $('#datepickerStart').val();
		var e_date = $('#datepickerEnd').val();
		if (s_date!==''&&e_date!=='') {
			if (date_diff(s_date, e_date)<=0) {
				errormsg('合約日期錯誤');
				$('#final_sd').html('合約日期錯誤');
				$('#final_ed').html('合約日期錯誤');
				$('#final_tr').html('合約日期錯誤');
				return false;
			}else{
				$('#final_sd').html($('#datepickerStart').val());
				$('#final_ed').html($('#datepickerEnd').val());
				
				return true;
			}
		}else{
			$('#final_sd').html('合約日期未填');
			$('#final_ed').html('合約日期未填');
			$('#final_tr').html('合約日期未填');
			return false;
		}
	}
	function checkInOut(){
		var s_date = $('#datepickerIn').val();
		var e_date = $('#datepickerOut').val();
		if (s_date!==''&&e_date!=='') {
			if (date_diff(s_date, e_date)<=0) {
				errormsg('遷入遷出日期錯誤');
				
				return false;
			}else{
				
				return true;
			}
		}else{
			return false;
		}
	}
	function date_diff(s_date, e_date){
		var start = new Date(s_date);
		var end = new Date(e_date);
		return (end-start)/86400000;
	}
	function checknotoverlap(){
		var s_date = $('#datepickerIn').val();
		var e_date = $('#datepickerOut').val();
		var room_id = $('#room_select').val();
		if (checkInOut()&&room_id!==''&&room_id!==null&&room_id!==0) {
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			var data = 's_date='+s_date+'&e_date='+e_date+'&room_id='+room_id;
			xhr.open("POST", "<?=web_url('/contract/check_not_over_lap')?>", true);   
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
			xhr.send(data);  
			xhr.onreadystatechange = display_data;  
			function display_data() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// errormsg(xhr.responseText);    
						data = JSON.parse(xhr.responseText);
						if (data.state ===true) {
							checkOK();
						}else if(data.state ===false){
							$('#over_lap_dorm').html(data.result[0].dname);
							$('#over_lap_room').html(data.result[0].rname);
							$('#over_lap_list').html('');
							for (var i = 0;i < data.result.length; i++) {
								datum = data.result[i];
								$('#over_lap_list').append('<tr><td>'+(i+1)+'</td><td>'+datum.sname+'</td><td>'+datum.mobile+'</td><td>'+datum.s_date+'</td><td>'+datum.e_date+'</td><td>'+datum.in_date+'</td><td>'+datum.out_date+'</td></tr>')
							};
							$('#overlapModal').modal('toggle');
							recheck();
						}else if(data.state ===-1){
							errormsg('房間日期資料輸入不完整或格式錯誤');
							recheck();
						}
					} else {  
						errormsg('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}  
		}else{
			errormsg('房號、遷入、遷出日期請填寫完整');
		}	
	}
	function checkOK(){
		$('#btncheck').attr('disabled', true);
		$('#btncheck').html('OK');
		$('#btncheck').attr('class','btn btn-success  btn-lg');
		$('#InOutcheck').attr('class', 'glyphicon glyphicon-ok-circle');
		$('#final_id').html($('#datepickerIn').val());
		$('#final_od').html($('#datepickerOut').val());
		$('#checkInOutval').val(1);
	}
	function recheck(){
		$('#btncheck').attr('disabled', false);
		$('#btncheck').html('CHECK');
		$('#btncheck').attr('class','btn btn-warning btn-lg');
		$('#InOutcheck').attr('class', '');
		$('#final_id').html('檢查未通過');
		$('#final_od').html('檢查未通過');
		$('#checkInOutval').val(0);
	}

// final check
	function final_rent_check(){
		var rent = $('#rent').val();
		if (rent!=='') {
			if ($('#rent').val()<=0) {
				errormsg('租金不可以小於等於0');
				$('#final_rent').html('租金錯誤');
				$('#final_tr').html('租金錯誤');
				$('#rent').focus();
				return false;
			}else{
				$('#final_rent').html($('#rent').val())
				return true;
			}
		}else{
			$('#final_rent').html('租金未填');
			$('#final_tr').html('租金未填');
			return false;
		}	
	}
	function final_check(key){
		switch(key){
			case 1:
				check_stu(key,true);				
				break;
			case 2:
				check_room_dorm(key,true);				
				break;
			case 3:
				checkfinalSE(key,true);
				break;
			case 4:
				checkfinalIO(key,true);
				break;
			case 5:
				checkfinanceplan(key,true);
				break;
		}
		if (buttonlock(1)&&check_room_dorm(2,false)&&checkfinalSE(3,false)&&checkfinalIO(4,false)) {
			$('#tab_contract').attr('data-toggle','none');
			$('#tab_contract').attr('onClick','errormsg("已鎖定")');
		}
		if(buttonlock(0)&&check_stu(1,false)&&check_room_dorm(2,false)&&checkfinalSE(3,false)&&checkfinalIO(4,false)&&checkfinanceplan(5,false)){
			$('#submitbtn').attr('disabled', false);
		}
	}
	function check_stu(key,show){
		if ($('input[name*="stu_id[]"]').length<=0) {
			if (show) {
				errormsg('沒有新增房客');
			};
			
			return false;
		}else{
			$('#btnfinalcheck_'+key).attr('disabled', true);
			$('#btnfinalcheck_'+key).html('OK');
			$('#btnfinalcheck_'+key).attr('class','btn btn-success');
			$('#tab_stuinfo').attr('data-toggle','none');
			$('#tab_stuinfo').attr('onClick','errormsg("已鎖定")');
			return true;
		}
	}
	function check_room_dorm(key,show){
		if($('room_select').val()===''||$('dorm_select').val()<=0){
			if (show) {
				errormsg('宿舍未選擇');
			};
			
			return false;
		}else if($('room_select').val()===''||$('room_select').val()<=0){
			if (show) {
				errormsg('房間未選擇');
			};
			
			return false;
		}else if (!final_rent_check()) {
			if (show) {
				errormsg('租金未填');
			};
			
			return false;
		}else if($('#checkInOutval').val()!=='1'){
			if (show) {
				errormsg('遷入遷出檢查未通過');
			};
			
		}else{
			$('#dorm_select').attr('disabled', true);
			$('#room_select').attr('disabled', true);
			$('#rent').attr('disabled', true);

			$('#btnfinalcheck_'+key).attr('disabled', true);
			$('#btnfinalcheck_'+key).html('OK');
			$('#btnfinalcheck_'+key).attr('class','btn btn-success');
			return true;
		}
	}
	function checkfinalSE(key,show){
		if (checkSE()) {
			$('#datepickerStart').attr('disabled', true);
			$('#datepickerEnd').attr('disabled', true);

			$('#btnfinalcheck_'+key).attr('disabled', true);
			$('#btnfinalcheck_'+key).html('OK');
			$('#btnfinalcheck_'+key).attr('class','btn btn-success');
			return true;
		}else{
			if (show) {
				errormsg('合約日期未填');
			}
			
			return false;
		}
	}
	function checkfinalIO(key,show){

		if(!checkInOut()){
			if (show) {
				errormsg('遷入遷出日期未填')
			}
			
			return false;
		}else if($('#checkInOutval').val()!=="1"){
			if (show) {
				errormsg('遷入遷出檢查未通過');
			}
			
			return false;
		}else{
			$('#datepickerIn').attr('disabled', true);
			$('#datepickerOut').attr('disabled', true);

			$('#btnfinalcheck_'+key).attr('disabled', true);
			$('#btnfinalcheck_'+key).html('OK');
			$('#btnfinalcheck_'+key).attr('class','btn btn-success');	
			return true;
		}
	}
	function checkfinanceplan(key, show){
		if (checkSE()&&final_rent_check()&&parseInt($('#total_rent').html())>0) {
			$('#btnfinalcheck_'+key).attr('disabled', true);
			$('#btnfinalcheck_'+key).html('OK');
			$('#btnfinalcheck_'+key).attr('class','btn btn-success');
			return true;
		}else{
			if (show) {
				errormsg('租金計算錯誤');
			}
			return false;
		}
	}
	function buttonlock(method){
		if (method==0) {
			if ($('#btnfinalcheck_1').attr('disabled')=='disabled'&&$('#btnfinalcheck_2').attr('disabled')=='disabled'&&$('#btnfinalcheck_3').attr('disabled')=='disabled'&&$('#btnfinalcheck_4').attr('disabled')=='disabled'&&$('#btnfinalcheck_5').attr('disabled')=='disabled') {
				return true;
			}else{
				return false;
			}
		}else{
			if ($('#btnfinalcheck_2').attr('disabled')=='disabled'&&$('#btnfinalcheck_3').attr('disabled')=='disabled'&&$('#btnfinalcheck_4').attr('disabled')=='disabled') {
				return true;
			}else{
				return false;
			}
		}	
	}
// submit
	function submitcontract(){
		// lock
		$('#submitbtn').attr('disabled','true');

		// data
		// stu_id
		var cdata = {};
		cdata.stu_id =  {};
		$('input[name*="stu_id[]"]').each(function(key){
			cdata.stu_id[key] = ($(this).val());
		});
		cdata.room_id = $('#room_select').val();
		cdata.rent = $('#rent').val();
		cdata.s_date = $('#datepickerStart').val();
		cdata.e_date = $('#datepickerEnd').val();
		cdata.in_date = $('#datepickerIn').val();
		cdata.out_date = $('#datepickerOut').val();
		cdata.note = $('#note').val()+'';
		cdata.sales = $('#sales').val();
		json_data = JSON.stringify(cdata);
		data = "json_data="+json_data;
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		xhr.open("POST", "<?=web_url('/contract/submitcontract')?>", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// errormsg(xhr.responseText);  
					result = JSON.parse(xhr.responseText);
					if (result.state == 1) {

						successmsg('新增完成。請列印合約');
						$('#tab_thingsplan').attr('data-toggle','tab');
						$('#tab_thingsplan').attr('onclick','');
						$('#tab_thingsplan').trigger('click');
						$('#new_contract_id').val(result.contract_id);
					}else if(result.state == 0){
						for (var i = result.error_id.length - 1; i >= 0; i--) {
							text = text + result.error_id[i] + ',';
						};
						$('#submitbtn').attr('disabled','false');
						errormsg('[儲存時發生錯誤，請再試一次]\n錯誤的學生代碼:'+text+'\n如果持續出現請聯絡Kevin\n');
					}else if(result.state == -1){
						errormsg('[資料有誤]\n請重新來一次\n');
						$('#submitbtn').attr('disabled','false');
					}else{
						errormsg('[發生不知名錯誤]\n請聯絡KEVIN');
						$('#submitbtn').attr('disabled','false');
					}
						 
				} else {  
					errormsg('資料傳送出現問題，等等在試一次.');  
					$('#submitbtn').attr('disabled','false');
				}  
			}  
		}
	}
	function show_rent_detail(contract_id){
		if (contract_id==null) {
			var contract_id = $('#new_contract_id').val();
		}
		// 傳送
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "contract_id=" + contract_id;  
		xhr.open("POST", "<?=web_url('/accounting/show_rent_detail')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					data = JSON.parse(xhr.responseText);
					$('#rent_detail').html('');
					var total_rent = 0;
					if (data.state===true) {
						for (var i = 0; i < data.data.length; i++) {
						  	var datum = data.data[i];
						  	switch(datum.type){
						  		case '1':
						  			datum.typename = '租金';
						  			break;
						  		case '2':
						  			datum.typename = '額外';
						  			break;
						  		case '3':
						  			datum.typename = '獎學金';
						  			break;
						  		case '4':
						  			datum.typename = '其他+';
						  			break;
						  		case '5':
						  			datum.typename = '其他-';
						  			break;
						  		default:
						  			datum.typename = '';
						  	}
						  	$('#rent_detail').append('<tr><td>'+(i+1)+'</td><td>'+datum.typename+'</td><td>'+((datum.pm==1)?'<span class="glyphicon glyphicon-plus"></span>':'<span class="glyphicon glyphicon-minus"></span>')+'</td><td>'+datum.value+'</td><td>'+datum.description+'</td><td>'+datum.date+'</td></tr>');
							total_rent = total_rent + ((datum.pm=='1')?1:-1)*parseInt(datum.value);
						};  
						$('#rent_total').html(total_rent);
					}
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	
	}
	function submit_new_rent(){
		var type = $('#new_rent_type_select').val();
		var value = parseInt($('#new_rent_value').val());
		var date = $('#new_rent_date').val();
		var description = $('#new_rent_description').val();
		var contract_id = $('#new_contract_id').val();

		var state = 1;
		if ((type==4||type==5)&&description=='') {
			errormsg('選擇"其他"請輸入描述或備註');
			state = 0;
		};
		if (date=='') {
			errormsg('請輸入日期');
			state = 0;
		};
		if (!Number.isInteger(value)||value<=0||value=='') {
			errormsg('請輸入正整數金額');
			state = 0;
		}
		if (type=='') {
			errormsg('請選擇類別');
			state = 0;
		};
		
// 傳送
		if (state == 1) {
			var xhr;  
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
				xhr = new XMLHttpRequest();  
			} else if (window.ActiveXObject) { // IE 8 and older  
				xhr = new ActiveXObject("Microsoft.XMLHTTP");  
			}  
			var data = "contract_id=" + contract_id+'&type='+type+'&value='+value+'&date='+date+'&description='+description;  	
			xhr.open("POST", "<?=web_url('/accounting/add_rent_record')?>");
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
			xhr.send(data);  
			function display_datas() {  
				if (xhr.readyState == 4) {  
					if (xhr.status == 200) {  
						// alert(xhr.responseText);
						data = JSON.parse(xhr.responseText);

						if (data.state===true) {
							successmsg('新增成功');
							show_rent_detail(contract_id);
							$('#rentModal').modal('toggle');
						}else{
							errormsg('新增失敗');
						}
					} else {  
						alert('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}  
			xhr.onreadystatechange = display_datas;  
		};
	}

	function things_check(){
		var contract_id = $('#new_contract_id').val();
		$('#tab_financialplan').attr('data-toggle','tab');
		$('#tab_financialplan').attr('onclick','');
		$('#tab_financialplan').trigger('click');
		show_rent_detail(contract_id);
		// alert(contract_id);
	}
	function finance_check(){
		var contract_id = $('#new_contract_id').val();
		$('#tab_print').attr('data-toggle','tab');
		$('#tab_print').attr('onclick','');
		$('#tab_print').trigger('click');
		$('#printFrame').attr('src', '<?=web_url("/contract/pdf_gen")?>?contract_id='+contract_id);
	}

	function refresh(){
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "";
		xhr.open("POST", "<?=web_url('/student/update_from_type_form')?>");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					data = JSON.parse(xhr.responseText);
					
					if (data.state===true) {
						if (data.chrows==0) {
							errormsg('不要亂按，請先確定學生有新增了<br>(只有最近的10筆會被同步)')
						}else{
							successmsg('更新成功，新增了'+data.chrows+'筆');
							stu_suggestion();
						}
					}
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;
	}


	$('#keepbtn').click();


	$( '#datepickerStart' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$( '#datepickerEnd' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$( '#datepickerIn' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$( '#datepickerOut' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	$( '#new_rent_date' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	
</script>
<?php } ?>

