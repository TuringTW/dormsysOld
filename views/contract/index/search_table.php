<h1 class="page-header">房間搜尋</h1>
			<!-- 搜尋列 次導覽列 -->
			<form class="form-horizontal" role="form" action="roomEngine.php" method="GET">
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-1 control-label">宿舍</label>
					<div class="col-md-4">
				
						<div class="btn-group" style="width:100%">
							<button type="button" class="btn btn-default dropdown-toggle btn-success" data-toggle="dropdown" style="width:100%">
								宿舍:<?php if (empty($dorm)) {
									echo "全部";
								}else{foreach ($dormlist as  $dorm1) { if ($dorm1['dorm_id']==$dorm) {
									echo $dorm1['name'];					
										}} } ?> <span class="caret"></span>
							</button>
							<?php 	$countdorm = count($dormlist);
									$coln = floor(($countdorm-2)/10);
									$j = 0; 
							?>
							<div class="dropdown-menu" role="menu" style="width:<?=($coln>1)?($coln-2)*60+120:120?>%">
								<div class="row" style="width:100%">
									<?php for ($i=0; $i <= $coln; $i++) { ?>
										<div class="col-md-<?=floor(12/($coln+1))?>" style="padding-left:15px;padding-right:0px;">
											<ul class="nav navbar" style="width:100%">
												<?php $key = $j ?>
												<?php while($j < $key+10 && $j < $countdorm) { ?>
													<?php $value = $dormlist[$j];
													if ($value['dorm_id']!=33&&$value['dorm_id']!=34){ ?>
														<li style="font-size:15px;font-weight:bold;"><a href="roomEngine.php?strdate=<?=$sdate?>&enddate=<?=$edate?>&searchsubmit=&type=<?=$type?>&dorm=<?=$value['dorm_id']?>&lower=<?=$lower?>&upper=<?=$upper?>" style="color:#003767"><?=$value['name']?></a></li>									
													<?php }else{ ?>
														<?php $key++; ?>
													<?php } ?>
													<?php $j++ ?>
												<?php } ?>
											</ul>
										</div>	
									<?php } ?>
								</div>
							</div>
							
							
						</div>
					</div>

					<input type="hidden" id="dorm" name="dorm" value="<?=$dorm?>">

					<label class="col-sm-1 control-label">日期</label>
					<div class="col-sm-2">
						<input class="form-control" type="text" id="datepicker1" id="strdate" placeholder="開始日期" style="width:100%" name="strdate" value="<?=$sdate?>">
					</div>
					<div class="col-sm-2">
						<input class="form-control" type="text" id="datepicker2" id="enddate" placeholder="結束日期" style="width:100%" name="enddate" value="<?=$edate?>">
					</div>
					
					<div class="col-md-1 pull-right">
						<a href="roomEngine.php" class="btn btn-danger" style="width:100%">清除</a>
					</div>
					<div class="col-md-1 pull-right">
						<button type="submit" class="btn btn-primary" style="width:100%" name="searchsubmit">搜尋</button>
					</div>
					
				</div>
				
				<div class="form-group">
					
					<div class="form-inline">
						<label for="inputPassword3" class="col-sm-1 control-label">價格</label>
						<div class="form-inline col-sm-2">
							<input class="form-control" type="text" id="strdate" placeholder="價格下限" style="width:100%" name="lower" value="<?=$lower?>">
						</div>
						<div class="form-inline col-sm-2">
							<input class="form-control" type="text" id="strdate" placeholder="價格上線" style="width:100%" name="upper" value="<?=$upper?>">
						</div>
						<label for="inputPassword3" class="col-sm-1 control-label">日期快捷</label>
						<div class="col-sm-4">
							<a href="#" class="btn btn-sm btn-default" onclick="syearchange(<?=$syear?>,0)"><?=$syear-1?>學年度</a>
							<a href="#" class="btn btn-sm btn-default" onclick="syearchange(<?=$syear+1?>,0)"><?=$syear?>學年度</a>
							<a href="#" class="btn btn-sm btn-default" onclick="syearchange(<?=$year?>,1)"><?=$year?>年暑假</a>
						</div>

					</div>					
				</div>
				<div class="form-group">
					
					<div class="form-inline">
						
						<label for="inputPassword3" class="col-sm-1 control-label">類型</label>
						<div class="col-sm-4">
							<div class="radio">
								<label>
									<input type="radio" name="type" value="1" <?=($type==1)?'checked':''?>> 全部
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="type" value="2" <?=($type==2)?'checked':''?>> 雅房
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="type" value="3" <?=($type==3)?'checked':''?>> 套房
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="type" value="4" <?=($type==4)?'checked':''?>> 公寓
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="type" value="5" <?=($type==5)?'checked':''?>> 透天
								</label>
							</div>
						</div>

					</div>					
				</div>
			</form>	
	<hr>
			<!-- 搜尋結果 -->

	<div class="table-responsive">
		<table class="table table-hover" >
			
				<thead>
					<tr>
						<th>#</th>
						<th>學生姓名</th>
						<th>宿舍</th>
						<th>房號</th>
						<th>合約開始</th>
						<th>合約結束</th>
						<th>遷入日期</th>
						<th>遷出日期</th>
						<th style="width:5%">詳細</th>
					</tr>
				</thead>
				<tbody id="result_table">



		
				</tbody>
		</table>
	</div>


	
</div>
</div>

