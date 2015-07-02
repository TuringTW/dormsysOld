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
		function check_all(obj,cName) 
		{ 
		    var checkboxs = document.getElementsByName(cName); 
		    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
		} 

		function selAll(){
			//變數checkItem為checkbox的集合
			var checkItem = document.getElementsByName("tocsv[]");
			for(var i=0;i<checkItem.length;i++){
				checkItem[i].checked=true;   
			}
		}
		function unselAll(){
			//變數checkItem為checkbox的集合
			var checkItem = document.getElementsByName("tocsv[]");
			for(var i=0;i<checkItem.length;i++){
				checkItem[i].checked=false;
			}
		}
		function checkornot(){
			var check=document.getElementsByName("checkall");
			if(check.value==1){
				unselAll();
				check.value=0;
			}else{
				selAll();
				check.value=1;
			}
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
		function wrongreport(wrong){
			if (confirm('【錯誤】'+wrong+'\n\n======錯誤回報======\n\n按確定開新分頁到錯誤回報')	) {
				var url = encodeURI(document.URL);
				window.open('ErrorRsp.php?pmsg='+wrong+'&report=&purl='+url);

			};
		}
	</script> 

	<?php 
		if (isset($_GET['wrong'])) {
			$wrong = $_GET['wrong'];
	?>
			<script type="text/javascript">
				wrongreport('<?=$wrong?>');
				
				
			</script>
	<?php }	?>
	<!-- 讓每一頁可以寫不同script的方法 -->
	<?php if(function_exists("js_section")){ js_section(); } ?>
</html>
