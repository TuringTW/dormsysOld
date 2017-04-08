<h1 class="page-header">手機通訊錄</h1>
<!-- 搜尋列 次導覽列 -->
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li class="active "><a  href="#update" role="tab" data-toggle="tab">更新資料</a></li>
	<li><a  href="#tutorial1" role="tab" data-toggle="tab">教學1:安裝</a></li>
	<li><a  href="#tutorial2" role="tab" data-toggle="tab">教學2:更新學生資料</a></li>
	<li><a  href="#tutorial3" role="tab" data-toggle="tab">教學3:使用</a></li>

</ul>
<br>
<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active " id="update">
		<div class="row">
			<div class="col-sm-6">
				<h2>1.請先連上book3126621Wifi</h2>
				<h2>2.輸入手機上的認證碼</h2>
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-sm-5"><input class="form-control" id="auth_code" value="" type="input"></div>
					<div class="col-sm-6"><a href="#" class="btn btn-primary" onclick="send_auth_code()">送出</a></div>
				</div>
				<h2>3.掃描右邊QR code</h2>
			</div>
			<div class="col-sm-6">
				<div class="well" style="width:100%;">
					<h2>QR code</h2>
					<hr>
					<img style="display:none;width:60%;" id="qrcode_img" src="" >
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="tutorial1">
		<div class="alert alert-warning" role="alert">目前還沒有提供來電辨識功能，但可以撥出</div>
		<div class="row">
			<div class="col-md-3">
				<h4>1.手機>設定>安全性></h4>
				<h4>&nbsp;&nbsp;&nbsp;未知的來源=>打勾</h4>
				<img src="<?=img_url('/unknown_source.jpg')?>" style="width:100%">
			</div>
			<div class="col-md-3">
				<h4>2.在手機用以下網址下載條碼掃描器(建議使用這個)</h4>
				&nbsp;&nbsp;&nbsp;<a href="https://goo.gl/sCdjUx">條碼掃描器(&nbsp;https://goo.gl/sCdjUx&nbsp;) </a>
				<h4>3.連到Book3126621Wifi, 用以下QRcode下載通訊錄APP</h4>
				<img src="http://chart.apis.google.com/chart?chs=300x300&chld=M|1&cht=qr&chl=<?=urlencode(file_url('/contactbook.apk'))?>" style="width:50%">

			</div>
			<div class="col-md-3">
				<h4>4.開啟下載的APP安裝檔, 並點選安裝</h4>
				<img src="<?=img_url('/download.jpg')?>" style="width:100%">
			</div>
			<div class="col-md-3">
				<h4>5.安裝好後點選開啟</h4>
				<img src="<?=img_url('/app_install.jpg')?>" style="width:100%">
			</div>

		</div>
	</div>
	<div class="tab-pane" id="tutorial2">
		
		<div class="row">
			<div class="col-md-3">
				<h4>1.點選右下角的更新按鈕></h4>
				<img src="<?=img_url('/init.jpg')?>" style="width:100%">
			</div>
			<div class="col-md-3">
				<h4>2.把手機顯示的授權碼</h4>
				<h4>&nbsp;&nbsp;&nbsp;打到電腦中按送出</h4>
				<h4>&nbsp;&nbsp;&nbsp;手機按繼續開啟QR掃描器</h4>
				<img src="<?=img_url('/enter_auth_code.jpg')?>" style="width:100%">

			</div>
			<div class="col-md-3">
				<h4>3.掃描電腦顯示的QRcode</h4>
				<img src="<?=img_url('/qrcode_desktop.png')?>" style="width:100%">
			</div>
			<div class="col-md-3">
				<h4>5.更新完成</h4>
				<img src="<?=img_url('/update_complete.jpg')?>" style="width:100%">
			</div>

		</div>
	</div>	
	<div class="tab-pane" id="tutorial3">
		<div class="row">
			<div class="col-sm-1"><img class="img-rounded" src="<?=img_url('/icon.png')?>" style="width:80px"></div>
			<div class="col-sm-11"><h2>Contact Book</h2></div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-3">
				<h4>1.進入後出現宿舍列表</h4>
				<img src="<?=img_url('/init.jpg')?>" style="width:100%">
			</div>
			<div class="col-md-3">
				<h4>2.點選宿舍會出現現在合</h4>
				<h4>&nbsp;&nbsp;&nbsp;約有效的房間-學生列表</h4>
				<img src="<?=img_url('/room_select.jpg')?>" style="width:100%">

			</div>
			<div class="col-md-3">
				<h4>3.點選人名後會有詳細資料</h4>
				<img src="<?=img_url('/detail.jpg')?>" style="width:100%">
			</div>
			<div class="col-md-3">
				<h4>4.點選藍色電話圖案可以撥出電話</h4>
				<img src="<?=img_url('/call_or_not.jpg')?>" style="width:100%">
			</div>

		</div>
	</div>
</div>	
	
</div>
</div>

