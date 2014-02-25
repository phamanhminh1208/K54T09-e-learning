<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('main');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-theme.min');
		echo $this->Html->css('jquery-ui-1.10.4.min');
		
		echo $this->Html->script('jquery-1.11.0.min');	
		echo $this->Html->script('jquery-ui-1.10.4.min');
		echo $this->Html->script('bootstrap.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');					
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>
		<div id="content">
			<?php	
					$allow = array(
						'login',
						'register',
						'registerSuccess',
						'locked',
						'verifycodeConfirm'
					);
					if(!$this->Session->check('User') && !in_array($this->action, $allow)){					
			?>
				<script type="text/javascript">
					window.location = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')); ?>";            
				</script>
			<?php
			}			
			?>
			<?php echo $this->Session->flash(); ?>
			<?php 
				if(!in_array($this->action, $allow)){
					echo $this->element("bar/top_panel"); 	
				}				
			?>
			
			<?php				
				if(file_exists("css/".$this->name.'/'.$this->action.".css")){
					echo $this->Html->css($this->name.'/'.$this->action);
				}
				
				if(file_exists("js/".$this->name.'/'.$this->action.".js")){
					echo $this->Html->script($this->name.'/'.$this->action);
				}
				
				echo $this->fetch('content'); 
			?>			
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php 
		echo $this->element('sql_dump'); 
		echo $this->Js->writeBuffer();
	?>
</body>
</html>
