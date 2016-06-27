</div>
</div>
</div>
</body>
	<?php echo js_url('/jquery-2.1.0.js')?>
	<?php echo js_url('/bootstrap.min.js')?>
	<?php echo js_url('/bootstrap.js')?>
	<?php echo js_url('/jquery-ui.js')?>
	<?php echo js_url('/bootstrap-fileupload.js')?>

	<script type="text/javascript">
		$('.dropdown-toggle').dropdown();
	</script>

	<script type="text/javascript">
		dialogbreakdone = $( "#dialog-warning" ).dialog({
			autoOpen: false,

			modal: true,
			width: "50%",
			resizable: false,
			dialogClass: "alert",
			buttons: {

	        '確定': function(){
	        	$( this ).dialog( "close" );
	        }
	      }
	    });
	    dialogbreakdone = $( "#dialog-success" ).dialog({
			autoOpen: false,

			modal: true,
			width: "50%",
			resizable: false,
			dialogClass: "alert",
			buttons: {

	        '確定': function(){
	        	$( this ).dialog( "close" );
	        }
	      }
	    });
		function errormsg(msg){
			$('#error_msg').html(msg);
			$('#dialog-warning').dialog( "open" );
		}
		function successmsg(msg){
			$('#success_msg').html(msg);
			$('#dialog-success').dialog( "open" );
		}

		function sendsms(content, phone){
			$('#smsModal').modal('toggle');
			$('#sms_content').val('[蔡阿姨宿舍通知0927619822]'+content);
			$('#sms_receiver').val(phone);
			document.getElementById('sms_content').focus();
		}

		function post($url, data, callback, $mode){ //0: internal
			var sms_content = $('#sms_content').val();
			var sms_receiver = $('#sms_receiver').val();

			var xhr;
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...
				xhr = new XMLHttpRequest();
			} else if (window.ActiveXObject) { // IE 8 and older
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			// alert(data);
			if ($mode==0) {
				$req_url = "<?=web_url('')?>"+$url;
			}
			xhr.open("POST", $req_url, true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send(data);
			xhr.onreadystatechange = display_data;
			function display_data() {
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {
						var return_data = JSON.parse(xhr.responseText);
						callback(return_data);
					} else {
						errormsg('資料傳送出現問題，等等在試一次.');
					}
				}
			}
		}

		function send_new_sms(){
				var sms_content = $('#sms_content').val();
				var sms_receiver = $('#sms_receiver').val();
				var req_data = "content=" +sms_content+"&rx=" + sms_receiver + "&note=";
				function callback(data){
						if (data == true) {
								successmsg('寄送成功');
								$('#smsModal').modal('toggle');
						}else{
								errormsg('寄送失敗')
						}
				}
				post('/contact/send_sms', req_data, callback, 0);
		}
		function ShowTime(){
			var NowDate=new Date();
			var y=NowDate.getFullYear();
			var mo=NowDate.getMonth()+1;
		　	var d=NowDate.getDate();

			var h=NowDate.getHours();
			var m=NowDate.getMinutes();
			var s=NowDate.getSeconds();　
			if (s<10) {s="0"+s};
			if (m<10) {m="0"+m};
			if (h<10) {h="0"+h};
			if (d<10) {d="0"+d};
			if (mo<10) {mo="0"+mo};

			document.getElementById('showbox').innerHTML = y+'/'+mo +'/'+d+' '+ h+':'+m+':'+s;
			setTimeout('ShowTime()',1000);
		}
		function get_sms_collection(){
			function callback(data){
				// alert(xhr.responseText);
				$('#smscollectionselection').html('<option>請選擇...</option>');
				for (var i = data.length - 1; i >= 0; i--) {
					$('#smscollectionselection').append('<option id="smscollectionoption'+data[i].sc_id+'" value="'+data[i].sc_id+'">'+data[i].content+'</option>');
				}
			}
			post('/service/show_sms_collection', "", callback, 0);
		}
		get_sms_collection();
		function fill_in_sms(){
			var sc_id = $('#smscollectionselection').val();
			if (sc_id>0) {
				$('#sms_content').val($('#sms_content').val()+$("#smscollectionoption"+sc_id).html());
			}
		}
	</script>
	<!-- 讓每一頁可以寫不同script的方法 -->
	<?php if(function_exists("js_section")){ js_section(); } ?>
</html>
