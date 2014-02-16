<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright by MinhPA
* @license 
**/

?>
<style type="text/css">			
	.login_register_form {
		width: 600px;
		margin: 20px auto;
		border: 1px solid #000;
		border-radius: 7px;
		box-shadow: 4px 4px 3px 0 #888;
		padding: 10px 0;
		background: #fff;
	}
	.login_register_form .tit {
		font-size: 30px;
		line-height: normal;
		text-align: center;
		font-weight: bold;
	}
	.login_register_form form {
		padding: 30px 30px;
	}
	.login_register_form form dl {
		margin: 0 auto;
		width: 300px;
	}
	.login_register_form dt {
		line-height: 30px;
		font-size: 18px;
		margin-bottom: 5px;
	}
	.login_register_form dd {
		margin-bottom: 15px;
	}
	.login_register_form .other {
		text-align: right;
	}
	.login_register_form input[type=text], input[type=password]	{
		margin: 0 auto;
		width: 300px;
	}
</style>
	
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
			<dd class="other">
				<input type="checkbox" align="right"> ログイン状態を保持する
			</dd>
			<dd>
				<?php echo $this->Session->flash(); ?>
			</dd>
			<dd class="other">
				<?php echo $this->Form->end(array(
						'class'=>'btn btn-primary',
						'label'=>'ログイン',
					))?>
			</dd>
		</dl>
	</div>
</div>