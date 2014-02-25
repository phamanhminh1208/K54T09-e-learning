<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright by MinhPA
* @license 
**/

?>

<div id="page-content">
	<h2 id="page-title" align="center">ホームページ</h2>
	
	<div align="right">
		<button class="btn btn-primary"> 抹消 </button>
		<button class="btn btn-primary"> 警告リスト </button>
	</div>
	
	<p align="left" style="font-weight:bold; color:#0000CC">授業リスト</p>
	<table width="100%" border="1" class="table table-bordered table-hover table-striped">
		<thead>
			<tr class="frame">
				<th class="col-sm-1" style="text-align: center;">
					順番 
					<div>&nbsp;</div>
				</th>
				
				<th class="col-sm-6" style="text-align: center;">
					授業<br/>
					<?php echo $this->Html->link(
										$this->Html->image('btn_down.png', array('alt'=>'up', 'width'=>'16', 'height'=>'16')),
										'#',
										array('target' => '_blank', 'escape' => false)
								);
							echo $this->Html->link(
										$this->Html->image('btn_up.png', array('alt'=>'up', 'width'=>'16', 'height'=>'16')),
										'#',
										array('target' => '_blank', 'escape' => false)
								);?>
				</th>
				
				<th class="col-sm-2" style="text-align: center;">
					作った時間<br/>
					<?php echo $this->Html->link(
										$this->Html->image('btn_down.png', array('alt'=>'up', 'width'=>'16', 'height'=>'16')),
										'#',
										array('target' => '_blank', 'escape' => false)
								);
							echo $this->Html->link(
										$this->Html->image('btn_up.png', array('alt'=>'up', 'width'=>'16', 'height'=>'16')),
										'#',
										array('target' => '_blank', 'escape' => false)
								);?>
				</th>
				
				<th class="col-sm-2" style="text-align: center;">
					受けた学生<br/>
					<?php echo $this->Html->link(
										$this->Html->image('btn_down.png', array('alt'=>'up', 'width'=>'16', 'height'=>'16')),
										'#',
										array('target' => '_blank', 'escape' => false)
								);
							echo $this->Html->link(
										$this->Html->image('btn_up.png', array('alt'=>'up', 'width'=>'16', 'height'=>'16')),
										'#',
										array('target' => '_blank', 'escape' => false)
								);?>
				</th>
				
				<th class="col-sm-1">
					<span style="display:block;"></span>
				</th>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<td>1</td>
				<td><a href="#">授業１</a></td>
				<td>2013/11/05 08:30:00</td>
				<td align="right">1110</td>
				<td><input class="btn btn-primary" value="変更" type="button"></td>
			</tr>
			<tr>
				<td>2</td>
				<td><a href="#">授業2</a></td>
				<td>2013/11/20 12:20:00</td>
				<td align="right">200</td>
				<td><input class="btn btn-primary" value="変更" type="button"></td>
			</tr>
			<tr>
				<td>3</td>
				<td><a href="#">授業3</a></td>
				<td>2013/11/06 08:30:00</td>
				<td align="right">117</td>
				<td><input class="btn btn-primary" value="変更" type="button"></td>
			</tr>
			<tr>
				<td>4</td>
				<td><a href="#">授業4</a></td>
				<td>2013/11/21 12:20:00</td>
				<td align="right">25</td>
				<td><input class="btn btn-primary" value="変更" type="button"></td>
			</tr>
		</tbody>
	</table>
			
	<div class="paging btn-group">
		<span class="prev disabled btn">前へ</span>
		<span class="disabled btn">1</span>
		<span class="btn"><a href="/circle_schedule/person/index/page:2">2</a></span>
		<span class="btn"><a href="/circle_schedule/person/index/page:3">3</a></span>
		<span class="btn"><a href="/circle_schedule/person/index/page:2" rel="next">次へ</a></span>
	</div>
	<br>
				
	<div align="right">
		<button class="btn btn-primary"> 授業を追加 </button>
	</div>
	<hr>
	
	<p align="left" style="font-weight:bold; color:#0000CC">課金ファイル</p>
	<table width="50%">
		<tr>
			<th>ファイルを作成の月</th>
			<td width="40%">
				<select class="input_txt">
					<option>2013/11</option>
					<option>2012/10</option>
				</select>
			</td>
			<td style="border: 0px;">
				<button class="btn btn-primary"> 課金情報 	></button>
			</td>
		</tr>
  </table>
  
</div>