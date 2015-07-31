
<div id="dialog-breakcontracr" title="違約設定">
	<form>
		<label>學生名單</label>
		<div id="break_stu_info" style="width:100%">
			
		</div>
		<hr>
		<label>原合約</label>
		<div id="break_contract_info" style="width:100%">
			
		</div>
		<hr>
		<table class="table">
			<tr>
				<td style="width:30%"><label for="bdate">原合約終止日期</label></td>
				<td style="width:20%"><input type="text" name="bdate" id="bdate" value="<?=date('Y-m-d')?>" class="text ui-widget-content ui-corner-all"></td>
				<td style="width:50%"><span id="bstate"></span></td>
			</tr>
		</table>
		<input type="hidden" id="bc_num" name="bc_num" value="0">
	</form>
</div>

<div id="dialog-update-failed" title="違約設定狀態">
	<p><span class="glyphicon glyphicon-remove"></span>失敗!!!請在試一次</p>
</div>
<div id="dialog-update-done" title="違約設定狀態">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span>成功!!!<span id="bkeepalert"></span></div>
	<input type="hidden" id="keep_bc_num" name="bc_num" value="0">
	<input type="hidden" id="keep_b_date" name="b_date" value="0">
</div>

<div class="modal fade " id="viewModal" tabindex="-1" role="dialog" data-show="1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
				<div class="modal-header">
					<button type="button" id="closebtn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">合約詳細資料</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action="_add_contract.php">
						<table class="table table-hover" >
							<tbody id = "view_stu_info">

							</tbody>
						</table>
						<table class="table table-hover">
							<tr>
	     						<td style="width:15%" align="right">宿舍</td>
	     						<td>
	     							<div class="row">
	     								<div class="col-md-10"><input class="form-control" id="view_dorm" disabled required="required" style="width:100%" type="text" name="new[]" value=""></div>
	     								<div class="col-md-2"><a href="dorm.php?view=" id="view_dorm_href" class="btn btn-default" style="width:100%"><span class="glyphicon glyphicon-tower"></span></a></div>
	     	
	     							</div>
	     						</td>
	     					</tr>
	     					<tr>
	     						<td style="width:15%" align="right">房號</td>
	     						<td>
	     							
	     							<div class="row">
	     								<div class="col-md-10"><input class="form-control" id="view_room" disabled required="required" style="width:100%" type="text" name="new[]" ></div>
	     								<div class="col-md-2"><a href="room.php?view=" id="view_room_href" class="btn btn-default" style="width:100%"><span class="glyphicon glyphicon-home"></span></a></div>
	     	
	     							</div>
	     						</td>
	     					</tr>
	     					<tr>
	     						<td style="width:15%" align="right">入住日期</td>
	     						<td>
	     							<input class="form-control"  disabled id="view_s_date" required="required" style="width:100%" type="text" name="new[]" >
	     						</td>
	     					</tr>
	     					<tr>
	     						<td style="width:15%" align="right">遷出日期</td>
	     						<td>
	     							<input class="form-control" disabled  id="view_e_date" required="required" style="width:100%" type="text" name="new[]" >
	     						</td>
	     					</tr>
	     					<tr>
	     						<td style="width:15%" align="right">簽約日期</td>
	     						<td>
	     							<input class="form-control" disabled id="view_c_date" required="required" style="width:100%" type="text" name="new[]" >
	     						</td>
	     					</tr>
	     					<tr>
	     						<td style="width:15%"  align="right">一個月租金</td>
	     						<td>
	     							<input class="form-control" id="view_rent" required="required" style="width:100%" type="text" name="new[]" >

	     						</td>
	     					</tr>
	     					<tr>
	     						<td style="width:15%" align="right">已繳租金</td>
	     						<td>
	     							<input class="form-control" id ="view_payed_rent" disabled required="required" style="width:100%" type="text" name="new[]" >

	     						</td>
	     					</tr>
	     					<tr>
	     						<td style="width:15%" align="right">帶看人</td>
	     						<td>
	     							<select class="form-control" id="view_sales" required="required" style="width:100%" name="new[]">
     									<option  class="form-control">請選擇...</option>
	     								
	     								<?php foreach ($saleslist as $key => $value): ?>
	     									<option  class="form-control" value="<?=$value['m_id']?>" ><?=$value['name']?></option>
	     								<?php endforeach ?>
	     							</select> 
	     						</td>
	     					</tr>
	     					
	     					<tr>
	     						<td style="width:15%" align="right">管理員</td>
	     						<td>
	     							<input class="form-control" id="view_manager"disabled required="required" style="width:100%" type="text" name="new[]" >
	     						</td>
	     					</tr>
	     					
	     					<tr>
	     						<td style="width:15%" align="right">備註</td>
	     						<td>
	     							<textarea class="form-control" id="view_note" style="resize: none;"  style="width:100%" name="new[]" rows="6"></textarea>
	     						</td>
	     					</tr>
	     				</table>
	     				<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="search" value="<?=$keyword?>">
    					<hr>
    					<div class="row" style="width:100%">
    						<div class="col-md-2 pull-right">
    							<button type="submit" name="editsubmit" class="btn btn-primary ">修改</button>
    						</div>
    						<div class="col-md-2 pull-right">
    							<a id="view_keep_btn"  name="checkoutsubmit" class="btn btn-success keep">續約</a>
    						</div>
	    					<div class="col-md-2 pull-right">
    							<a id="view_check_out_btn"  name="checkoutsubmit" class="btn btn-warning checkout">結算</a>
    						</div>
    						<div class="col-md-1 pull-right">
    						</div>
    						
    						
    						<div class="col-md-2 pull-right">
    							<a id="view_change_btn"  name="checkoutsubmit" data-cnum="0" class="btn btn-default">合約更動</a>
    						</div>
    						<div class="col-md-2 pull-right">
    							<a id="view_print_btn"  class="btn btn-default">列印</a>
    						</div>

    						
    					</div>
     				</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			
		</div><!-- /.modal-content -->
		
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- 查看窗格 -->
<a data-toggle="modal" id="viewbtn" data-target="#viewModal"  style="display:none"></a>


<?php function js_section(){ ?>

<script type="text/javascript">
	function showcontract(c_num){
		$('#viewModal').modal('toggle');
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "showcontract=&c_num=" + c_num;  
		xhr.open("POST", "_add_contract.php", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		xhr.onreadystatechange = display_data;  
		function display_data() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);
					var data = JSON.parse(xhr.responseText);
					document.getElementById('view_stu_info').innerHTML = '';
					for (var i = 0; i < data.length; i++) {
						datum = data[i];
						document.getElementById('view_stu_info').innerHTML+='<tr>'
		     						+'<td style="width:15%" align="right" >'+((i==0)?'立約人':'')+'</td>'
		     						+'<td>'
		     						+'	<div class="row">'
		     						+'		<div class="col-md-4"><input class="form-control"  disabled required="required" style="width:100%" type="text" name="stu[]" value="'+datum.sname+'"></div>'
		     						+'		<div class="col-md-2"><a href="stuInfo.php?view='+datum.stu_id+'" class="btn btn-default" style="width:100%"><span class="glyphicon glyphicon-user"></span></a></div>'
		     						+'		<div class="col-md-2"><a href="Sms.php?smssname='+datum.sname+'&phone='+datum.mobile+'&smson" class="btn btn-default" style="width:100%"><span class="glyphicon glyphicon-comment"></span></a></div>'
		     						+'		<div class="col-md-2"><a href="_add_contract.php?break_a_lease='+datum.contract_id+'" class="btn btn-warning break" style="width:100%">退租</a></div>'
		     						+'		<div class="col-md-2"><a href="_add_contract.php?delete='+datum.contract_id+'" class="btn btn-danger remove" style="width:100%">刪除</a></div>'

		     						+'	</div>'
		     						+'</td>'
		     						+'<input type="hidden" name="contract[]" value="'+datum.contract_id+'">'
		     					+'</tr>';
					};
					var datum = data[0];
					document.getElementById('view_dorm_href').href = 'dorm.php?view='+datum.dorm_id;
					document.getElementById('view_dorm').value = datum.dname;
					document.getElementById('view_room').value = datum.rname;
					document.getElementById('view_room_href').href = 'room.php?view='+datum.room_id;
					document.getElementById('view_s_date').value = datum.s_date;
					document.getElementById('view_e_date').value = datum.e_date;
					document.getElementById('view_c_date').value = datum.c_date;
					document.getElementById('view_rent').value = datum.rent;
					document.getElementById('view_payed_rent').value = datum.payed_rent;
					document.getElementById('view_sales').value = datum.sales;
					document.getElementById('view_manager').value = datum.mname;
					document.getElementById('view_note').value = datum.note;
					document.getElementById('view_keep_btn').href="newContract.php?keep="+datum.c_num+"&sdate=&searchsubmit=&room_id="+datum.room_id;
					document.getElementById('view_check_out_btn').href="_add_contract.php?checkout="+datum.c_num;
					document.getElementById('view_print_btn').href="ContractPrint.php?c_num="+datum.c_num;
					document.getElementById('view_change_btn').setAttribute('data-cnum',datum.c_num);       
					//document.getElementById("room_select").innerHTML = xhr.responseText;  
				} else {  
					alert('There was a problem with the request.');  
				}  
			}  
		}  
	}
</script>
<script type="text/javascript">

	$(function() {
		$( "#bdate" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});
	});
</script>
<script>
	$('.remove').click(function(e){
		e.preventDefault();
		if(confirm("確定要刪除嗎？")){
			window.location = $(this).attr('href');
		};
	});
</script>
<script>
	$('.break').click(function(e){
		e.preventDefault();
		if(confirm("確定要退租嗎？")){
			window.location = $(this).attr('href');
		};
	});
</script>
<script>
	$('.checkout').click(function(e){
		e.preventDefault();
		if(confirm("確定要結算這筆合約嗎？（整筆合約會一起結算）（若合租有人要退租，建議結算後剩餘的人再行續約）")){
			window.location = $(this).attr('href');
		};
	});
</script>
<script>
	$('.keep').click(function(e){
		e.preventDefault();
		if(confirm("確定要續約嗎？\n\n*********注意*********\n\n1.整筆合約裡的人會一起續約\n2.若合租有人要退租，建議續約後再進行退租\n\n3.續租日期會從現在合約截止日的隔一天開始算\n4.之後記得仍要結算")){
			window.location = $(this).attr('href');
		};
	});
</script>
<script type="text/javascript">
	function initial(){
		document.getElementById('submitbtn').disabled=true;
	}
</script>
<script type="text/javascript">
	function initial1(){
		document.getElementById('submitbtn1').disabled=true;
	}
</script>



<script  language="JavaScript">  
   //計算天數的函數
   function  DateDiff(beginDate,  endDate){    //beginDate和endDate都是2007-8-10格式

       var  arrbeginDate,  Date1,  Date2, arrendDate,  iDays;  
       arrbeginDate=  beginDate.split("-")  ;
       Date1=  new  Date(arrbeginDate[1]  +  '/'  +  arrbeginDate[2]  +  '/'  +  arrbeginDate[0]);    //轉換為2007-8-10格式
      arrendDate=  endDate.split("-")  ;
       Date2=  new  Date(arrendDate[1]  +  '/'  +  arrendDate[2]  +  '/'  +  arrendDate[0]);
       iDays  =  ((Date2-  Date1)  /  1000  /  60  /  60  /24);    //轉換為天數 
       return  iDays  
   }    
</script> 

<script type="text/javascript">
	function getbcontract(c_num){
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "c_num=" + c_num+"&bcontractinfo=1";  
		xhr.open("POST", "_show_contract_info.php", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					//alert(xhr.responseText);        
					document.getElementById("break_contract_info").innerHTML = xhr.responseText;  
					
					
				} else {  
					alert('There was a problem with the request.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	function getbstuinfo(c_num){
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "c_num=" + c_num+"&bstuinfo=1";  
		xhr.open("POST", "_show_contract_info.php", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					//alert(xhr.responseText);        
					document.getElementById("break_stu_info").innerHTML = xhr.responseText;  
					
					
				} else {  
					alert('There was a problem with the request.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  
	}
	function breakcontract(c_num,b_date,wtdo){
		
		var xhr;  
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		}  
		var data = "c_num=" + c_num+"&b_date=" + b_date+"&bcontract=1"; 
		xhr.open("POST", "_add_contract.php", true);   
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
		xhr.send(data);  
		function display_datas() {  
			if (xhr.readyState == 4) {  
				if (xhr.status == 200) {  
					// alert(xhr.responseText);        
					if (xhr.responseText=='1') {
						$('#dialog-breakcontracr').dialog( "close" );
						if (wtdo) {
							$('#keep_bc_num').val(c_num);
 							$('#keep_b_date').val(b_date);
 							$('#bkeepalert').html('接下來進行續約');
 							$('#bkeepalert').css('display','inline');
						}

						$('#dialog-update-done').dialog( "open" );
					}else{
						$('#dialog-update-failed').dialog( "open" );
					}
					
					
				} else {  
					alert('There was a problem with the request.');  
				}  
			}  
		}  
		xhr.onreadystatechange = display_datas;  		
	}
	function breaknkeep () {
		var c_num = $('#bc_num').val();
		var b_date = $('#bdate').val();
		if(checkdate(bdate)){
			$('#bstate').html('');
			breakcontract(c_num,b_date,1);
		}else{
			$('#bstate').html('中止日期須在原合約日期內');
		}

	}
	function breakonly () {
		var c_num = $('#bc_num').val();
		var b_date = $('#bdate').val();
		if(checkdate(bdate)){
			$('#bstate').html('');
			breakcontract(c_num,b_date,0);
		}else{
			$('#bstate').html('中止日期須在原合約日期內');
		}

	}
	function checkdate () {
		var bs_date = Date.parse($('#bs_date').val());
		var be_date = Date.parse($('#be_date').val());
		var b_date = Date.parse($('#bdate').val());
		if (be_date-b_date>0&&bs_date-b_date<0) {
			return 1;
		}else{
			return 0;
		}

	}
	
	dialogbreak = $( "#dialog-breakcontracr" ).dialog({
		autoOpen: false,
		width: 600,
		modal: true,
		resizable: false,
		dialogClass: "alert",
		buttons: {
		"原合約終止後續約":breaknkeep,
		"原合約終止": breakonly,
		"取消": function() {
				dialogbreak.dialog( "close" );
			}
		},
		close: function() {

		}
    });
    $( "#view_change_btn" ).button().on( "click", function() {

      	$(document).ready(function() {
	        $('#viewModal').modal('toggle');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
	    });
      	

	    var element = $( this );
	    if ( element.is( "[data-cnum]" ) ) {
			var c_num = element.attr('data-cnum');
			getbcontract(c_num);
			getbstuinfo(c_num);
			$('#bc_num').val(c_num);
	    }
	    dialogbreak.dialog( "open" );
      	
    });
</script>
<script type="text/javascript">
	dialogbreakfailed = $( "#dialog-update-failed" ).dialog({
		autoOpen: false,
		
		modal: true,
		resizable: false,
		dialogClass: "alert",
		buttons: {
        
        '確定': function() {
          $( this ).dialog( "close" );
          location.reload();
        }
      }
    });
    dialogbreakdone = $( "#dialog-update-done" ).dialog({
		autoOpen: false,
		
		modal: true,
		resizable: false,
		dialogClass: "alert",
		buttons: {
        
        '確定': function() {
          	$( this ).dialog( "close" );
          	var c_num = $('#keep_bc_num').val();
          	if (c_num=='0') {
        		location.reload();
          	}else{
          		var b_date = $('#keep_b_date').val();
          		var tomorrow = new Date(Date.parse(b_date));
				tomorrow.setDate(tomorrow.getDate()+1);
          		window.location.assign('newContract.php?keep='+c_num+'&sdate='+(tomorrow.getFullYear())+'-'+(tomorrow.getMonth()+1)+'-'+(tomorrow.getDate())+'&searchsubmit=')

          	}
          
        }
      }
    });
</script>
<?php if (isset($_GET['view'])): ?>
	<?php $c_num = $_GET['c_num'] ?>
	<?php if (!isset($_GET['c_num'])): ?>

		<?php 
			global $link;
			$sql = "SELECT `c_num` from `contract` where `contract_id` = '".mysqli_real_escape_string($link,$_GET['view'])."'";
			$result = mysqli_query($link,$sql);
			$c_num = mysqli_fetch_row($result)[0];

		?>
	
	<?php endif ?>
	<script type="text/javascript">
		showcontract(<?=$c_num?>);
	</script>
<?php endif ?>
<?php } ?>
<input type='hidden' name='c_num' value=''>
