<div class="col-sm-1 col-md-1 sidebar" id="sidebar">

		<ul class="nav nav-sidebar">
			<div class="alert alert-info">快速新增</div>
			<!-- <li><a href="#"><span class="glyphicon glyphicon-resize-full"></span>&nbsp;&nbsp;新支出</a></li> -->
			<!-- <li><a href="#" data-toggle="modal" data-target="#newrecModal" ><span class="glyphicon glyphicon-resize-small"></span>&nbsp;&nbsp;新增收據</a></li> -->
			<!-- <li><a href="#" data-toggle="modal" data-target="#newfixModal" ><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;新增維修</a></li> -->
			<li><a href="#" onclick="show_mail_modal()"><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;新信件</a></li>
			<li><a href="#" onclick="sendsms('','')"><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;寄簡訊</a></li>
			
		</ul>
		<ul class="nav nav-sidebar">
			<div class="alert alert-success">常用功能</span></div>
			<li><a href="<?=web_url('/contact/stulist')?>"><span class="glyphicon glyphicon-phone-alt"></span>&nbsp;&nbsp;通訊錄</a></li>
			<!-- <li><a href="<?=web_url('/')?>"><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;簡訊</a></li> -->
			<li><a href="<?=web_url('/accounting/expenditure')?>"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;支出管理</a></li>
			<!-- <li><a href="mail.php"><span class="glyphicon glyphicon-send"></span>&nbsp;&nbsp;信件通知</a></li> -->
			<!-- <li><a href="<?=web_url('/')?>"><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;合約</a></li> -->
			<!-- <li><a href="<?=web_url('/')?>" ><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;維修</a></li> -->

			
		</ul>
		<!-- <ul class="nav nav-sidebar">
			<div class="alert alert-info">快速開啟</div>
			<li><a href="#" data-toggle="modal" data-target="#newoutModal" >新增支出</a></li>

		</ul> -->

	
	</div>
	