		<br>
		<table cellpadding="1" cellspacing="1" border="0" style="text-align:left;width:<?=$wu*100/100?>">
			<tr >
				<td style="width:<?=$wu*90/100?>"></td>
				<td style="width:<?=$wu*10/100?>"><img style="width:60px; height:60px" src="http://chart.apis.google.com/chart?chs=100x100&chld=S|1&cht=qr&chl=<?=$barcodetext?>"></td>
			</tr>
		
		</table>
		<table cellpadding="1" cellspacing="1" border="0" style="text-align:left;width:<?=$wu*100/100?>">
			<tr>
				<td style="width:<?=$wu*18/100?>">立契約書人：</td>
				<td style="width:<?=$wu*36/100?>">出租人：</td>
				<td style="width:<?=$wu*36/100?>">（以下簡稱為甲方）</td>
				<td style="width:<?=$wu*10/100?>"><p style="font-size:7px"><?=$barcodetext?></p></td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td></td>
				<td>承租人如下表</td>
				<td>（以下簡稱為乙方）</td>
				<td></td>
			</tr>
		</table>
		<br>
		<table cellpadding="1" cellspacing="1" border="1px" style="width:<?=$wu*100/100?>;text-align:center;">
			<tr style="text-align:center">
				<th style="width:<?=$wu*5/100?>" rowspan="1">編號</th>
				<th  style="width:<?=$wu*25/100?>" rowspan="1">承租人</th>
				<th  style="width:<?=$wu*25/100?>">身分證字號</th>
				<th style="width:<?=$wu*20/100?>">出生年月日</th>
				<th style="width:<?=$wu*(1-75/100)?>">手機</th>
				<!-- <th style="width:<?=$wu*14/100?>">住家電話</th>
				<th style="width:<?=$wu*13/100?>">緊急聯絡人</th>
				<th style="width:<?=$wu*14/100?>">聯絡電話</th> -->
			</tr>
			<!-- <tr>
				<td  colspan="3">戶籍地址</td>
				<td  colspan="3">通訊地址</td>
			</tr> -->
			<?php foreach ($data as $key => $datum): ?>
				<tr style="text-align:center">
					<td rowspan="1"><?=$key+1?></td>
					<td rowspan="1"><?=($datum['sname'])?></td>
					<td><?=ucwords(trim($datum['id_num']))?></td>
					<td>民<?=(trim((new DateTime($datum['birthday']))-> modify('-1911 year') -> format('Y-m-d'),'0'))?></td>
					<td><?=($datum['mobile'])?></td>
					<!-- <td><?=($datum['home'])?></td>
					<td><?=($datum['emg_name'])?></td>
					<td><?=($datum['emg_phone'])?></td> -->
				</tr>
				<!-- <tr>
					<td  colspan="3"><?=($datum['reg_address'])?>&nbsp;</td>
					<td  colspan="3"><?=($datum['mailing_address'])?>&nbsp;</td>
				</tr> -->
			<?php endforeach ?>
		</table>
	
	
	<p style="font-weight:bold">茲因房屋租賃事件，雙方合意訂立本契約，約款如下：</p>
	<p style="font-weight:bold">第一條：租賃範圍</p>
	<table cellpadding="1" cellspacing="1" border="1px" style="width:<?=$wu*100/100?>;text-align:left;">
		<tr>
			<td style="width:<?=$wu*25/100?>;text-align:center" >房屋所在地使用範圍</td>
			<td style="width:<?=$wu*75/100?>" colspan="2"><?=$data[0]['location'].'('.$data[0]['dname'].'宿舍)'.'-'.$data[0]['rname']?>房</td>
			
		</tr>
		<tr>
			<td style="width:<?=$wu*25/100?>;text-align:center" rowspan="3">使用設備</td>
			<td style="width:<?=$wu*75/100?>" colspan="2">床、床頭櫃、衣櫃、書櫃、書桌、電腦桌、椅子、冷氣、冷氣遙控器、免費提供衛星電視及網路線路、依宿舍規定公用或自用冰箱、電視</td>
		</tr>
		<tr>
			<td style="width:<?=$wu*10/100?>;text-align:center">房門鑰匙</td>
			<td style="width:<?=$wu*65/100?>">x1</td>

		</tr>
		<tr>
			<td style="width:<?=$wu*10/100?>;text-align:center">大門磁卡</td>
			<td style="width:<?=$wu*65/100?>">x1</td>

		</tr>
	</table>

	<p style="font-weight:bold">第二條：租賃期間</p>
	<table cellpadding="1" cellspacing="1" border="1px" style="width:<?=$wu*100/100?>;text-align:left;">
		<tr>
			<td style="width:<?=$wu*18/100?>; text-align:center;">開始日期</td>
			<td style="width:<?=$wu*32/100?>">民國<?=(date('Y', strtotime($data[0]['s_date']))-1911)?>-<?=date('m-d', strtotime($data[0]['s_date']))?></td>
			<td style="width:<?=$wu*18/100?>; text-align:center;">中止日期</td>
			<td style="width:<?=$wu*32/100?>">民國<?=(date('Y', strtotime($data[0]['e_date']))-1911)?>-<?=date('m-d', strtotime($data[0]['e_date']))?></td>
		</tr>
		
		<tr>
			<td style="width:<?=$wu*18/100?>; text-align:center;">共計</td>
			<td  style="width:<?=$wu*82/100?>" colspan="3">共<?=$countday['mib']?>個月又<?=$countday['rod']?>天，總天數<?=$countday['td']?>天</td>
			<?php 
			 ?>
		</tr>
	</table>

	<p style="font-weight:bold">第三條：租金與額外費用</p>
	<table cellpadding="1" cellspacing="1" border="1px" style="width:<?=$wu*100/100?>;text-align:left;">
		<tr>
			<td style="width:<?=$wu*8/100?>;text-align:center" >#</td>
			<td style="width:<?=$wu*25/100?>;text-align:center" >類型</td>
			<td style="width:<?=$wu*12/100?>;text-align:center" >+/-</td>
			<td style="width:<?=$wu*25/100?>;text-align:center" >金額</td>
			<td style="width:<?=$wu*30/100?>;text-align:center" >描述</td>			
		</tr>
		<?php $total = 0; ?>
		<?php foreach ($rent_list as $key => $value) { ?>
			
				<?php 
					switch ($value['type']) {
						case '1':
							$value['type_name'] = '租金';
							break;
						case '2':
							$value['type_name'] = '額外';
							break;
						
						case '3':
							$value['type_name'] = '獎勵';
							break;
						case '4':
							$value['type_name'] = '其他+';
							break;
						case '5':
							$value['type_name'] = '其他-';
							break;
						
						
						default:
							$value['type_name'] = '';
							break;

					}
					$total += (($value['pm']==1)?1:-1)*$value['value'];
				 ?>
			<tr>
				<td style="width:<?=$wu*8/100?>;text-align:center" ><?=$key+1?></td>
				<td style="width:<?=$wu*25/100?>;text-align:center" ><?=$value['type_name']?></td>
				<td style="width:<?=$wu*12/100?>;text-align:center" ><?=(($value['pm']==1)?'+':'-')?></td>
				<td style="width:<?=$wu*25/100?>;text-align:center" ><?=$value['value']?></td>
				<td style="width:<?=$wu*30/100?>;text-align:center" ><?=$value['description']?></td>			
			</tr>	
		<?php } ?>
		<tr>
			<td style="width:<?=$wu*8/100?>;text-align:center" >合計</td>
			<td style="width:<?=$wu*25/100?>;text-align:center" >應繳總額</td>
			<td style="width:<?=$wu*12/100?>;text-align:center" ></td>
			<td style="width:<?=$wu*25/100?>;text-align:center" ><?=$total?></td>
			<td style="width:<?=$wu*30/100?>;text-align:center" ></td>			
		</tr>	
	</table>
	<table cellpadding="1" cellspacing="1" border="0" style="width:<?=$wu*100/100?>;text-align:left;">
		<tr>
			<td style="width:<?=$wu*5/100?>"></td>
			<td style="width:<?=$wu*95/100?>" >租金全額未稅總共<?=$total?>元整（以下同)。若日後於租屋期間有額外費用，則另列表計算。</td>
		</tr>
		<tr>
			<td style="width:<?=$wu*5/100?>"></td>
			<td style="width:<?=$wu*95/100?>" >註：房屋租金未稅每人每月總共<?=$data[0]['rent']?>元整，共<?=$countpeo?>人，每月總共新台幣<?=$data[0]['rent']*$countpeo?>元整（以下同)。總共需付新台幣<?=$rent['rent_result']['total_rent']?>元整。</td>
		</tr>

	</table>
	<p style="font-weight:bold">本頁為電腦自動列印之合約資料頁，其餘條款羅列於後(共十五條)，並請於每頁簽名以示效力</p>
	