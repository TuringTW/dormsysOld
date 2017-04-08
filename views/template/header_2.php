<?php $version="7.1.2"
// 	6.1 	新增本月退租檢視功能
// 			seal 代號 0正常  -1退宿 1刪除 2待結算 3封存
				// keep 0 無 keep 1
// 	6.21	測試結算功能
//	6.22	結算功能完成 新增快速簡訊 新增封存
// 	6.23 	更新房間宿舍電錶管理 可直接查看合約與房間清單
//			電費統計更新
//	6.24	電費分析系統 更新
// 6.25		簡訊系統更新
//			新增gantti在timeline
//			開放修改退租日期
//			修正退租bug
//	6.26	從新設計電費分析 把紛表跟宿舍整合再一起
//			修改時間軸變得比較美觀好用
//	6.27	從新設計輸入合約表格newContract.php
//			關閉修改退租日期 改新增快速續約 避免重租問題
// 	6.28	修正新版新增合約的檢查機制
//	6.29	新增timeline.php的縮放功能 popover顯示合約
			// 修改首頁的狀態顯示，改成barge的樣式，並且不顯示超過三天未處理，而是用顏色表示
			// 首頁本月退租只顯示5個
// 	6.30	更新維修功能
			// 可以記錄維修的材料薪資
			// 並且可以匯出
			// 新增index搜尋功能
			// 建議放到navbar
			// 目前可搜尋有效合約-宿舍房間-手機-宿舍學生-
			// 應該把重複搜尋的部分刪除
			// 可以把關寄至框起來
// 	6.31	開啟dorm的刪除功能
// 	7.0.1 	使用CI framework逐步重寫
// 7.1.0 e  更新為CI
			// 支出管理
			// receipttype 1發票 2費用 3估價單
			// 開啟會計支出功能 沒有做require & 刪除 & 新增分類 之後補做
// 7.1.1
			// 	新增交接表、
// 7.1.2
// 			新增訂單
// 			room新增seal
// 			修改room engine 錯誤 union 後要order by datediff 讓最靠近的合約被顯示
?>

<body onload="ShowTime();" style="overflow-x:hidden;overflow-y:scroll;">
	<div class = "navbar navbar-inverse navbar-fixed-top">
		<div class = "container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navHeadercollapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=web_url('/index/index')?>" title="首頁、控制面板">蔡阿姨管理系統beta<?=" ".$version." "?></a>
			</div>
			<div class = "collapse navbar-collapse navHeadercollapse">
				<ul class = "nav navbar-nav navbar-left" id="nav">
					<!-- <li><a href = "<?=web_url('/index/index')?>">Home</a></li> -->
					<li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">合約</a>
						<ul class="dropdown-menu">
							<?php $CI =& get_instance(); ?>
							<li><a href = "<?=web_url('/contract/index')?>">合約列表</a></li>
							<!-- <li><a href = "#">待結算合約</a></li> -->
							<!-- <li><a href = "#">封存合約</a></li> -->
							<li><a href = "<?=web_url('/contract/newcontract')?>">新增合約</a></li>
							<hr>
							<li><a href = "<?=web_url('/student/index')?>">學生資料</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">預定</a>
						<ul class="dropdown-menu">
							<?php $CI =& get_instance(); ?>
							<li><a href = "<?=web_url('/reservation/index')?>">預定房間<b>列表</b></a></li>
							<li><a href = "<?=web_url('/reservation/newres')?>"><b>新增</b>預定</a></li>
						</ul>
					</li>
					<!-- <li><a href = "#">租屋狀態</a></li> -->
					<li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">房間搜尋</a>
						<ul class="dropdown-menu">
							<li><a href = "<?=web_url('/roomengine/index')?>">空房間搜尋</a></li>
							<li><a href = "<?=web_url('/roomengine/handover')?>">交接表</a></li>
						</ul>
					</li>

					<li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">聯絡通訊</a>
						<ul class="dropdown-menu">
							<li><a href = "<?=web_url('/contact/stulist')?>">學生通訊錄</a></li>
							<li><a href = "<?=web_url('/contact/contactbookmobile')?>">手機通訊錄</a></li>
							<hr>
							<li><a href = "#">簡訊</a></li>
						</ul>
					</li>

					<li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">服務</a>
						<ul class="dropdown-menu">
							<li><a href = "<?=web_url('/service/mail')?>">信件通知</a></li>
							<hr>
							<li><a href = "<?=web_url('/service/sms')?>">簡訊紀錄</a></li>
							<li><a href = "<?=web_url('/service/smscollection')?>">罐頭簡訊</a></li>
							<!-- <hr> -->
							<!-- <li><a href = "<?=web_url('/service/fix_record')?>">維修紀錄</a></li> -->
							<!-- <li><a href = "">維修</a></li> -->
							<!-- <li><a href = "">水電費押金</a></li> -->
						</ul>
					</li>

					<li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">會計</a>
						<ul class="dropdown-menu">
							<!-- <li><a href = "receipt.php">收據管理</a></li> -->
							<li><a href = "<?=web_url('/accounting/expenditure')?>">支出管理</a></li>
							<hr>
							<li><a href = "<?=web_url('/accounting/payment')?>">租金收款紀錄</a></li>
						</ul>
					</li>
					<!-- <li class="dropdown"> -->
						<!-- <a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">水電費/押金</a> -->
						<!-- <ul class="dropdown-menu"> -->
							<!-- <li><a href = "receipt.php">收據管理</a></li> -->
							<!-- <li><a href = "<?=web_url('/accounting/expenditure')?>">紀錄表</a></li> -->
						<!-- </ul> -->
					<!-- </li> -->
					<li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">管理</a>
						<ul class="dropdown-menu">
							<!-- <li><a href = "receipt.php">收據管理</a></li> -->
							<!-- <li><a href = "<?=web_url('/database/dorm')?>">宿舍管理</a></li> -->
							<li><a href = "<?=web_url('/database/room')?>">房間管理</a></li>
						</ul>
					</li>
					<!-- <li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">系統問題</a>
						<ul class="dropdown-menu">
							 <li><a href = "receipt.php">收據管理</a></li>
							<li><a onclick="window.open('https://docs.google.com/forms/d/1lIxLxN-y9bh3Z2-9wVjaVbhozisY3BHMfYONhreRZTk/viewform')">問題回報</a></li>
							<li><a href = "<?=web_url('/system/qna')?>">Q&A</a></li>
						</ul>
					</li> -->


					<!-- <li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">管理</a>
						<ul class="dropdown-menu">
							<li><a href = "room.php">房間管理</a></li>
							<li><a href = "dorm.php">宿舍管理</a></li>
							<hr>

							<!-- <li><a href = "reward.php">帶看獎金</a></li>
						<!-- </ul>
					</li> -->
<!-- 					<li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">分析</a>
						<ul class="dropdown-menu">

							<li><a href = "electro.php">電費總攬</a></li>
							<li><a href = "electroAnalDorm.php">宿舍電費分析</a></li>
							<li><a href = "electroNum.php">電錶管理</a></li>

							<hr>
							<li><a href = "contractAnal.php">出租率分析</a></li>

						</ul>
					</li> -->





					<!-- <li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown">系統</a>
						<ul class="dropdown-menu"> -->
							<!-- <li><a href = "https://www.google.com/cloudprint#printers">管理雲端印表機</a></li> -->
							<!-- <li><a href="#" data-toggle="modal" data-target="#loginpcModal" >登入PCHOME</a></li> -->
							<!-- <li><a href = "changePS.php">修改密碼</a></li>
							<li><a href = "smsAdd.php">加值簡訊</a></li>
							<?php if ($power<=1): ?>
								<li><a href="addManager.php">新增使用者</a></li>
							<?php endif ?>
							<?php if ($power==0): ?>
								<li><a href="#" onclick="window.open('//127.0.0.1/phpmyadmin/');">PHPMYADMIN</a></li>
							<?php endif ?>


					 	</ul>
					</li> -->
				</ul>

				<ul class = "nav navbar-nav navbar-right">
					<li><a id="showbox"></a></li>
					<li class="dropdown">
						<a herf="#" class="dropdown-toggle" data-toggle="dropdown" data-target="dropdown"><?="使用者:".$user?></a>
						<ul class="dropdown-menu">
							<!-- <li><a href = "receipt.php">收據管理</a></li> -->
							<li><a href = "<?=web_url('#')?>">修改密碼</a></li>
						</ul>
					</li>
					<li><a  href="<?=web_url('/index/logout')?>">登出</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
