<?php

?>

<div style="height:30px;"></div>
<div id="error-message-handler" class="alert alert-danger">
	<h2>アクセスできない。</h2>
	<div>あなたはその機能を使うことができない。</div	>

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
		$btn_txt = "ホームページへ行く";
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
