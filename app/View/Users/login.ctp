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
	<div class="login_register_form">
		<h2 class="tit">ログイン</h2>
		<?php
			echo $this->Form->create('User', array(
					'type'				=>	'post',
					'inputDefaults'		=>	array(
						'label'				=>	false,
						'div'				=>	false,
					)
			));			
		?>
		<dl>
			<dt><label for="Username">ユーザー名</label></dt>
			<dd> 	
				<?php echo $this->Form->input('Username'); ?>
			</dd>
			<dt><label for="Password">パスワード</label></dt>
			<dd>
				<?php echo $this->Form->input('Password', array('type' => 'password')); ?>
			</dd>			
			
			<?php
				if($this->Session->check('Message.flash')){
					echo "<div class='alert alert-danger' id='error-message'>".
							$this->Session->flash()."</div>";
				}
			?>
			
			<dd class="other">
				<?php echo $this->Form->end(array(
						'class'=>'btn btn-primary',
						'label'=>'ログイン',
					))?>
			</dd>
		</dl>
		<p style="text-align: right; margin-right: 80px; font-size: 1.3em;">
			</b><a href="<?php echo Router::url(array(
								'controller'		=>	'users',
								'action'			=>	'register'
							)); ?>"><b>ユーザー登録</b></a>
		</p>
	</div>
</div>