<?php
	
?>
<div style="height:30px;"></div>
<div id="locked-form" class="alert alert-warning">
	<?php
		if($max_time_wrong_password==-1){
			echo "あなたのアカウントは一時的にロックされた。";
		}else{
			echo "あなたはログインしてみたのは ".$max_time_wrong_password."回をお過ごしましたから、一時的にロックされた。";
		}
	?>
	<br/>
	<a id="countdown_time"><?php echo $temp_lock_time; ?></a> 秒後、ロックロック終了すると、
	<?php
		if($UserType==User::_TYPE_TEACHER){
			echo " verifycode を一回確認してください。";
		}else{
			echo " ログインしてください。";
		}
	?>

	<script>
        var sec = <?php echo $temp_lock_time; ?>;
        var timer = setInterval(function() {
            if (sec == -1) {
                clearInterval(timer);
                $(location).attr('href', "<?php
											if($UserType==User::_TYPE_TEACHER){
												echo Router::url(array('controller'=>'teachers', 'action'=>'verifycodeConfirm',TeachersController::_REASON_TEMP_LOCKED));
											}else if($UserType==User::_TYPE_STUDENT){
												echo Router::url(array('controller'=>'users', 'action'=>'unTempLocked'));
											}else{
												echo Router::url(array('controller'=>'users', 'action'=>'unTempLocked'));
											}
										?>");
            }else{
                $('#countdown_time').text(sec--);
            }
        }, 1000);
    </script>
</div>
<div style="height:30px;"></div>