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
					// alert(xhr.responseText);        
					var data = JSON.parse(xhr.responseText);
					var htmltext = '';
					htmltext += "<div class='list-group' style='position: relative; width: 100%; max-height: 180px; overflow: auto;'>";
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
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}  
	} 
	// 檢查是否已新增此人
	function checkreselect(stu_id){
		document.getElementById('submitbtn').disabled=true;
		var x = document.getElementById('stuinfosubmit');
		//alert(x.childNodes.length);
		max = Number(x.childNodes.length);
		//alert('max='+max);
		var state =1;
		for (var i = 1; i < max; i++) {
			//alert(i+'='+x.childNodes[i].value);
			if (stu_id == x.childNodes[i].value) {
				state = 0;
			};
		};
		if (state) {
			addstuinfo(stu_id);
		}else{
			alert('已新增過此人');
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
						// alert(xhr.responseText);
						data = JSON.parse(xhr.responseText);
						if (data == true) {
							alert('資料庫中已有此人!!!!\n請勿重複新增!!!!\n'+xhr.responseText);
							document.getElementById('stu_'+key+'_btn').disabled = true;
						}else{
							document.getElementById('stu_'+key+'_btn').disabled = false;

						}
							 
					} else {  
						alert('資料傳送出現問題，等等在試一次.');  
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
		// alert(stu_id+' '+key);
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
						// alert(xhr.responseText);   
						data = JSON.parse(xhr.responseText);
						// alert(document.getElementById('accordion').innerHTML);
						$('#accordion').append(stu_info_gen(data, key, stu_id));
						$(function() {$( '#stu_'+key+'_birthday' ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});})
					} else {  
						alert('資料傳送出現問題，等等在試一次.');  
					}  
				}  
			}

			//清除搜尋結果
			document.getElementById('stu_search_result').innerHTML = "";
			document.getElementById('add_stu_info_search').value = "";

			//新增submit的資料
			if (stu_id!=0) {
				document.getElementById('stuinfosubmit').innerHTML += "<input type='hidden' name='stu_id[]' id='stu_id_"+key+"_submit' value="+stu_id+">"
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
						htmltext+=' <td><input class="form-control" required id="stu_'+key+'_birthday" placeholder="(1900-1-1)" style="" type="text"  value="'+data.id_num+'" onChange="bannerrefresh('+key+',2)"></td>'
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
			alert(checkinfo);
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
					// alert(xhr.responseText);  
					result = JSON.parse(xhr.responseText);
					if (result != false) {
						document.getElementById('stu_'+key+'_btn').className = 'btn btn-primary';
						if (stu_id==0) {
							// alert('key='+key);
							document.getElementById('stu_'+key+'_stu_id').value = xhr.responseText;
							document.getElementById('stuinfosubmit').innerHTML += "<input type='hidden' name='stu_id[]' id='stu_id_"+key+"_submit' value="+xhr.responseText+">"

						}
					}else{
						alert('[錯誤：儲存時發生錯誤，請再試一次]\n如果持續出現請聯絡Kevin\n');
					}      
						 
				} else {  
					alert('資料傳送出現問題，等等在試一次.');  
				}  
			}  
		}
	}
// 合約資料
	function room_suggestion()  
	{  
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
					alert(xhr.responseText);        
					data = JSON.parse(xhr.responseText);
					var htmltext = '';
					for (var i = data.length - 1; i >= 0; i--) {
						htmltext += "<option class='form-control' value='"+data[i].room_id+"'>"+data[i].name+"</option>";
					};

					document.getElementById("room_select").innerHTML = htmltext;  
					room_data_suggestion();
				} else {  
					alert('There was a problem with the request.');  
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
					// alert(xhr.responseText);    
					data = JSON.parse(xhr.responseText);    
					document.getElementById("rent").value = data.rent;  
				} else {  
					alert('There was a problem with the request.');  
				}  
			}  
		}  
	}
</script>

<?php } ?>

