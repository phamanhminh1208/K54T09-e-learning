<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright 
* @license by MinhPA
**/

?>

<div id="page-content">
	<h2 id="page-title" align="center">ホームページ</h2>
	
	<div align="right">
		<button class="btn btn-primary"> 抹消 </button>
		<button class="btn btn-primary"> 警告リスト </button>
	</div>
	
	<p align="left" style="font-weight:bold; color:#0000CC">勉強している授業</p>
	<table width="100%" border="1" class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th class="col-sm-1">
					順番
					<span style="display:block;">
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
					</span>
				</th>
				
				<th class="col-sm-6">
					授業
					<span style="display:block;">
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
					</span>
				</th>
				
				<th class="col-sm-2">
					受けた時間
					<span style="display:block;">
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
					</span>
				</th>
				
				<th class="col-sm-2">
					終わり時間
					<span style="display:block;">
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
					</span>
				</th>
				
				<th class="col-sm-1">
					<span style="display:block;"></span>
				</th>
			</tr>
		</thead>
		
		<tbody>
			<tr style="background: #FFF">
				<td>1</th>
				<td><a href="#">授業１</a></td>
				<td>2013/12/05 16:00:00</td>
				<td>2013/12/12 16:00:00</td>
				<td><input class="btn btn-primary" value="通報" type="button"></td>
			</tr>
			<tr style="background: #FFFde5">
				<td>1</th>
				<td><a href="#">授業２</a></td>
				<td>2013/12/06 18:10:00</td>
				<td>2013/12/13 18:10:00</td>
				<td><input class="btn btn-primary" value="通報" type="button"></td>
			</tr>
			<tr style="background: #FFF">
				<td>3</th>
				<td><a href="#">授業3</a></td>
				<td>2013/12/08 16:00:00</td>
				<td>2013/12/15 16:00:00</td>
				<td><input class="btn btn-primary" value="通報" type="button"></td>
			</tr>
			<tr style="background: #FFFde5">
				<td>4</th>
				<td><a href="#">授業4</a></td>
				<td>2013/12/07 18:10:00</td>
				<td>2013/12/14 18:10:00</td>
				<td><input class="btn btn-primary" value="通報" type="button"></td>
			</tr>
		</tbody>
	</table>
	
	<div class="paging btn-group">
		<span class="prev disabled btn">前へ</span><span class="disabled btn">1</span>
		<span class="btn"><a href="/circle_schedule/person/index/page:2">2</a></span>
		<span class="btn"><a href="/circle_schedule/person/index/page:3">3</a></span>
		<span class="btn"><a href="/circle_schedule/person/index/page:2" rel="next">次へ</a></span>
	</div>
	<br>
	
	<div align="right">
		<button class="btn btn-primary">受けた授業リスト </button>
		<button class="btn btn-primary">受けたテスト・リスト </button>
	</div>
	<hr>
	
	<p align="left" style="font-weight:bold; color:#0000CC">課金ファイル</p>
	<table width="40%">
		<tr>
			<th>ファイルを作成の月</th>
			<td width="40%">
				<select class="input_txt">
					<option>2013/11</option>
					<option>2012/10</option>
				</select>
			</td>
			<td style="border: 0px;">
				<button class="btn btn-primary">課金情報 </button>
			</td>
		</tr>
  </table>
</div>