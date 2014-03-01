<?php
	
?>

<div id="page-content">
	<h2 id="page-title" align='center'>管理者追加</h2>
	
	<?php
		echo $this->Form->create('Manager', array(
			'type'				=>	'post',
			'inputDefaults'		=>	array(
				'label'				=>	false,
				'div'				=>	false,
			),
			//'novalidate'		=>	true,
		));
	?>
	<table width="100%" id="register-form">	
		<tr>
			<th class="col-sm-3" style="text-align:right;">氏名</th>
			<td class="col-sm-9">
				<?php echo $this->Form->input('User.RealName', array(
									'class'			=>	'input_txt w_300',
									'placeholder'	=>	'氏名',
									'autofocus'		=>	true,
									'size'			=>	"30%"	
						)); 
				?>				
				<strong class="required">※必須</strong>
			</td>
		</tr>
		
		<tr>
		  <th style="text-align:right;">ユーザー名</th>
		  <td>
			  <?php echo $this->Form->input('User.Username', array(
									'class'			=>	'input_txt w_300',
									'placeholder'	=>	'ユーザー名',									
									'size'			=>	"30%"	
						)); 
				?>
			  <strong class="required">※必須</strong>
		  </td>
		</tr>
		<tr>
		  	<th style="text-align:right;">初期パスワード</th>
		  	<td>
				<?php echo $this->Form->input('User.Password', array(
									'type'			=>	'password',
									'class'			=>	'input_txt w_300',
									'placeholder'	=>	'初期パスワード',
									'size'			=>	"30%"	
						)); 
				?>
		  		<strong class="required">※必須</strong>
		  	</td>
		</tr>
		<tr>
		  	<th style="text-align:right;">パスワードを再入力</th>
		  	<td>
				<?php echo $this->Form->input('User.RetypePass', array(
									'type'			=>	'password',
									'class'			=>	'input_txt w_300',
									'placeholder'	=>	'パスワードを再入力',
									'size'			=>	"30%"	
						)); 
				?>
				<strong class="required">※必須</strong>
			</td>
		</tr>
	</table>
	
	<br/	>
	
	<div align="center">
		<?php
			/* start 送信する button */
			echo $this->Form->end(array(
				'class'	=>	'btn btn-primary',
				'label'	=>	'送信する',
				'div'	=>	false,
				'style'	=>	'margin-right: 5px;	'
			));
			/* end 送信する button */
			
			/* start 再入力する button */
			//echo "<a class='btn btn-primary' style='margin-right:5px;' onclick='clearInput();'>再入力する</a>";
			echo $this->Form->button('再入力する', array(
				'class'	=>	'btn btn-primary',
				'type'	=>	'reset',
				'div'	=>	false,
				'style'	=>	'margin-right: 5px;'
			));
			/* end 再入力する button */
			
			/* start キャンセル button */
			echo "<a class='btn btn-primary' href='".
						Router::url(array('controller'=>'users', 'action'=>'login')).
				"'>キャンセル</a>";
			/* end キャンセル button */
		?>
	</div>
	<div>
		<?php echo $this->Session->flash(); ?>	
	</div>
	
	<script type="text/javascript">
		$('#ManagerUsername').focus();
	</script>
</div>