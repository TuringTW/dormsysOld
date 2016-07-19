		<br>
		<table cellpadding="1" cellspacing="1" border="0" style="text-align:left;width:<?=$wu*100/100?>">
			<tr >
				<td style="width:<?=$wu*90/100?>"></td>
				<td style="width:<?=$wu*10/100?>"><img style="width:60px; height:60px" src="http://chart.apis.google.com/chart?chs=100x100&chld=S|1&cht=qr&chl=<?=$barcodetext?>"></td>
			</tr>

		</table>


			<br>
			<table cellpadding="1" cellspacing="1" border="0" style="text-align:left;width:<?=$wu*100/100?>">
				<tr >
					<td style="width:<?=$wu*8/100?>">茲收到&nbsp;</td>
					<td style="width:<?=$wu*25/100?>"><span align="center" style="font-size:20px;text-align:center;"><?=$data[0]['sname']?></span></td>
					<td style="width:<?=$wu*10/100?>">(承租人)</td>
					<td style="width:<?=$wu*20/100?>"><span align="center" style="font-size:20px;text-align:center;">租屋&nbsp;訂金</span></td>
					<td style="width:<?=$wu*10/100?>">新台幣</td>
					<td style="width:<?=$wu*15/100?>"><span style="font-size:20px;text-align:center;"><?=(isset($data[0]['res_deposit'])?$data[0]['res_deposit']:'0')?></span></td>
					<td style="width:<?=$wu*10/100?>">元整</td>
				</tr>
				<tr>
					<td style="width:<?=$wu*8/100?>"></td>
					<td style="width:<?=$wu*25/100?>"><span style="font-size:20px;text-align:center;"><?=($data[0]['mobile'])?></span></td>
					<td style="width:<?=$wu*8/100?>"></td>
					<td style="width:<?=$wu*25/100?>"><span style="font-size:16px;text-align:center;">（訂金恕不退還）</span></td>
				</tr>
				<tr >
					<td style="width:<?=$wu*15/100?>">本公司保留</td>
					<td style="width:<?=$wu*30/100?>"><?=$data[0]['location']?></td>
					<td style="width:<?=$wu*15/100?>">(<?=$data[0]['dname']?>宿舍)&nbsp;</td>
					<td style="width:<?=$wu*20/100?>" align="center">&nbsp;<?=$data[0]['rname']?>房</td>

				</tr>
				<tr><td></td></tr>
				<tr >
					<td style="width:<?=$wu*5/100?>"></td>
					<td style="width:<?=$wu*5/100?>">在</td>
					<td style="width:<?=$wu*15/100?>"><?=$data[0]['s_date']?></td>
					<td style="width:<?=$wu*5/100?>">到</td>
					<td style="width:<?=$wu*15/100?>"><?=$data[0]['e_date']?></td>
					<td style="width:<?=$wu*35/100?>">期間的優先租屋權利給此承租人</td>

				</tr>
				<tr><td></td></tr>
				<tr>
					<td style="width:<?=$wu*5/100?>"></td>
					<td style="width:<?=$wu*5/100?>">至</td>
					<td style="width:<?=$wu*25/100?>">&nbsp;<span style="font-size:20px;text-align:center;"><?=$data[0]['d_date']?></span></td>
					<td style="width:<?=$wu*20/100?>"><span style="font-size:20px;text-align:center;">下午五點整</span></td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td style="width:<?=$wu*5/100?>"></td>
					<td style="width:<?=$wu*45/100?>">請在此時之前繳交押金、完成簽約。</td>

				</tr>

				<hr>
				<tr >
					<td style="width:<?=$wu*8/100?>">戶名：</td>
					<td style="width:<?=$wu*10/100?>">蔡玉敏</td>
					<td style="width:<?=$wu*8/100?>">郵局：</td>
					<td style="width:<?=$wu*5/100?>">700</td>
					<td style="width:<?=$wu*8/100?>">局號：</td>
					<td style="width:<?=$wu*10/100?>">0031283</td>
					<td style="width:<?=$wu*8/100?>">帳號：</td>
					<td style="width:<?=$wu*10/100?>">0260798</td>
				</tr>
				<br>
				<tr >
					<td style="width:<?=$wu*8/100?>">手機：</td>
					<td style="width:<?=$wu*15/100?>">0927619822</td>
					<td style="width:<?=$wu*10/100?>">LineID：</td>
					<td style="width:<?=$wu*15/100?>">@aunttsai</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr>
					<td style="width:<?=$wu*10/100?>">甲方：</td>
					<td style="width:<?=$wu*20/100?>"></td>
					<td style="width:<?=$wu*10/100?>">經手人：</td>
					<td style="width:<?=$wu*20/100?>"></td>
					<td style="width:<?=$wu*10/100?>">承租人：</td>
					<td style="width:<?=$wu*20/100?>"></td>

				</tr>

			</table>

	<!-- <p style="font-weight:bold">本頁為電腦自動產生之合約資料頁，其餘條款羅列於後(共十五條)，並請於每頁簽名以示效力</p> -->
			<?php if (!isset($second)): ?>
				<p style="font-size:5px">
					&nbsp;
				</p>
			<?php endif; ?>


			<table cellpadding="1" cellspacing="1" border="0" style="text-align:left;width:<?=$wu*100/100?>">

				<tr >
					<td style="width:<?=$wu*70/100?>">
						<span align="left" style="font-size:15px;text-align:center;"><?=($barcodetext)?>-&nbsp;<?=$data[0]['dname']?>-&nbsp;<?=$data[0]['rname']?>-&nbsp;<?=$data[0]['sname']?>-&nbsp;<?=(isset($data[0]['res_deposit'])?$data[0]['res_deposit']:"0")?>元</span>
					</td>
					<td style="width:<?=$wu*10/100?>"><span align="center" style="font-size:10px;text-align:center;">下訂時間：&nbsp;</span></td>
					<td style="width:<?=$wu*20/100?>"><span align="center" style="font-size:10px;text-align:center;"><?=$data[0]['timestamp']?></span></td>
				</tr>
			</table>

			<?php if (!isset($second)): ?>
				<hr>
			<?php endif; ?>
