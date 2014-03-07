<?php
if(isset($data)){
?>

<div id="page-content">
	<div id="verifycode">
		<h2 class="tit">Verifycode確認</h2>
		<h4 align="center" style="color: #d83927; margin-top: 20px;"><?php echo $reason; ?></h4>
		<div class="box_cont">
			<?php
				echo $this->Form->create('Teacher', array(
					'type'				=>	'post',
					'inputDefaults'		=>	array(
						'label'				=>	false,
						'div'				=>	false,
					)
				));
			?>
			
			<table width="100%">
				<tr>
					<th class='col-sm-4'>秘密の質問</th>
					<td class='col-sm-8'>						
						<?php
							echo $this->Form->input('SecretQuestion',array(								
								'value'			=> base64_decode($data['Teacher']['SecretQuestion']),
								'class'			=>	'input_txt',
								'disabled'		=>	'disabled',			
								'style'			=>	'width: 100%;'					
							));
						?>
					</td>
				</tr>
				<tr>
					<th>秘密の答え</th>
					<td>						
						<?php
							echo $this->Form->input('Answer', array(
								'class'			=>	'input_txt',
								'style'			=>	'width: 100%;'
							));
						?>	
					</td>
				</tr>
			</table>
			<br>
			<?php
				if($this->Session->check('Message.flash')){
					echo "<div class='alert alert-danger' style='text-align: center; font-size: 1.5em;'>".
							$this->Session->flash()."</div>";
				}
			?>
			<div align="right">				
				<?php
					echo $this->Form->end(array(
						'class'	=>	'btn btn-primary',
						'label'	=>	'確認',
						'div'	=>	false,						
					));
				?>
			</div>		
		</div>
	</div>
</div>
<?php
}
?>