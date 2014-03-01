<?php
	echo $this->Html->script('moment.min');
	echo $this->Html->script('bootstrap-datetimepicker.min');
	echo $this->Html->css('bootstrap-datetimepicker.min');
?>

<div id="page-content">
	<h2 id="page-title" align='center'>学生登録</h2>
	
	<?php
		echo $this->Form->create('Student', array(
			'type'				=>	'post',
			'inputDefaults'		=>	array(
				'label'				=>	false,
				'div'				=>	false,
			)
		));
	?>
	<table width="100%" id="register-form">
		<tr>
			<th class="col-sm-3" style="text-align:right;">氏名</th>
			<td class="col-sm-9">
				<?php echo $this->Form->input('RealName', array(
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
			  <?php echo $this->Form->input('Username', array(
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
				<?php echo $this->Form->input('Password', array(
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
				<?php echo $this->Form->input('RetypePass', array(
									'type'			=>	'password',
									'class'			=>	'input_txt w_300',
									'placeholder'	=>	'パスワードを再入力',
									'size'			=>	"30%"	
						)); 
				?>
				<strong class="required">※必須</strong>
			</td>
		</tr>
		<tr>
			<th style="text-align:right;">生年月日</th>
			<td>
				<div class="input-group date col-sm-4">
					<?php echo $this->Form->input('Birthday', array(
										'class'			=>	'input_txt w_300 form-control',
										'placeholder'	=>	'YYYY/MM/DD',
										'size'			=>	"30%",
										'data-format'	=>	"YYYY/MM/DD"
							)); 
					?>
					<span class="input-group-addon" style='padding: 0px; background-color: inherit; border-width: 0px;'>
						<?php echo $this->Html->image('ico_calendar.png'); ?>
	                </span>					
				</div>	
							
			</td>
		</tr>
		<tr>
			<th style="text-align:right;">メール</th>
			<td>
			  	<?php echo $this->Form->input('Email', array(
									'type'			=>	'email',
									'class'			=>	'input_txt w_300',
									'placeholder'	=>	'メール',									
						)); 
				?>
			</td>
		</tr>
		<tr>
			<th style="text-align:right;">住所</th>
			<td>
		  		<?php echo $this->Form->input('Address', array(
									'class'			=>	'input_txt w_300',
									'placeholder'	=>	'住所',									
						)); 
				?>				
			</td>
		</tr>
		<tr>
			<th style="text-align:right;">電話番号</th>
			<td>
				<?php echo $this->Form->input('PhoneNum', array(
									'class'			=>	'input_txt w_300',
									'placeholder'	=>	'電話番号',
						)); 
				?>				
			</td>
		</tr>
		<tr>
			<th style="text-align:right;">クレジットカード情報</th>
			<td>
				<?php echo $this->Form->input('CreditCardNum', array(
									'class'			=>	'input_txt w_300',
									'placeholder'	=>	'00000000-0000-0000-0000-0000',
						)); 
				?>
				<strong class="required">※必須</strong>
			</td>
		  
		</tr>		
	</table>
	
	<br>
	
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
		$('#TeacherRealName').focus();	
		$(function() {        
	        $('.input-group').datetimepicker({
				pickTime: false			
	        });
	    });
	</script>
</div>