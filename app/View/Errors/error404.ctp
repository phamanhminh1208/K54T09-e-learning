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
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div style="height:30px;"></div>
<div id="error-message-handler" class="alert alert-danger">	
	<h2>エラー404</h2>
	<div>あなたの要求されたアドレス<?php echo ((isset($url))?(" ’".$url."’"):""); ?> <br/>はシステムで見つかりませんでした。</div	>

<?php
	$url = Router::url(array('controller'=>'users', 'action'=>'login'));
	$btn_txt = "ログインする";
	
	if($this->Session->check('User')){
		App::import('Model','User');
		
		$controller = "";
		switch($this->Session->read('User.UserType')){
			case User::_TYPE_MANAGER:
				$controller = "managers";
				break;
			case User::_TYPE_TEACHER:
				$controller = "teachers";
				break;
			case User::_TYPE_STUDENT:
				$controller = "students";
				break;
		}
		$url = Router::url(array('controller'=>$controller, 'action'=>'homepage'));
		$btn_txt = "ホームページを行く";
	}
?>
	
	<button type="button" class="btn btn-lg btn-primary">
		<?php echo $btn_txt; ?>
	</button>
    <script>
        $('.btn-primary').click(function(){
            $(location).attr('href', "<?php echo $url; ?>");
        });
    </script>

</div>
<div style="height:30px;"></div>
